<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * |     Weibo: http://weibo.com/houdunwangxj
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller\wechat;

use houdunwang\wechat\WeChat;
use system\model\MemberAuth;
use system\model\Member;
use houdunwang\db\Db;

trait Login
{
    //微信APP关注公众号
    protected function userSubscribeInitMember()
    {
        //APP关注公众号
        if (WeChat::instance('message')->isSubscribeEvent()) {
            $content = WeChat::instance('message')->getMessage();
            $info    = WeChat::instance('user')->getUserInfo($content->FromUserName);
            $openid  = $unionid = '';
            $db      = Db::table('member_auth')->where('siteid', siteid());
            //开放平台
            if (isset($info['unionid']) && ! empty($info['unionid'])) {
                $has = $db->where('unionid', $info['unionid'])->get();
            } else {
                //公众平台
                $has = $db->where('wechat', $info['openid'])->get();
            }
            if ( ! $has) {
                $member             = new Member();
                $member['nickname'] = $info['nickname'];
                $member['icon']     = $info['headimgurl'];
                $member->save();
                $auth = new MemberAuth();

                return $auth->save(
                    [
                        'uid'     => $member['uid'],
                        'siteid'  => siteid(),
                        'wechat'  => $openid,
                        'unionid' => $unionid,
                    ]
                );
            }
        }
    }
}