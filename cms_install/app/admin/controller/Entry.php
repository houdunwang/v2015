<?php namespace app\admin\controller;

use Request;
use system\model\User;

/**
 * Class Entry
 *
 * @package app\admin\controller
 */
class Entry
{
    /**
     * 登录
     *
     * @return mixed
     */
    public function login()
    {
        if (IS_POST) {
            return User::login(Request::post());
        }

        return view();
    }

    /**
     * 退出登录
     */
    public function out()
    {
        Session::del('uid');

        return go(__ROOT__.'/login');
    }
}
