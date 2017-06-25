<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cache\build;

/**
 * 缓存处理接口
 * Interface InterfaceCache
 *
 * @package houdunwang\cache\build
 */
interface InterfaceCache
{
    /**
     * @return mixed
     */
    public function connect();

    /**
     * @param $name
     * @param $value
     * @param $expire
     *
     * @return mixed
     */
    public function set($name, $value, $expire);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function del($name);

    /**
     * @return mixed
     */
    public function flush();
}