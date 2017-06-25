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
use houdunwang\db\Db;
use PHPUnit\Framework\TestCase;
use tests\models\ModelBase;

class BaseTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
        Db::execute('truncate model_base');
        $data = [
            ['title' => 'hdcms'],
            ['title' => 'hdphp'],
            ['title' => 'houdunwang'],
        ];
        foreach ($data as $d) {
            Db::table('model_base')->insert($d);
        }
    }

    public function test_get()
    {
        $model = ModelBase::where('id', 1)->first();
        $this->assertEquals('hdcms', $model['title']);
    }

    public function test_find()
    {
        $model = ModelBase::find(1);
        $this->assertEquals('hdcms', $model['title']);
    }

    public function test_toArray()
    {
        $model = ModelBase::find(1)->toArray();
        $this->assertEquals('hdcms', $model['title']);
    }

    public function test_add()
    {
        $Model = new ModelBase();
        //然后直接给数据对象赋值
        $Model['title'] = 'hdphp';
        //把数据对象添加到数据库
        $res = $Model->save();
        $this->assertTrue($res >= 1);
    }

    public function test_update()
    {
        $Model = ModelBase::find(2);
        //然后直接给数据对象赋值
        $Model['title'] = 'houdunwang';
        //把数据对象添加到数据库
        $res = $Model->save();
        $this->assertTrue($res);
    }

    public function test_touch()
    {
        $res = ModelBase::find(1)->touch();
        $this->assertTrue($res);
    }

    public function test_destory()
    {
        $model = ModelBase::find(3);
        //删除当前的数据对象
        $this->assertTrue($model->destory());

        $this->assertTrue(ModelBase::delete(5));

        $this->assertTrue(ModelBase::delete('2,3'));
    }
}