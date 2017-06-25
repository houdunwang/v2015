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


use houdunwang\response\Response;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function test_ajax()
    {
        $data = ['a' => 1, 'b' => 2];
        $s    = Response::ajax($data);
        $this->assertEquals(json_encode($data), $s);

        $data = ['a' => 1, 'b' => 2];
        $s    = Response::ajax($data, 'xml');
        $this->assertEquals('<xml><a>1</a><b>2</b></xml>', $s);
    }
}