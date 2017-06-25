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
 * 消息测试
 * Trait Message
 *
 * @package tests\app
 */
trait Message
{
    protected function messageHandler()
    {
        $instance = WeChat::instance('message');
        //获取消息内容
        $message = $instance->getMessage();
        $this->sendNews();
        //判断是否是文本消息
        if ($instance->isTextMsg()) {
            file_put_contents('openid.php',$message->FromUserName);
            //向用户回复消息
            $instance->text('后盾网收到你的消息了...:'.$instance->Content);
        }

        //判断是否是图片消息
        if ($instance->isImageMsg()) {
            //向用户回复消息
            $instance->text("图片url:{$message->PicUrl},图片MediaId: {$message->MediaId}");
        }

        //判断是否是语音消息
        if ($instance->isVoiceMsg()) {
            //向用户回复消息
            $instance->text("你发送的语音消息MediaId: {$message->MediaId} ,语音格式: {$message->Format}");
        }
        //判断是否是地理位置消息
        if ($instance->isLocationMsg()) {
            //向用户回复消息
            $instance->text("你发送的地理位置消息，纬度: {$message->Location_X} ,经度: {$message->Location_Y},缩放级别: {$message->Scale},位置: {$message->Label}");
        }

        //判断是否是链接消息
        if ($instance->isLinkMsg()) {
            //向用户回复消息
            $instance->text("你发送的链接消息,标题: {$message->Title}，接要: {$message->Description} ,链接: {$message->Url}");
        }

        //判断是否是视频消息
        if ($instance->isVideoMsg()) {
            //向用户回复消息
            $instance->text("你发送的视频消息 MediaId: {$message->MediaId} ,缩略图的媒体id: {$message->ThumbMediaId}");
        }

        //判断是否是小视频消息
        if ($instance->isSmallVideoMsg()) {
            //向用户回复消息
            $instance->text("你发送的小视频消息 MediaId: {$message->MediaId} ,缩略图的媒体id: {$message->ThumbMediaId}");
        }
    }

    //回复图文消息
    protected function sendNews()
    {
        $instance = WeChat::instance('message');
        $message  = $instance->getMessage();
        if ($instance->isTextMsg()) {
            //消息管理模块
            $instance = WeChat::instance('message');
            if ($instance->isTextMsg() && $message->Content == '图片') {
                //向用户回复消息
                $news = [
                    [
                        'title'       => '后盾网',
                        'discription' => '后盾网 人人做后盾',
                        'picurl'      => 'http://www.houdunwang.com/attachment/8201487729721.jpg',
                        'url'         => '点击图文消息跳转链接',
                    ],
                    [
                        'title'       => '快学网',
                        'discription' => '快学网 快人一步',
                        'picurl'      => 'http://www.houdunwang.com/attachment/96881487729878.JPG',
                        'url'         => '点击图文消息跳转链接',
                    ],
                ];
                $instance->news($news);
            }
        }
    }
}