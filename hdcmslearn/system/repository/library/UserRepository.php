<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\repository\library;

use houdunwang\model\repository\Repository;
use system\model\User;

/**
 * 用户管理
 * Class UserRepository
 *
 * @package system\repository\library
 */
class UserRepository extends Repository
{
    public function model()
    {
        return User::class;
    }
}