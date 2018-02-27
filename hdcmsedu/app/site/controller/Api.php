<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use app\site\controller\wechat\Login;
use houdunwang\wechat\WeChat;
use system\model\WeChatMessage;

/**
 * 微信请求接口
 * Class Api
 *
 * @package app\site\controller
 */
class Api
{
    use Login;
    //消息组件实例
    protected $instance;

    //消息类型
    protected $msgType;

    public function __construct()
    {
        //与微信官网通信绑定验证
        WeChat::valid();
        $this->instance = WeChat::instance('message');
        $this->msgType  = strtolower($this->instance->getMessageType());
    }

    /**
     * 接口业务处理
     */
    public function handle()
    {
        //关注公众号添加会员信息
        $this->userSubscribeInitMember();

        //消息定阅处理不向用户返回微信结果
        WeChatMessage::subscribe();

        //文本消息时进行处理
        if ($this->instance->isTextMsg()) {
            WeChatMessage::reply(WeChat::content('Content'));
        }

        //菜单关键词消息
        if (WeChat::instance('button')->isClickEvent()) {
            WeChatMessage::reply(WeChat::content('EventKey'));
        }

        //直接处理消息需要模块有权限
        WeChatMessage::processor();

        //订阅事件
        if ($this->instance->isSubscribeEvent()) {
            return $this->system(v('site.setting.welcome'));
        }

        //回复默认消息
        if ($this->instance->isTextMsg()) {
            return $this->system(v('site.setting.default_message'));
        }

        return '';
    }

    /**
     * 处理默认或关注消息
     *
     * @param text $defaultMessage 文本
     *
     * @return string
     */
    protected function system($defaultMessage)
    {
        if ($defaultMessage) {
            if ($content = WeChatMessage::reply($defaultMessage)) {
                return $content;
            }

            return $this->instance->text($defaultMessage);
        }
    }
}