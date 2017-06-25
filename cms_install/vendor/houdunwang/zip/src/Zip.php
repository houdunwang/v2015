<?php namespace houdunwang\zip;

use houdunwang\zip\build\Base;

class Zip
{
    //连接
    protected $link;

    public function __call($method, $params)
    {
        if (is_null($this->link)) {
            $this->link = new Base();
        }

        return call_user_func_array([$this->link, $method], $params);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([new static(), $name], $arguments);
    }
}