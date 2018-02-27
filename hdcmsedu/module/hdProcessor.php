<?php namespace module;

use system\model\Modules;
use houdunwang\wechat\WeChat;

/**
 * 模块处理消息
 * Class HdProcessor
 *
 * @package module
 */
abstract class HdProcessor
{
    //配置项
    protected $config;

    //微信消息内容
    protected $content;

    //微信消息管理实例
    protected $message;

    public function __construct()
    {
        $this->config  = Modules::getModuleConfig();
        $this->message = WeChat::instance('message');
        $this->content = $this->message->getMessage();
    }

    //回复方法
    abstract function handle($rid = 0);

    public function __call($method, $arguments = [])
    {
        return call_user_func_array([$this->message, $method], $arguments);
    }
}