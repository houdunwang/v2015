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

use houdunwang\config\Config;

class ConfigTest extends Base
{
    /**
     * @test
     */
    public function base()
    {
        Config::set('alipay.key.auth', 'houdunwang');
        $this->assertEquals(Config::get('alipay.key.auth'), 'houdunwang');
    }

    /**
     * @test
     */
    public function env()
    {
        $this->assertEquals(env('SESSION_DRIVER'), 'file');
    }

    public function testBatch()
    {
        Config::batch(['app.debug' => true, 'database.host' => 'localhost']);
        $this->assertTrue(Config::get('app.debug'));
    }

    public function testHas()
    {
        $this->assertTrue(Config::has('app.debug'));
    }

    public function testGet()
    {
        $this->assertTrue(Config::get('app.debug'));
    }

    public function testAll()
    {
        $this->assertInternalType('array', Config::all());
    }

    public function testGetExtName()
    {
        $config = Config::getExtName('database', ['write', 'read']);
        $this->assertFalse(isset($config['write']));
    }

    public function testCfunction()
    {
        $this->assertInternalType('array', c());
        $this->assertEquals(c('database.driver'), 'mysql');
    }
}