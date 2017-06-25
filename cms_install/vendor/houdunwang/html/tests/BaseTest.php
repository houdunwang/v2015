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


use houdunwang\html\Html;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testBase()
    {
        $data = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];
        foreach ($data as $d) {
            Html::make([App::class, 'show'], $d, "html/{$d['id']}.html");
        }
    }
}