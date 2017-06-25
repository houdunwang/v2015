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

class ControllerTest extends Common
{
    public function test_base()
    {
        $res = Curl::get($this->api.'/entry/show.html');
        $this->assertEquals('entry_show', $res);
    }

    public function test_controller_get()
    {
        $res = Curl::get($this->api.'/entry/index.html');
        $this->assertEquals('get_index', $res);
    }

    public function test_controll_post()
    {
        $res = Curl::post($this->api.'/entry/send.html',[]);
        $this->assertEquals('post_send', $res);
    }
}