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


use houdunwang\request\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_set()
    {
        Request::set("get.a", 'sina');
        $this->assertEquals('sina', Request::get('a'));
    }

    public function test_is_method()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue(Request::isMethod('get'));
    }

    public function test_get_request_type()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $this->assertEquals('DELETE', Request::getRequestType());
    }
}