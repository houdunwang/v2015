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

use houdunwang\container\Container;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testInstance()
    {
        Container::instance('app', new App());
        $this->assertEquals('success', Container::make('app')->show());
    }

    public function testSingle()
    {
        Container::single(
            'app',
            function () {
                return new App();
            }
        );
        $this->assertEquals('success', Container::make('app')->show());
    }

    public function testBind()
    {
        Container::bind(
            'app',
            function () {
                return new App();
            }
        );
        $this->assertEquals('success', Container::make('app')->show());

        $container = new \houdunwang\container\build\Base();
        $container->instance('app', new App());
        $this->assertEquals('success', $container['app']->show());
    }

    public function testCallFunction()
    {
        //调用函数
        $res = Container::callFunction(
            function (App $app) {
                return $app->show();
            }
        );
        $this->assertEquals('success', $res);
    }

    public function testCallMethod()
    {
        $res = Container::callMethod(App::class, 'show');
        $this->assertEquals('success', $res);
    }
}