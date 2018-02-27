<?php namespace app\component\controller;

use houdunwang\request\Request;
use houdunwang\db\Db;
/**
 * 用户
 * Class User
 *
 * @package app\component\controller
 */
class User
{
    public function __construct()
    {
        auth();
    }

    /**
     * 选择用户
     *
     * @return mixed
     */
    public function select()
    {
        if (IS_POST) {
            $db = Db::table('user')->join('user_group', 'user.groupid', '=', 'user_group.id')
                    ->limit(20);
            //过滤不显示的用户
            if ($filterUid = explode(',', Request::get('filterUid', ''))) {
                $db->whereNotIn('uid', $filterUid);
            }
            //按用户名筛选
            if ($username = Request::get('username')) {
                $db->where("username LIKE '%{$_GET['username']}%'");
            }

            return ajax($db->get());
        }

        return view();
    }
}