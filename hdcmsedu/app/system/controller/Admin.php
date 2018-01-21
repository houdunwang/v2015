<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\system\controller;

use houdunwang\middleware\Middleware;
use houdunwang\route\Controller;
use system\model\User;

/**
 * 系统管理公共类
 * Class Admin
 *
 * @package app\system\controller
 */
abstract class Admin extends Controller
{
    /**
     * 后台登录验证
     *
     * @param array $except 排除验证的控制器方法
     */
    protected function auth($except = [])
    {
        $except = array_merge($except, ['captcha']);
        if ($except) {
            Middleware::set('auth', ['except' => $except]);
        } else {
            Middleware::set('auth');
        }
    }

    /**
     * 超级管理员权限验证
     *
     * @param array $except 排除验证的控制器方法
     */
    protected function superUserAuth($except = [])
    {
        $this->auth();
        if ($except) {
            Middleware::set('superUserAuth', ['except' => $except]);
        } else {
            Middleware::set('superUserAuth');
        }
    }
}