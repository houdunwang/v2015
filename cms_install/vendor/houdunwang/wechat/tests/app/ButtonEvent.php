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
 * 菜单事件处理
 * Trait ButtonEvent
 *
 * @package tests\app
 */
trait ButtonEvent
{
    /**
     * 菜单事件
     */
    public function buttonHander()
    {
        $instance = WeChat::instance('message');
        //关注用户扫描二维码事件
        if ($instance->isClickEvent()) {
            //获取消息内容
            $message = $instance->getMessage();
            //向用户回复消息
            $instance->text("点击了菜单,EventKey: {$message->EventKey}");
        }

        //消息管理模块
        $instance = WeChat::instance('message');
        //关注用户扫描二维码事件
        if ($instance->isViewEvent()) {
            //获取消息内容
            $message = $instance->getMessage();
            file_put_contents('c.php',$message->EventKey);
        }
    }
}