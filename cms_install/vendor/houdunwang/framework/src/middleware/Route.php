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
use Config;
use houdunwang\view\build\Base as ViewBase;
use Response;

class Route implements Middleware
{
    public function run($next)
    {
        if (RUN_MODE == 'HTTP') {
            Config::set('controller.app', Config::get('app.path'));
            Config::set('route.cache', Config::get('http.route_cache'));

            //解析路由
            require ROOT_PATH.'/system/routes.php';

            $content = \Route::bootstrap()->getContent();
            if (is_array($content)) {
                echo json_encode($content, JSON_UNESCAPED_UNICODE);
            } else if (preg_match('/^http(s?):\/\//', $content)) {
                echo go($content);
            } else {
                echo $content;
            }
        }
        $next();
    }
}