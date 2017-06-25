<?php

namespace houdunwang\framework\middleware;

use houdunwang\config\Config;
use houdunwang\middleware\build\Middleware;

/**
 * 控制器中间件
 * 如果是控制器访问时设置视图目录
 * Class Controller
 *
 * @package houdunwang\framework\middleware
 */
class Controller implements Middleware
{
    public function run($next)
    {
        if ($controller = \houdunwang\route\Route::getController()) {
            $path = str_replace(['controller', '\\'], ['view', '/'], $controller);

            \houdunwang\view\View::setPath(strtolower($path));
        } else {
            \houdunwang\view\View::setPath(Config::get('view.path'));
        }
        $next();
    }
}