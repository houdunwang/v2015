<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use houdunwang\route\Controller;
use View;
use Middleware;

/**
 * 站点管理平台
 * Class Admin
 *
 * @package app\site\controller
 */
abstract class Admin extends Controller
{
    /**
     * 构造函数
     * Admin constructor.
     */
    public function __construct()
    {
        $this->auth();
    }

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
}