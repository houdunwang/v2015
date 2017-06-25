<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cache;

use houdunwang\config\Config;

/**
 * 缓存处理基类
 * Class Cache
 *
 * @package houdunwang\cache
 */
class Cache
{
    //连接
    protected $link;

    //更改缓存驱动
    protected function driver($driver = null)
    {
        static $cache = [];
        $driver = $driver ?: Config::get('cache.driver');
        $driver = '\houdunwang\cache\\build\\'.ucfirst($driver);
        if ($driver == 'file' || ! isset($cache[$driver])) {
            $cache[$driver] = new $driver();
        }
        $this->link = $cache[$driver];
        $this->link->connect();

        return $this;
    }

    public function __call($method, $params)
    {
        if (is_null($this->link)) {
            $this->driver();
        }
        if (method_exists($this->link, $method)) {
            return call_user_func_array([$this->link, $method], $params);
        }

        return $this->link;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([new static(), $name], $arguments);
    }
}