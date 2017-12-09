<?php namespace app\pay\controller;

use houdunwang\request\Request;
use houdunwang\route\Controller;
use system\model\Pay;

/**
 * 网站支付处理
 * Class Pay
 *
 * @package web\site
 */
class WeChat extends Controller
{
    use Base;

    /**
     * 微信公众号支付
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
        $pay['type'] = 'wechat';
        $pay->save();
        //发起支付
        $data['total_fee']    = $pay['fee'] * 1;//支付金额单位分
        $data['body']         = $pay['body'];//商品描述
        $data['attach']       = $pay['attach'];//附加数据
        $data['out_trade_no'] = $pay['tid'];//会员定单号
        $data['notify_url']   = __ROOT__."/index.php/wechat/async/{$pay['module']}/".SITEID;//异步通知地址
        $res                  = \WeChat::instance('pay')->jsapi($data);

        return $this->sync($res);
    }

    /**
     * 同步通知
     *
     * @param array $notify
     * ['errcode'=>"success|error','out_trade_no'=>'定单号']
     *
     * @return mixed
     */
    public function sync(array $notify)
    {
        $status = $notify['errcode'] == 'success';
        //定单号
        $tid = $notify['out_trade_no'];
        $pay = Pay::getByTid($tid);
        if ($status) {
            //查询微信定单
            $res = WeChat::instance('pay')->orderQuery(['out_trade_no' => 1494906587]);
            $this->updateOrderStatus($tid, $res['transaction_id']);

            return call_user_func_array([$this->getModule($pay['module']), 'sync'], [$status, $tid]);
        }

        return call_user_func_array([$this->getModule($pay['module']), 'sync'], [$status, $tid]);
    }

    /**
     * 异步通知
     *
     * @return mixed
     */
    public function async()
    {
        //更新支付表状态
        $res    = WeChat::instance('pay')->getNotifyMessage();
        $status = $res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS';
        if ($status) {
            //商户定单号
            $tid = $res['out_trade_no'];
            //微信定单号
            $pay_id = $res['transaction_id'];
            $pay    = $this->updateOrderStatus($tid, $pay_id);

            //支付成功
            if (call_user_func_array([$this->getModule($pay['module']), 'async'], [true, $tid])) {
                $data = [
                    'return_code' => 'SUCCESS',
                    'return_msg'  => 'OK',
                ];
                die(Xml::toSimpleXml($data));
            }
        }
    }
}