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

/**
 * 设置路由
 * Trait Setting
 *
 * @package houdunwang\route\build
 */
trait Setting
{
    //路由前缀
    protected $prefix;

    /**
     * 魔术方法用于设置路由
     * get/post/put/delete/any
     *
     * @param    string $method 请求动作
     * @param    array  $params 参数数组
     *
     * @return    object
     */
    public function __call($method, $params)
    {
        $this->route[] = [
            'method'   => $method,
            'route'    => $this->prefix.trim(array_shift($params), '/'),
            'callback' => array_shift($params),
            'regexp'   => '/./',
            'args'     => [],
            'get'      => [],//路由 show/{id}.html中的get参数
        ];

        return $this;
    }

    /**
     * 路由分组
     *
     * @param  array             $prefix 前缀
     * @param  string | callback 执行动作
     *
     * @return void
     */
    public function group(array $prefix, $callback)
    {
        $this->prefix = $prefix['prefix'].'/';
        $callback();
        $this->prefix = '';
    }

    /**
     * 设置控制器路由
     *
     * @param $route
     * @param $param
     *
     * @return $this
     */
    public function controller($route, $param)
    {
        $route         = trim($route, '/');
        $this->route[] = [
            'method'   => 'controller',
            'route'    => $this->prefix.$route.'/{method}(\.\w+)?',
            'callback' => $param,
            'regexp'   => '',
            'args'     => [],
        ];

        return $this;
    }

    /**
     * 设置资源路由
     *
     * @param $route
     * @param $controller
     *
     * @return $this
     */
    public function resource($route, $controller)
    {
        $route = trim($route, '/');
        $this->get("$route", $controller.'@index');
        //添加文章视图
        $this->get("$route/create", $controller.'@create');
        //保存
        $this->post("$route", $controller.'@store');
        //显示文章
        $this->get("$route/{id}", $controller.'@show');
        //编辑文章视图
        $this->get("$route/{id}/edit", $controller.'@edit');
        //更新
        $this->put("$route/{id}", $controller.'@update');
        //删除文章
        $this->delete("$route/{id}", $controller.'@destroy');

        return $this;
    }
}