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
use tests\models\ModelValidate;

class ValidateTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
        Db::execute('truncate model_validate');
    }

    public function test_validate()
    {
        $model           = new ModelValidate;
        $model->username = 'houdunren';
        $res             = $model->save();
        $error           = $model->getError();
        $this->assertFalse($res);
        $this->assertEquals($error[0], '年龄必须是数字');
        $model->age = 33;
        $res        = $model->save();
        $this->assertTrue($res >= 1);
    }

    public function test_user_validate()
    {
        $model           = new ModelValidate;
        $model->username = 'houdunwang';
        $model->age      = 78;
        $res             = $model->save();
        $this->assertTrue($res >= 1);
    }
}