<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests;

use houdunwang\wechat\WeChat;

/**
 * 二维码
 * Class QrCodeTest
 *
 * @package tests
 */
class QrCodeTest extends Common
{
    /**
     * 临时二维码
     *
     * @return mixed
     */
    public function test_qrcode_temporary()
    {
        $param = ['expire_seconds' => 100, 'scene_id' => 1,];
        $qr    = WeChat::instance('qrcode')->create($param);
        $this->assertTrue(isset($qr['ticket']));

        $res = WeChat::instance('qrcode')->getQrcode($qr['ticket']);
        $this->assertTrue(preg_match('/^http/i', $res) == 1);
    }

    /**
     * 永久二维码
     *
     * @return mixed
     */
    public function test_qrcode_createLimitCode()
    {
        $param = ['scene_id' => 1];
        $qr    = WeChat::instance('qrcode')->createLimitCode($param);

        $this->assertTrue(isset($qr['ticket']));
        $res = WeChat::instance('qrcode')->getQrcode($qr['ticket']);
        $this->assertTrue(preg_match('/^http/i', $res) == 1);
    }
}