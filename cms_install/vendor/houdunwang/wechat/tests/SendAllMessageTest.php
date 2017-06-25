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
 * 群发接口
 * Class SendAllMessageTest
 *
 * @package tests
 */
class SendAllMessageTest extends Common
{
    /**
     * 预览消息
     */
    public function todo_test_sendAll()
    {
        $data = [
            "filter"              => [
                "is_to_all" => true,
            ],
            "mpnews"              => [
                "media_id" => "vwkQqqBXrV7ND7wUu-tCnL4Lb6Zqb-MymQA7dZbt4rU",
            ],
            "msgtype"             => "mpnews",
            "send_ignore_reprint" => 0,
        ];
        $res  = WeChat::instance('message')->sendAll($data);
        $this->assertEquals(0, $res['errcode']);
    }

    /**
     * 预览消息
     */
    public function test_preview()
    {
        $data = [
            "touser"  => "oGiQGuMR-fR_WeD6gLRKnqgMxYGo",
            "mpnews"  => [
                "media_id" => "vwkQqqBXrV7ND7wUu-tCnL4Lb6Zqb-MymQA7dZbt4rU",
            ],
            "msgtype" => "mpnews",
        ];
        $res  = WeChat::instance('message')->preview($data);
        $this->assertEquals(0, $res['errcode']);
    }
    public function test_delAll(){
        $res  = WeChat::instance('message')->preview($data);
    }
}