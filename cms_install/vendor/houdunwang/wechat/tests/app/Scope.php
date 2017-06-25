<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app;


use houdunwang\wechat\WeChat;

/**
 * 微信网页授权
 * Trait Scope
 *
 * @package tests\app
 */
trait Scope
{
    /**
     * 获取粉丝数据不显示确认界面
     * snsapi_base
     */
    public function snsapiBase()
    {
        $res = WeChat::instance('oauth')->snsapiBase();
        if (isset($res['openid'])) {
            echo $res['openid'];
        } else {
            echo '获取粉丝OPENID失败';
        }
    }

    /**
     * 获取粉丝数据显示确认界面
     * snsapi_base
     */
    public function snsapiUserinfo()
    {
        $res = WeChat::instance('oauth')->snsapiUserinfo();
        if (isset($res['openid'])) {
            echo "昵称: {$res['nickname']} openid:{$res['openid']}";
        } else {
            echo '获取粉丝OPENID失败';
        }
    }

    /**
     * 获取粉丝数据显示确认界面
     * snsapi_base
     */
    public function scopeQrCode()
    {
        WeChat::instance('oauth')->QrLogin(function($res){
            if (isset($res['openid'])) {
                echo "昵称: {$res['nickname']} openid:{$res['openid']}";
            } else {
                echo '获取粉丝OPENID失败';
            }
        });
    }
}