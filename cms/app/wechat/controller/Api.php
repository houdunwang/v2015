<?php namespace app\wechat\controller;

use houdunwang\route\Controller;
use WeChat;

/**
 * 微信消息管理
 * Class Api
 *
 * @package app\wechat\controller
 */
class Api extends Controller
{
    /**
     * Api constructor.
     */
    public function __construct()
    {
        //与微信服务器绑定
        WeChat::valid();
    }

    /**
     * 响应微信消息
     */
    public function handle()
    {
        $instance = WeChat::instance('message');
        $instance->text($instance->Content);
    }
}
