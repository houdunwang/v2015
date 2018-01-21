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

use WeChat;
use system\model\WeChatMessage;

/**
 * 微信请求接口
 * Class Api
 *
 * @package app\site\controller
 */
class Api
{
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
        //消息定阅处理
        WeChatMessage::subscribe();

        //文本消息时进行处理
        WeChatMessage::reply(WeChat::content('Content'));

        //菜单关键词消息
        WeChatMessage::reply(WeChat::content('EventKey'));

        //处理非文本类信息
        WeChatMessage::processor();

        //回复默认消息
        $this->defaultMessage();
    }

    /**
     * 回复默认消息
     *
     * @return string
     */
    protected function defaultMessage()
    {
        $defaultMessage = v('site.setting.default_message');
        if ($defaultMessage) {
            if ($content = WeChatMessage::reply($defaultMessage)) {
                return $content;
            }

            return $this->instance->text($defaultMessage);
        }
    }
}