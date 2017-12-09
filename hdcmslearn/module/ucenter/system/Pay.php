<?php namespace module\ucenter\system;

use module\HdPay;
use system\model\Balance;
use system\model\CreditsRecord;

/**
 * 会员余额充值处理
 * Class Pay
 *
 * @package module\ucenter\system
 */
class Pay extends HdPay
{
    /**
     * 微信同步通知
     *
     * @param bool   $status true 支付状态
     * @param string $tid    定单编号
     *
     * @return mixed|string
     */
    public function sync($status, $tid)
    {
        if ($status) {
            $this->changeCredit($tid);

            return message('支付成功,系统将跳转到会员中心', url('member.index', [], 'ucenter'));
        } else {
            return message('支付成功,系统将跳转到会员中心', url('member/index', [], 'ucenter'), 'error');
        }
    }

    /**
     * 微信异步通知
     *
     * @param bool   $status true 支付状态
     * @param string $tid    定单编号
     *
     * @return bool
     */
    public function async($status, $tid)
    {
        if ($status) {
            return $this->changeCredit($tid);
        }
    }

    /**
     * 更改会员余额
     *
     * @param string $tid 定单号
     *
     * @return mixed
     */
    protected function changeCredit($tid)
    {
        //模块业务处理,防止异步与同步同时更改用户余额
        $model = Balance::getByTid($tid);
        if ($model['status'] == 0) {
            $model['status'] == 1;
            $model->save();
            $data = [
                'uid'        => v('member.info.uid'),
                'credittype' => 'credit2',
                'num'        => $model['fee'],
                'remark'     => '会员中心余额充值',
            ];

            return CreditsRecord::change($data);
        }
    }
}