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

use houdunwang\cache\Cache;
use houdunwang\cart\Cart;
use houdunwang\config\Config;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::loadFiles('config');
    }

    public function testBase()
    {
        $data = [
            'id'      => 1, // 商品 ID
            'name'    => ' 后盾网 PHP 视频教程光盘 ',// 商品名称
            'num'     => 2, // 商品数量
            'price'   => 2, // 商品价格
            'options' => [],// 其他参数如价格、颜色、可以为数组或字符串
            'color'   => 'red',
            'size'    => 'L',
        ];
        $this->assertTrue(Cart::add($data));
        $sid  = '027c91341fd5cf4d2579b49c4b6a90da';
        $data = [
            'sid' => $sid,// 唯一 sid，添加购物车时自动生成
            'num' => 3,
        ];
        $this->assertTrue(Cart::update($data));

        $this->assertEquals(3, Cart::getTotalNums());

        $this->assertEquals(6, Cart::getTotalPrice());

        Cart::del($sid);
        $this->assertEquals(0, Cart::getTotalNums());
    }

    public function testFlush()
    {
        $data = [
            'id'      => 1, // 商品 ID
            'name'    => ' 后盾网 PHP 视频教程光盘 ',// 商品名称
            'num'     => 2, // 商品数量
            'price'   => 2, // 商品价格
            'options' => [],// 其他参数如价格、颜色、可以为数组或字符串
            'color'   => 'red',
            'size'    => 'L',
        ];
        Cart::add($data);
        Cart::flush();
        $this->assertEquals(0, Cart::getTotalNums());
    }
}