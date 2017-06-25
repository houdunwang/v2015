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

class RestfulTest extends Common
{
    public function test_restful()
    {
        $res = Curl::get($this->api.'/photo');
        $this->assertEquals('index', $res);
    }
}