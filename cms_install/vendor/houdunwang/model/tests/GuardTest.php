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
use tests\models\ModelGuard;

class GuardTest extends TestCase
{
    public function setUp()
    {
        Config::loadFiles('tests/config');
        Db::execute('truncate model_guard');
    }

    public function test_add()
    {
        $model           = new ModelGuard();
        $data['title']   = 'hdcms';
        $data['click']   = 300;
        $data['addtime'] = time();
        $res             = $model->save($data);
        $this->assertTrue($res >= 1);
    }
}