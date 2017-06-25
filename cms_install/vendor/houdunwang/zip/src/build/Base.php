<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\zip\build;


use Alchemy\Zippy\Zippy;

class Base
{
    protected $link;

    public function __construct()
    {
        $this->link = Zippy::load();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->link, $name], $arguments);
    }
}