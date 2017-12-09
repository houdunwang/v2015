<?php namespace module;

use system\model\Modules;
use WeChat;

/**
 * 模块订阅消息
 * Class hdSubscribe
 *
 * @package system\core
 * @author  向军
 */
abstract class hdSubscribe
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

    //处理方法
    abstract function handle();

    public function __call($method, $arguments = [])
    {
        return call_user_func_array([$this->message, $method], $arguments);
    }
}