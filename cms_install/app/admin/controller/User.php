<?php namespace app\admin\controller;

use Request;
use system\model\User as UserModel;

/**
 * Class User
 *
 * @package app\admin\controller
 */
class User extends Common
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 修改密码
     *
     * @return mixed
     */
    public function changePassword()
    {
        if (IS_POST) {
            return UserModel::changePassword(Request::post());
        }

        return view();
    }
}
