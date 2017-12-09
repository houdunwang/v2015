<?php namespace app\pay\controller;

use houdunwang\route\Controller;
use Request;
use system\model\Pay;

/**
 * 支付宝支付处理
 * Class AliPay
 *
 * @package app\site\controller
 */
class AliPay extends Controller
{
    use Base;

    /**
     * 发起支付
     *
     * @return mixed|string
     */
    public function pay()
    {
        $pay = Pay::where('tid', Request::get('tid'))->first();
        if (empty($pay)) {
            return message('定单不存在', url('member.index', [], 'ucenter'), 'info');
        }
        if ($pay['status'] == 1) {
            return message('定单已经支付', url('member.index', [], 'ucenter'), 'info');
        }
        //修改支付类型
        $pay['type'] = 'alipay';
        $pay->save();
        //发起支付
        Config::set('alipay.return_url', web_url()."/alipay/sync/{$pay['module']}/".SITEID);
        Config::set('alipay.notify_url', web_url()."/alipay/async/{$pay['module']}/".SITEID);
        $data = [
            //商户订单号，商户网站订单系统中唯一订单号，必填
            'WIDout_trade_no' => $pay['tid'],
            //订单名称，必填
            'WIDsubject'      => $pay['goods_name'],
            //商品描述，可空
            'WIDbody'         => $pay['body'],
            //付款金额单位元，必填
            'WIDtotal_amount' => $pay['fee'] * 1,
        ];
        \AliPay::PagePay($data);
    }

    /**
     * 同步通知
     *
     * @return mixed
     */
    public function sync()
    {
        //签名验证
        if (\AliPay::signCheck()) {
            //商户订单号
            $tid = htmlspecialchars($_GET['out_trade_no']);
            //支付宝交易号
            $pay_id = htmlspecialchars($_GET['trade_no']);
            $pay    = $this->updateOrderStatus($tid, $pay_id);

            return call_user_func_array([$this->getModule($pay['module']), 'sync'], [true, $pay['tid']]);
        } else {
            return call_user_func_array([$this->getModule($_GET['m']), 'sync'], [false, 0]);
        }
    }

    /**
     * 异步通知
     *
     * @return mixed
     */
    public function async()
    {
        //签名验证
        if (\AliPay::signCheck()) {
            //商户订单号
            $tid = $_POST['out_trade_no'];
            //支付宝交易号
            $pay_id = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'] == 'TRADE_SUCCESS';
            if ($trade_status) {
                $pay = $this->updateOrderStatus($tid, $pay_id);

                return call_user_func_array([$this->getModule($pay['module']), 'async'], [$trade_status, $pay['tid']]) ? 'success' : 'fail';
            }
        }

        return 'fail';
    }
}
