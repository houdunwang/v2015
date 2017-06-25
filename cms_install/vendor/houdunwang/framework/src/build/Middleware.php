<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\framework\build;

use houdunwang\framework\middleware\App;
use houdunwang\framework\middleware\Cli;
use houdunwang\framework\middleware\Controller;
use houdunwang\framework\middleware\Cookie;
use houdunwang\framework\middleware\Csrf;
use houdunwang\framework\middleware\Globals;
use houdunwang\framework\middleware\Request;
use houdunwang\framework\middleware\Route;
use houdunwang\framework\middleware\Session;
use houdunwang\framework\middleware\View;
use houdunwang\framework\middleware\ViewParseFile;

/**
 * Class Middleware
 *
 * @package houdunwang\framework\build
 */
trait Middleware
{
    //中间件
    /**
     * @var array
     */
    protected $middlewarte
        = [
            App::class,
            Cli::class,
            Cookie::class,
            Session::class,
            Request::class,
            Csrf::class,
            View::class,
        ];

    /**
     * 执行中间件
     */
    protected function middleware()
    {
        $this->configMiddleware();
        $middleware = array_merge(
            $this->middlewarte,
            Config::get('middleware.global'),
            [Route::class]
        );
        $middleware = array_reverse($middleware);
        $dispatcher = array_reduce($middleware, $this->getSlice(), function () {});
        $dispatcher();
    }

    /**
     * @return \Closure
     */
    protected function getSlice()
    {
        return function ($next, $step) {
            return function () use ($next, $step) {
                return call_user_func_array([new $step, 'run'], [$next]);
            };
        };
    }

    /**
     *
     */
    protected function configMiddleware()
    {
        \houdunwang\middleware\Middleware::add('controller_start', [Controller::class]);
        \houdunwang\middleware\Middleware::add('view_parse_file', [ViewParseFile::class]);
    }
}