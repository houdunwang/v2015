<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build;

use houdunwang\wechat\build\message\Event;
use houdunwang\wechat\build\message\Basic;
use houdunwang\wechat\build\message\Send;
use houdunwang\wechat\build\message\SendAll;

/**
 * 消息管理
 * Class Message
 *
 * @package houdunwang\wechat\build
 */
class Message extends Base
{
    use  Event, Basic, Send, SendAll;

    #-------------------用户事件类型----------------
    //关注事件
    CONST EVENT_TYPE_SUBSCRIBE = 'subscribe';
    //取消关注事件
    CONST EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
    //未关注用户扫描二维码事件
    CONST EVENT_TYPE_UNSUBSCRIBE_SCAN = 'subscribe';
    //关注用户扫描二维码事件
    CONST EVENT_TYPE_SUBSCRIBE_SCAN = 'SCAN';
    //上报地理位置事件
    CONST EVENT_TYPE_LOCATION = 'LOCATION';
    //点击菜单的事件类型
    CONST EVENT_TYPE_EVENT = 'event';

    #-------------------用户发送消息类型----------------
    //请求文本消息
    CONST MSG_TYPE_TEXT = 'text';
    //请求图片消息
    CONST MSG_TYPE_IMAGE = 'image';
    //请求语音消息
    CONST MSG_TYPE_VOICE = 'voice';
    //请求地理位置消息
    CONST MSG_TYPE_LOCATION = 'location';
    //请求链接消息
    CONST MSG_TYPE_LINK = 'link';
    //请求小视频消息
    CONST MSG_TYPE_SMALL_VIDEO = 'shortvideo';
    //请求视频消息
    CONST MSG_TYPE_VIDEO = 'video';

    #-------------------回复消息类型----------------
    //回复文本
    CONST REPLY_TYPE_TEXT = 'text';
    //回复图文
    CONST REPLY_TYPE_IMAGE = 'image';
    //回复语音
    CONST REPLY_TYPE_VOICE = 'voice';
    //回复视频
    CONST REPLY_TYPE_VIDEO = 'video';
    //音乐消息
    CONST REPLY_TYPE_MUSIC = 'music';
    //图文信息
    CONST REPLY_TYPE_NEWS = 'news';
    #-------------------按钮消息类型----------------
    //点击菜单拉取消息时的事件
    CONST BUTTON_EVENT_TYPE_CLICK = 'CLICK';
    //点击菜单跳转链接时的事件
    CONST BUTTON_EVENT_TYPE_VIEW = 'VIEW';
    //扫码推事件的事件推送
    CONST BUTTON_EVENT_TYPE_SCANCODE_PUSH = 'scancode_push';
    //扫码推事件且弹出“消息接收中”提示框的事件推送
    CONST BUTTON_EVENT_TYPE_SCANCODE_WAITMSG = 'scancode_waitmsg';
    //弹出系统拍照发图的事件推送
    CONST BUTTON_EVENT_TYPE_PIC_SYSPHOTO = 'pic_sysphoto';
    //弹出拍照或者相册发图的事件推送
    CONST BUTTON_EVENT_TYPE_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
    //弹出微信相册发图器的事件推送
    CONST BUTTON_EVENT_TYPE_PIC_WEIXIN = 'pic_weixin';
    //弹出地理位置选择器的事件推送
    CONST BUTTON_EVENT_TYPE_LOCATION_SELECT = 'location_select';
}