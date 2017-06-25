<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\middleware\build;

use houdunwang\arr\Arr;
use houdunwang\config\Config;
use houdunwang\route\Route;

class Base
{
    /**
     * 执行中间件
     *
     * @param $middleware
     *
     * @return bool
     */
    protected function exe($middleware)
    {
        $middleware = array_unique($middleware);
        $dispatcher = array_reduce(
            array_reverse($middleware),
            $this->callback(),
            function () {
            }
        );
        $dispatcher();

        return true;
    }

    /**
     * 装饰者闭包
     *
     * @return \Closure
     */
    protected function callback()
    {
        return function ($callback, $class) {
            return function () use ($callback, $class) {
                return call_user_func_array([new $class, 'run'], [$callback]);
            };
        };
    }

    /**
     * 执行控制器中间件
     *
     * @param       $name  中间件名称
     * @param array $mod   类型
     *                     ['only'=>array('a','b')] 仅执行a,b控制器动作
     *                     ['except']=>array('a','b')], 除了a,b控制器动作
     *
     * @return bool
     */
    public function set($name, $mod = [])
    {
        $middleware = [];
        if ($mod) {
            $action = strtolower(Route::getAction());
            foreach ($mod as $type => $data) {
                $data = Arr::valueCase($data, 0);
                switch ($type) {
                    case 'only':
                        if (in_array($action, $data)) {
                            $middleware = array_merge(
                                $middleware,
                                Config::get(
                                    'middleware.controller.'
                                    .$name
                                )
                            );
                        }
                        break;
                    case 'except':
                        if ( ! in_array($action, $data)) {
                            $middleware = array_merge(
                                $middleware,
                                Config::get(
                                    'middleware.controller.'
                                    .$name
                                )
                            );
                        }
                        break;
                }
            }
        } else {
            $middleware = Config::get('middleware.controller.'.$name);
        }

        return $this->exe(array_unique($middleware));
    }

    /**
     * 执行全局中间件
     *
     * @return bool
     */
    public function globals()
    {
        $middleware = array_unique(Config::get('middleware.global'));

        return $this->exe($middleware);
    }


    /**
     * 添加应用中间件
     *
     * @param $name  中间件
     * @param $class 处理类
     *
     * @return bool
     */
    public function add($name, $class)
    {
        $middleware = Config::get('middleware.web.'.$name) ?: [];
        foreach ($class as $c) {
            array_push($middleware, $c);
        }

        return Config::set('middleware.web.'.$name, array_unique($middleware));
    }

    /**
     * 执行应用中间件
     *
     * @param $name
     *
     * @return bool
     */
    public function web($name)
    {
        $middleware = Config::get('middleware.web.'.$name) ?: [];
        if ( ! empty($middleware)) {
            return $this->exe($middleware);
        }
    }
}