<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cache;

use Exception;

/**
 * Memcache缓存处理类
 * Class Memcache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class Memcache implements InterfaceCache
{

    protected $obj;

    public function __construct()
    {
        $this->connect();
    }

    //连接
    public function connect()
    {
        $conf = Config::get('cache.memcache');
        if ($this->obj = new Memcache())
        {
            $this->obj->addServer($conf['host'], $conf['port']);
        }
        else
        {
            throw new Exception("Memcache 连接失败");
        }
    }

    //设置
    public function set($name, $value, $expire = 3600)
    {
        return $this->obj->set($name, $value, 0, $expire);
    }

    //获得
    public function get($name)
    {
        return $this->obj->get($name);
    }

    //删除
    public function del($name)
    {
        return $this->obj->delete($name);
    }

    //删除缓存池
    public function flush()
    {
        return $this->obj->flush();
    }

}