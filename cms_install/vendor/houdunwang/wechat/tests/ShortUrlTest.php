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
 * 长链接转短链接接口
 * Class ShortUrlTest
 *
 * @package tests
 */
class ShortUrlTest extends Common
{
    /**
     * 长链接转短链接接口
     */
    public function test_makeShortUrl()
    {
        $url
             = 'http://bbs.houdunwang.com/forum.php?mod=viewthread&tid=105786&extra=page%3D1%26filter%3Dlastpost%26orderby%3Dlastpost%26dateline%3D86400%26typeid';
        $res = WeChat::instance('shorturl')->makeShortUrl($url);
        $this->assertEquals('ok', $res['errmsg']);
    }
}