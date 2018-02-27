<?php namespace system\model;

use houdunwang\model\Model;
use houdunwang\wechat\WeChat;
use houdunwang\arr\Arr;

/**
 * 微信消息处理
 * Class WeChatMessage
 *
 * @package system\model
 */
class WeChatMessage extends Model
{
    protected $table = 'modules';

    /**
     * 根据内容检测匹配的模块
     * 并交由模块处理返回消息
     *
     * @param string $content 文本内容
     *
     * @return string
     */
    public static function reply($content)
    {
        if ($content && $rule = Rule::getByKeyword($content)) {
            $module = v('site.modules.'.$rule['module']);
            $type   = ($module['is_system'] == 1 ? '\module\\' : '\addons\\');
            $class  = $type.$module['name'].'\system\Processor';
            if (class_exists($class)) {
                return (new $class())->handle($rule['rid']);
            }
        }
    }

    /**
     * 直接将微信处理交给模块
     * 需要模块拥有直接处理消息的功能
     *
     * @return string
     */
    public static function processor()
    {
        foreach (v('site.modules') as $module) {
            //模块可以处理该消息类型时
            if (Arr::get($module['processors'], strtolower(WeChat::getMessageType()))) {
                $type  = ($module['is_system'] == 1 ? '\module\\' : '\addons\\');
                $class = $type.$module['name'].'\system\Processor';
                if (class_exists($class)) {
                    (new $class())->handle(0);
                }
            }
        }
    }

    /**
     * 模块拥有订阅消息的功能时
     * 交由模块进行处理
     *
     * @return mixed
     */
    public static function subscribe()
    {
        foreach (v('site.modules') as $module) {
            if (Arr::get($module['subscribes'], strtolower(WeChat::getMessageType()))) {
                $type  = ($module['is_system'] == 1 ? '\module\\' : '\addons\\');
                $class = $type.$module['name'].'\system\Subscribe';
                if (class_exists($class)) {
                    (new $class())->handle(0);
                }
            }
        }
    }
}