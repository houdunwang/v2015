<?php namespace houdunwang\wechat;

use houdunwang\wechat\build\Base;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class WeChat
{
    //连接
    protected static $link;

    public function __call($method, $params)
    {
        if (is_null(self::$link)) {
            self::$link = new Base();
        }
        if (method_exists(self::$link, $method)) {
            return call_user_func_array([self::$link, $method], $params);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        static $link;
        if (is_null($link)) {
            $link = new static();
        }

        return call_user_func_array([$link, $name], $arguments);
    }
}