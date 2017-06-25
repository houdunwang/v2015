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

use Exception;
use houdunwang\config\Config;

/**
 * Memcache
 * Class Memcache
 *
 * @package houdunwang\cache\build
 */
class Memcache implements InterfaceCache
{
    use Base;
    protected $link;

    //连接
    public function connect()
    {
        $conf = Config::get('cache.memcache');
        if ($this->link = new Memcache()) {
            $this->link->addServer($conf['host'], $conf['port']);
        } else {
            throw new Exception("Memcache 连接失败");
        }
    }

    //设置
    public function set($name, $value, $expire = 0)
    {
        return $this->link->set($name, $value, 0, $expire);
    }

    //获得
    public function get($name)
    {
        return $this->link->get($name);
    }

    //删除
    public function del($name)
    {
        return $this->link->delete($name);
    }

    //删除缓存池
    public function flush()
    {
        return $this->link->flush();
    }
}