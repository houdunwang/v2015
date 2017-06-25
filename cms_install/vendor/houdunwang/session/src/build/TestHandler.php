<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\session\build;

/**
 * 单元测试
 * Class TestHandler
 *
 * @package houdunwang\session\build
 */
class TestHandler implements AbSession
{
    use Base;

    //初始
    public function connect()
    {
        return true;
    }

    //读取
    public function read()
    {
        return [];
    }

    //写入
    public function write()
    {
        return true;
    }

    /**
     * SESSION垃圾处理
     *
     * @return boolean
     */
    public function gc()
    {
        return true;
    }
}
