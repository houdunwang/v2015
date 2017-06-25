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

use houdunwang\zip\Zip;
use PHPUnit\Framework\TestCase;

class ZipTest extends TestCase
{
    public function test_create()
    {
        $archiveZip = Zip::create('storage/hd.zip', ['src', 'tests']);
        $this->assertTrue(is_object($archiveZip));
    }

    public function test_extract()
    {
        $archiveZip = Zip::open('storage/hd.zip')->extract('storage');
        $this->assertTrue(is_object($archiveZip));
    }
}