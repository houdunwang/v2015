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

use houdunwang\session\Session;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function test_set_and_get()
    {
        Session::set('name', 'houdunwang');
        $this->assertEquals('houdunwang', Session::get('name'));
    }

    public function test_batch()
    {
        $config = [
            'app'    => 'hdphp',
            'driver' => [
                'file' => 'hd',
            ],
        ];
        Session::batch($config);
        $this->assertEquals('hdphp', Session::get('app'));
        $this->assertEquals('hd', Session::get('driver.file'));
    }

    public function test_flash()
    {
        Session::flash('name', 'houdunren');
        $this->assertEquals('houdunren', Session::flash('name'));
    }

    public function test_default()
    {
        $this->assertEquals('houdunren',
            Session::get('defaultSession', 'houdunren'));
    }

    public function test_has()
    {
        Session::set('hd', 'houdunren');
        $this->assertTrue(Session::has('hd'));
        $this->assertFalse(Session::has('hd2'));
    }

    public function test_del()
    {
        Session::set('hd', 'houdunren');
        Session::del('hd');
        $this->assertFalse(Session::has('hd'));
    }

    public function test_flush()
    {
        Session::set('url', 'houdunren');
        Session::set('address', 'hdphp');
        Session::flush();
        $this->assertFalse(Session::has('url') || Session::has('address'));
    }

    public function test_all(){
        Session::set('url', 'houdunren');
        Session::set('address', 'hdphp');
        $this->assertCount(2,Session::all());
    }
}