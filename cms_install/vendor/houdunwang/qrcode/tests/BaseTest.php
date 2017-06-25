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

use houdunwang\qrcode\QrCode;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testBase()
    {
        $s = QrCode::save('http://houdunren.com', 'storage/qr.png');
        $this->assertTrue($s);
    }

    public function testDing()
    {
        //宽度
        $s = QrCode::width(500)
            //高度
            ->height(500)
            //背景颜色
            ->backColor(5, 10, 0)
            //前景颜色
            ->foreColor(55, 255, 110)
            ->save('http://houdunren.com', 'storage/qT.png');
        $this->assertTrue($s);
    }
}