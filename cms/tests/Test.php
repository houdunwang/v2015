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

use houdunwang\unit\Application;
use houdunwang\unit\UnitBaseTestCase;

/**
 * 测试基础类
 * Class Base
 *
 * @package tests
 */
abstract class Test extends UnitBaseTestCase
{
    use Application;

    protected function setUp()
    {
        $this->create();
        parent::setUp();
    }

}