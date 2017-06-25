<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\pay;

/**
 * 扫码支付
 * Trait QrPay
 *
 * @package houdunwang\wechat\build\pay
 */
trait QrPay
{
    /**
     * 模式二
     * 不需要在微信管理平台设置回调地址
     *
     * @param $data
     *
     * @return mixed
     */
    public function payByCode($data)
    {
        $data['trade_type']       = 'NATIVE';
        $data['spbill_create_ip'] = $_SERVER['SERVER_ADDR'];

        return $this->unifiedorder($data);
    }
}