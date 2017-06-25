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

class ArgsTest extends Common
{
    public function test_mast()
    {
        $res = Curl::get($this->api.'/getUserId/2');
        $this->assertEquals(2, $res);
    }

    public function test_have()
    {
        $res = Curl::get($this->api.'/userInfo/jolly');
        $this->assertEquals('jolly', $res);

        $res = Curl::get($this->api.'/userInfo');
        $this->assertEquals('后盾网', $res);
    }

    public function test_any()
    {
        $res = Curl::get($this->api.'/yahoo');
        $this->assertEquals('yahoo', $res);

    }

    public function test_all()
    {
        $res = Curl::get($this->api.'/args/all/1-33');

        $eq = json_encode(['id' => 1, 'name' => 33], JSON_UNESCAPED_UNICODE);
        $this->assertEquals($eq, $res);
    }

    public function test_ioc()
    {
        $res = Curl::get($this->api.'/ioc/1/hd');
        $this->assertEquals('1后盾人hd', $res);
    }
}