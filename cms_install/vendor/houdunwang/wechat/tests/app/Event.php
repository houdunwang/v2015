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
 * 事件测试
 * Trait Event
 *
 * @package tests\app
 */
trait Event
{
    public function eventHandler()
    {
        $instance = WeChat::instance('message');

        //获取消息内容
        $message = $instance->getMessage();

        //判断是否是关注事件
        if ($instance->isSubscribeEvent()) {
            //向用户回复消息
            file_put_contents('isSubscribeEvent.php',var_export($message,true));
            $instance->text("感谢你关注后盾网微信");
        }

        //判断是否是取消关注事件
        if ($instance->isUnSubscribeEvent()) {
            //向用户回复消息
            file_put_contents('isUnSubscribeEvent.php', 'isUnSubscribeEvent');
        }

        //未关注用户扫描二维码事件
        if ($instance->isSubscribeScanEvent()) {
            //向用户回复消息
            $instance->text("未关注用户扫描二维码关注了后盾网,EventKey: {$message->EventKey} ,二维码的Ticket: {$message->Ticket}");
        }

        //已经关注用户扫描二维码事件
        if ($instance->isScanEvent()) {
            //向用户回复消息
            $instance->text("已关注用户扫描二维码,EventKey: {$message->EventKey} ,二维码的Ticket: {$message->Ticket}");
        }

        //上报地理位置事件
        if ($instance->isLocationEvent()) {
            //向用户回复消息
            $instance->text("上报地理位置事件,纬度: {$message->Latitude} ,经度: {$message->Longitude}");
        }
    }
}