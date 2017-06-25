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

use Closure;
use houdunwang\config\Config;
use houdunwang\container\Container;
use houdunwang\controller\Controller;
use houdunwang\request\Request;

/**
 * 解析路由
 * Trait Compile
 *
 * @package houdunwang\route\build
 */
trait Compile
{
    //匹配的路由列表下标
    protected $matchRouteKey;

    //路由参数
    public $args = [];

    /**
     * 获取匹配成功的路由
     *
     * @return mixed
     */
    public function getMatchRoute()
    {
        return $this->route[$this->matchRouteKey];
    }

    //匹配路由
    protected function isMatch($key)
    {
        if (preg_match($this->route[$key]['regexp'], $this->requestUri)) {
            //获取参数
            $this->route[$key]['get'] = $this->getArgs($key);
            //验证参数
            if ( ! $this->checkArgs($key)) {
                return false;
            }
            //设置GET参数
            $this->args = $this->route[$key]['get'];
            foreach ((array)$this->args as $k => $v) {
                Request::set('get.'.$k, $v);
            }

            //匹配成功的路由规则
            $this->matchRouteKey = $key;

            return true;
        }
    }

    //获取请求参数
    protected function getArgs($key)
    {
        $args = [];
        if (preg_match_all(
            $this->route[$key]['regexp'],
            $this->requestUri,
            $matched,
            PREG_SET_ORDER
        )) {
            //参数列表
            foreach ($this->route[$key]['args'] as $n => $value) {
                if (isset($matched[0][$n + 1])) {
                    //数值类型转换
                    $v               = $matched[0][$n + 1];
                    $args[$value[1]] = is_numeric($v) ? intval($v) : $v;
                }
            }
        }

        return $args;
    }

    //验证路由参数
    protected function checkArgs($key)
    {
        $route = $this->route[$key];
        if ( ! empty($route['where'])) {
            foreach ($route['where'] as $name => $regexp) {
                if (isset($route['get'][$name])
                    && ! preg_match($regexp, $route['get'][$name])
                ) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 执行匹配成功的路由
     *
     * @return mixed
     */
    public function exec()
    {
        $key = $this->matchRouteKey;
        //匿名函数
        if ($this->route[$key]['callback'] instanceof Closure) {
            //反射分析闭包
            $reflectionFunction
                  = new \ReflectionFunction($this->route[$key]['callback']);
            $gets = $this->route[$key]['get'];
            $args = [];
            foreach ($reflectionFunction->getParameters() as $k => $p) {
                if (isset($gets[$p->name])) {
                    //如果GET变量中存在则将GET变量值赋予,也就是说GET优先级高
                    $args[$p->name] = $gets[$p->name];
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

            return $reflectionFunction->invokeArgs($args);
        }
        //控制器动作
        if (is_string($this->route[$key]['callback'])) {
            return $this->executeControllerAction($this->route[$key]['callback']);
        }
    }

    //GET事件处理
    protected function _get($key)
    {
        return Request::isMethod('get') && $this->isMatch($key);
    }

    //POST事件处理
    protected function _post($key)
    {
        return Request::isMethod('post') && $this->isMatch($key);
    }

    //PUT事件处理
    protected function _put($key)
    {
        return Request::isMethod('put') && $this->isMatch($key);
    }

    //DELETE事件
    protected function _delete($key)
    {
        return Request::isMethod('delete') && $this->isMatch($key);
    }

    //任意提交模式
    protected function _any($key)
    {
        return $this->isMatch($key);
    }

    //控制器路由
    protected function _controller($key)
    {
        if ($this->route[$key]['method'] == 'controller'
            && $this->isMatch($key)
        ) {
            //控制器方法
            $method                        = strtolower(Request::getRequestType())
                                             .ucfirst($this->route[$key]['get']['method']);
            $this->route[$key]['callback'] .= '@'.$method;

            return true;
        }
    }

    /**
     * 获取解析后的参数
     *
     * @return array
     */
    public function getArg()
    {
        return $this->args;
    }

    /**
     * 获取路由参数
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function input($name = null)
    {
        if (is_null($name)) {
            return $this->args;
        } else {
            return isset($this->args[$name]) ? $this->args[$name] : null;
        }
    }
}