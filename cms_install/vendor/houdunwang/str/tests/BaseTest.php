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


use houdunwang\str\Str;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testPinyin()
    {
        $this->assertEquals('nihao',Str::pinyin('你好'));
    }

    public function testRemovePunctuation()
    {
        $this->assertEquals('你好',Str::removePunctuation('你好,'));
    }

    public function testToSemiangle()
    {
        $this->assertEquals('你好.',Str::toSemiangle('你好。'));
    }
}