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
use tests\models\ModelAuto;

class AutoTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
        Db::execute('truncate model_auto');
    }

    public function test_auto()
    {
        $model          = new ModelAuto();
        $model['title'] = "hdcms";
        $id             = $model->save();
        $this->assertTrue($id >= 1);
    }
}