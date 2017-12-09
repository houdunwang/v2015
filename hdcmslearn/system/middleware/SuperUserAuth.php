<?php namespace system\middleware;

use houdunwang\request\Request;
use houdunwang\middleware\build\Middleware;
use system\model\User;

/**
 * 超级管理员验证
 * Class SuperUserAuth
 *
 * @package system\middleware
 */
class SuperUserAuth implements Middleware
{
    public function run($next)
    {
        if ( ! User::loginAuth()) {
            return redirect()->show('请登录后操作', User::getLoginUrl());
        }
        if ( ! User::superUserAuth()) {
            return redirect()->show('不是超级管理员不允许操作', u('system.site.lists'));
        }
        $next();
    }
}