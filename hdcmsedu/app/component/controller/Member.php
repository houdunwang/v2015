<?php namespace app\component\controller;

use houdunwang\request\Request;
use houdunwang\db\Db;

/**
 * 前台会员
 * Class User
 *
 * @package app\component\controller
 */
class Member
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
    public function lists()
    {
        if (IS_POST) {
            $siteid = Request::get('siteid', SITEID);
            //搜索词
            $name = Request::post('name');
            $db   = Db::table('member')->where('member.siteid', $siteid)->limit(20);
            $db->field('uid,email,mobile,group_id,member_group.title group_title,member.created_at,member.nickname,member.realname');
            $db->join('member_group', 'member.group_id', '=', 'member_group.id');
            switch (Request::post('type')) {
                case 'mobile':
                    $db->where('mobile', 'like', "%{$name}%");
                    break;
                case 'email':
                    $db->where('email', 'like', "%{$name}%");
                    break;
                case 'uid':
                    $db->where('uid', $name);
                    break;
            }

            return $db->get();
        }

        return view();
    }

    /**
     * 获取微信粉丝
     *
     * @return mixed
     */
    public function wechat()
    {
        if (IS_POST) {
            $siteid = Request::get('siteid', SITEID);
            //搜索词
            $name = Request::post('name');
            $db   = Db::table('member')
                      ->join('member_auth', 'member.uid', '=', 'member_auth.uid')
                      ->join('member_group', 'member.group_id', '=', 'member_group.id')
                      ->where('member_auth.wechat', '<>', '')->where('member.siteid', $siteid)
                      ->limit(20);
            $db->field('member.uid,email,mobile,group_id,member_group.title group_title,member.created_at,member.nickname,member.realname');
            switch (Request::post('type')) {
                case 'mobile':
                    $db->where('mobile', 'like', "%{$name}%");
                    break;
                case 'email':
                    $db->where('email', 'like', "%{$name}%");
                    break;
                case 'nickname':
                    $db->where('nickname', 'like', "%{$name}%");
                    break;
            }

            return $db->get();
        }

        return view();
    }
}