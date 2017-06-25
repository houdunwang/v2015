<?php

namespace tests;

use houdunwang\config\Config;
use houdunwang\middleware\Middleware;
use PHPUnit\Framework\TestCase;
use tests\web\AuthMiddleware;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class GlobalTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('config');
    }

    public function testGlobals()
    {
        $this->assertTrue(Middleware::globals());
    }

    public function testWeb()
    {
        Middleware::add('auth',[AuthMiddleware::class]);
        $this->assertTrue(Middleware::web('auth'));
    }
}