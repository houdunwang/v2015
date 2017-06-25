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
 * 客服消息
 * Class CustomMessageTest
 *
 * @package tests
 */
class CustomMessageTest extends Common
{
    /**
     * 发送文本
     */
    public function test_text()
    {
        $data = [
            "touser"  => "oGiQGuMR-fR_WeD6gLRKnqgMxYGo",
            "msgtype" => "text",
            "text"    => [
                "content" => "Hello World",
            ],
        ];
        $res  = WeChat::instance('CustomService')->send($data);
        $this->assertEquals('ok', $res['errmsg']);
    }
}