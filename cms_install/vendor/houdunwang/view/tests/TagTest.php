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
use houdunwang\view\View;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('tests/config');
    }

    public function test_if()
    {
        View::with('a', 2);
        $res = View::make('tests/view/test_if.html');
        $this->assertEquals('ok', trim($res));
    }

    public function test_foreach()
    {
        View::with('a', ['name' => 'yahoo']);
        $res = View::make('tests/view/test_foreach.html');
        $this->assertEquals('yahoo', trim($res));
    }

    public function test_include()
    {
        $res = View::make('tests/view/test_include.html');
        $this->assertEquals('header.php', trim($res));
    }

    public function test_php()
    {
        $res = View::make('tests/view/test_php.html');
        $this->assertEquals('ok', trim($res));
    }

    public function test_css()
    {
        $res = View::make('tests/view/test_css.html');
        $css
             = '<link type="text/css" rel="stylesheet" href="tests/view/static/common.css"/>';

        $this->assertEquals($css, trim($res));
    }

    public function test_js()
    {
        $res = View::make('tests/view/test_js.html');
        $css
             = '<script type="text/javascript" src="view/css/common.js"></script>';

        $this->assertEquals($css, trim($res));
    }

    /**
     * 自定义标签
     */
    public function test_tag()
    {
        $res = View::make('tests/view/test_tag.html');

        $this->assertEquals('commonTag', trim($res));
    }

    /**
     * 自定义标签
     */
    public function test_extend()
    {
        $res = View::make('tests/view/test_extend.html');
        $this->assertEquals('这是主体内容', trim($res));
    }
}