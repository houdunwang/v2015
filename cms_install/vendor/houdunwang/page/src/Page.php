<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\page;

use houdunwang\page\build\Base;

class Page
{
    protected static $link = null;

    public function __call($method, $params)
    {
        if (is_null(self::$link)) {
            self::$link = new Base();
        }

        return call_user_func_array([self::$link, $method], $params);
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