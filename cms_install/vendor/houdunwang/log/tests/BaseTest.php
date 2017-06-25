<?php

namespace tests;

use houdunwang\config\Config;
use houdunwang\log\Log;
use PHPUnit\Framework\TestCase;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::set('log.dir', 'log');
    }

    public function testWrite()
    {
        $s = Log::write('baidu.com', Log::ERROR);
        $this->assertTrue($s);
    }

    public function testRecord()
    {
        $s = Log::record('sina.com', Log::FATAL);
        $this->assertTrue($s);
    }
}