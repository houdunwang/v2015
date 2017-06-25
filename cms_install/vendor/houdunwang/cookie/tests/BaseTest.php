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

use houdunwang\cookie\Cookie;

class BaseTest extends Base
{
    public function testBase()
    {
        Cookie::set('a', 33);
        $this->assertEquals(Cookie::get('a'), 33);

        Cookie::set('b', 'bb');
        $this->assertCount(2, Cookie::all());

        $this->assertTrue(Cookie::has('a'));

        Cookie::del('a');
        $this->assertTrue(! Cookie::get('a'));

        Cookie::flush();
        $this->assertCount(0,Cookie::all());
    }
}