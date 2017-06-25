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
use tests\models\ModelFilter;

class FilterTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
        Db::execute('truncate model_filter');
    }

    public function test_filter()
    {
        $model          = new ModelFilter();
        $model['click'] = 99;
        $res            = $model->save();
        $this->assertTrue($res >= 1);
    }
}