<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;
use system\model\User;

/**
 * 后台管理员登录验证
 * Class Auth
 *
 * @package system\middleware
 */
class Auth implements Middleware
{
    public function run($next)
    {
        if ( ! User::loginAuth()) {
            return redirect()->show('请登录后操作', User::getLoginUrl());
        }
        $next();
    }
}