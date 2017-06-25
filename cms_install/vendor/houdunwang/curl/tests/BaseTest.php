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

use houdunwang\curl\Curl;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testGet()
    {
        Curl::get('http://baidu.com');
        $this->assertEquals(200, Curl::getCode());

        Curl::post('http://baidu.com',[]);
        $this->assertEquals(200, Curl::getCode());
    }
}