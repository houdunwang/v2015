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


use houdunwang\tool\Tool;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testRand()
    {
        $s = Tool::rand(4);
        $this->assertEquals(4, strlen($s));
    }

    public function testGetSize()
    {
        $s = Tool::getSize(2000);
        $this->assertEquals('1.95 KB', $s);
    }

    public function testBatchFunction()
    {
        $s = Tool::batchFunctions(['strtolower', 'ucfirst'], 'hdPHp');
        $this->assertEquals('Hdphp', $s);
    }
}