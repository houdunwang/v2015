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
use houdunwang\wechat\WeChat;

/**
 * Class BaseTest
 *
 * @package tests
 */
class BaseTest extends Common
{
    /**
     * @var string
     */
    protected $api = "http://dev.hdcms.com/component/wechat/tests/app/App.php?action=";

    /**
     * 获取令牌
     */
    public function test_access_token()
    {
        $res = Curl::get($this->api.'getAccessToken');
        $this->assertTrue(is_string($res));
    }
}