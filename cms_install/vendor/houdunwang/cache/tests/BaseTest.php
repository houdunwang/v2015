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

use houdunwang\cache\Cache;
use houdunwang\config\Config;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('config');
    }

    public function testMysql()
    {
        Config::set('cache.driver', 'mysql');
        $this->testBase();

        d('f', 1);
        $this->assertEquals(1, d('f'));

        d('f','[del]');
        $this->assertNull(d('f'));

        d('z',3);
        d(null);
        $this->assertNull(d('z'));
    }

    public function testBase()
    {
        Cache::set('a', 1);
        Cache::set('b', 1);
        $this->assertEquals(Cache::get('a'), 1);

        Cache::del('a');
        $this->assertNull(Cache::get('a'));

        Cache::flush();
        $this->assertNull(Cache::get('b'));

        Cache::driver('file')->set('c', 1);
        $this->assertEquals('1', Cache::driver('file')->get('c'));

        Cache::dir('storage/data')->set('name', '后盾网');
        $this->assertEquals('后盾网', Cache::dir('storage/data')->get('name'));
    }

    public function testFunction()
    {
        f('a', 1);
        $this->assertEquals(1, f('a'));

        f('a', '[del]');
        $this->assertNull(f('a'));

        f('b', 1);
        f(null);
        $this->assertNull(f('b'));
    }
}