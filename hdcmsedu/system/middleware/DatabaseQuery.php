<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;

class DatabaseQuery implements Middleware
{
    //执行中间件
    public function run($next)
    {
        $next();
    }
}