<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\aliyunsms;

class Sms
{
    protected $link;

    public function __call($method, $params)
    {
        if (is_null($this->link)) {
            $this->link = new Base();
        }
        if (method_exists($this->link, $method)) {
            return call_user_func_array([$this->link, $method], $params);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([new static(), $name], $arguments);
    }
}