<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use houdunwang\request\Request;
use system\model\Balance;
use system\model\Pay;

/**
 * 会员积分余额管理
 * Class Account
 *
 * @package module\ucenter\controller
 */
class Account extends Auth
{
    /**
     * 移动端微信公众号帐户充值
     *
     * @param \system\model\Balance $model
     * @param \system\model\Pay     $pay
     *
     * @return mixed|string
     */
    public function balance(Balance $model, Pay $pay)
    {
        if (IS_POST) {
            //设置余额充值记录
            $model->addRow(Request::post('fee'));
            //设置支付记录
            $data = [
                'tid'        => $model['tid'],
                'fee'        => $model['fee'],
                'goods_name' => '会员余额充值',
                'body'       => '会员余额充值',
            ];
            $res  = $pay->make($data);
            //生成支付记录后跳转到支付选择页面
            if ($res === true) {
                return url('account.pay', ['tid' => $model['tid']], 'ucenter');
            }

            return message($res, url('member.index', [], 'ucenter'), 'info');
        }

        return View::make($this->template.'/balance');
    }

    /**
     * 显示支付页面
     *
     * @return string
     */
    public function pay()
    {
        $pay = Pay::where('tid', Request::get('tid'))->first();

        return $this->view($this->template.'/pay', ['data' => $pay]);
    }
}