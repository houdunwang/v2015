<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\Cache;

/**
 * 缓存处理接口
 * Interface InterfaceCache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
interface InterfaceCache
{
    public function connect();

    public function set($name, $value, $expire);

    public function get($name);

    public function del($name);

    public function flush();
}