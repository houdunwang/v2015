<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\framework\middleware;

use houdunwang\middleware\build\Middleware;

class App implements Middleware
{
    public function run($next)
    {
        $this->version();
        $next();
    }

    //框架版本
    protected function version()
    {
        define('HDPHP_VERSION', '3.0.105');
    }
}