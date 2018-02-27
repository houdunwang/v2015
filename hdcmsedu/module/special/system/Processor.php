<?php namespace module\special\system;

use module\HdProcessor;
use system\model\WeChatMessage;
use houdunwang\wechat\WeChat;

/**
 * 关注消息处理
 * Class Processor
 *
 * @package module\special\system
 */
class Processor extends HdProcessor
{
    public function handle($rid = 0)
    {
        if (WeChat::instance('message')->isSubscribeEvent()) {
            $welcomeMessage = v('site.setting.welcome');
            //回复默认关注消息
            if ($content = WeChatMessage::reply($welcomeMessage)) {
                return $content;
            }

            return $this->text($welcomeMessage);
        }
    }
}