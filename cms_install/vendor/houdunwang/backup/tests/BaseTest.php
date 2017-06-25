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

use houdunwang\backup\Backup;
use houdunwang\config\Config;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('config');
    }

    public function testBackup()
    {
        $config = [
            'size' => 200,//分卷大小单位KB
            'dir'  => 'backup/'.date("Ymdhis"),//备份目录
        ];
        Backup::backup(
            $config,
            function ($result) {
                if ($result['status'] == 'run') {
                    $this->testBackup();
                } else {
                    $this->assertEquals('success', $result['status']);
                }
            }
        );
    }
}