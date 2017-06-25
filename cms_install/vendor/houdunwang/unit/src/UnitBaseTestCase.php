<?php

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\unit;

use PHPUnit\Framework\TestCase;
use Session;
use Response;

/**
 * 单元测试基础类
 * Class UnitBaseTestCase
 *
 * @package houdunwang\unit
 */
class UnitBaseTestCase extends TestCase
{
    use Route;

    /**
     * 分配SESSION数据
     *
     * @param $data
     *
     * @return $this
     */
    protected function withSession($data)
    {
        Session::batch($data);

        return $this;
    }

    /**
     * 检测状态码
     *
     * @param $code
     */
    protected function assertStatus($code)
    {
        $this->assertEquals($code, $this->getCode());
    }

    function __call($name, $arguments)
    {
    }
}