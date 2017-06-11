<?php namespace system\middleware;

use system\model\User;

class Auth
{
    //执行中间件
    public function run()
    {
        $uid = Session::get('uid');
        if ($uid) {
            v('user', User::find($uid)->toArray());
        } else {
            die(go(__ROOT__.'/login'));
        }
    }
}