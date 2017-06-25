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

use houdunwang\config\Config;
use houdunwang\middleware\build\Middleware;

class Cli implements Middleware
{
    public function run($next)
    {
        \houdunwang\cli\Cli::setPath([
            'controller' => 'app',
            'middleware' => 'system/middleware',
            'model'      => 'system/model',
            'request'    => 'system/request',
            'migration'  => 'system/database/migrations',
            'seed'       => 'system/database/seeds',
            'service'    => 'system/service',
            'tag'        => 'system/tag',
        ]);
        \houdunwang\cli\Cli::setBinds(Config::get('cli'));
        if (RUN_MODE == 'CLI') {
            //执行命令行指令
            \houdunwang\cli\Cli::bootstrap();
            die;
        }
        $next();
    }
}