<?php

namespace tests;

use houdunwang\config\Config;
use houdunwang\lang\Lang;
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
        Config::loadFiles('config');
    }

    public function testSet()
    {
        Lang::set('name', '向军');
        $this->assertEquals('向军', Lang::get('name'));
    }

    public function testGet()
    {
        $this->assertEquals('后盾网', Lang::get('web'));
    }
}