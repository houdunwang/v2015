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

class ViewTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('tests/config');
    }

    public function test_make()
    {
        $res = View::make('tests/view/make.html');
        $this->assertEquals('make.html', $res);
    }

    public function test_make_var()
    {
        $res = View::make('tests/view/make_var.html', ['name' => 'hd']);
        $this->assertEquals('hd', $res);
    }

    public function test_make_with()
    {
        View::with('uri', 'houdunwang');
        $res = View::make('tests/view/make_with.html');
        $this->assertEquals('houdunwang', $res);
    }

    public function test_at()
    {
        View::with('uri', 'houdunwang');
        $res = View::make('tests/view/make_at.html');
        $this->assertEquals('{{$uri}}', $res);
    }
}