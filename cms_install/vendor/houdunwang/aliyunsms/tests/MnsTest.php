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

use houdunwang\aliyunsms\Sms;
use PHPUnit\Framework\TestCase;

class MnsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        \houdunwang\config\Config::loadFiles('tests/config');
    }

    public function test_send()
    {
        $data = [
            'sign'     => '后盾网',
            'template' => 'SMS_12840363',
            'mobile'   => \houdunwang\config\Config::get('aliyunsms.mobile'),
            'vars'     => ["code" => "9999", "product" => "hdphp@@"],
        ];
        $s    = Sms::send($data);
        $this->assertEquals(0, $s['errcode']);
    }
}