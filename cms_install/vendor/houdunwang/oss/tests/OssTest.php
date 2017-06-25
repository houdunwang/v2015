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
use houdunwang\oss\Oss;
use PHPUnit\Framework\TestCase;

/**
 * Class OssTest
 *
 * @package tests
 */
class OssTest extends TestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('tests/config');
    }

    /**
     * 上传文本
     */
    public function test_upload_test()
    {
        $object  = 'test2.txt';
        $content = 'houdunwang.com';
        $res     = Oss::putObject($object, $content);
        print_r($res);
        $this->assertArrayHasKey('oss-request-url', $res);
    }

    /**
     * 上传文件
     */
    public function test_upload_file()
    {
        $object   = '1-test-upload.jpg';
        $filePath = 'tests/1.jpg';
        $res      = Oss::uploadFile($object, $filePath);
        $this->assertArrayHasKey('path', $res);
    }
}