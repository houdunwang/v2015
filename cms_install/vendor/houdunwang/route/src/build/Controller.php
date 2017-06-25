<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\route\build;

use Exception;
use ReflectionMethod;
use houdunwang\container\Container;
use houdunwang\middleware\Middleware;

/**
 * 控制器处理类
 * Class Controller
 *
 * @package houdunwang\route\build
 */
trait Controller
{
    protected $controller;

    protected $action;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * 执行控制器
     *
     * @param       $action
     * @param array $args
     *
     * @return mixed
     * @throws \Exception
     */
    public function executeControllerAction($action, $args = [])
    {
        $info = explode('@', $action);
        $this->setController($controller = $info[0]);
        $this->setAction($action = $info[1]);
        //控制器不存在执行中间件
        if ( ! class_exists($controller)) {
            throw new Exception('控制器不存在');
        }
        //方法不存在时执行中间件
        if ( ! method_exists($controller, $action)) {
            throw new Exception('控制器的方法不存在');
        }
        //控制器开始运行中间件
        Middleware::web('controller_start');
        $controller = Container::make($controller, true);
        try {
            /**
             * 参数处理
             * 控制器路由方式访问时解析路由参数并注入到控制器方法参数中
             */
            $reflectionMethod = new \ReflectionMethod($controller, $action);
            foreach ($reflectionMethod->getParameters() as $k => $p) {
                if (isset($this->args[$p->name])) {
                    //如果为路由参数时使用路由参数赋值
                    $args[$p->name] = $this->args[$p->name];
                } else {
                    //如果类型为类时分析类
                    if ($dependency = $p->getClass()) {
                        $args[$p->name] = Container::build($dependency->name);
                    } else {
                        //普通参数时获取默认值
                        $args[$p->name] = Container::resolveNonClass($p);
                    }
                }
            }

            //执行控制器方法
            return $reflectionMethod->invokeArgs($controller, $args);
        } catch (ReflectionException $e) {
            $method = new ReflectionMethod($controller, '__call');

            return $method->invokeArgs($controller, [$action, '']);
        }
    }
}