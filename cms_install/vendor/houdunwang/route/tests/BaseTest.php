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

class BaseTest extends Common
{
    public function test_get()
    {
        $res = Curl::get($this->api);
        $this->assertEquals('root', $res);

        $res = Curl::get($this->api.'/show');
        $this->assertEquals('Hello HDPHP', $res);
    }

    public function test_post()
    {
        $res = Curl::post($this->api.'/user/add', ['user' => 'xj']);
        $this->assertEquals('xj', $res);
    }

    public function test_put()
    {
        $res = Curl::post($this->api.'/user/put',
            ['_method' => 'PUT', 'user' => 'xj']);
        $this->assertEquals('xj', $res);
    }

    public function atest_delete()
    {
        $res = Curl::post($this->api.'/user/delete',
            ['_method' => 'DELETE', 'user' => 'xj']);
        $this->assertEquals('xj', $res);
    }

    public function test_any()
    {
        $res = Curl::post($this->api.'/any',
            ['_method' => 'DELETE', 'user' => 'xj']);
        $this->assertEquals('any', $res);

        $res = Curl::post($this->api.'/any',
            ['_method' => 'PUT', 'user' => 'xj']);
        $this->assertEquals('any', $res);
    }

    public function test_where()
    {
        $res = Curl::get($this->api.'/user/1/hd');
        $this->assertEquals('1-hd', $res);
    }

}