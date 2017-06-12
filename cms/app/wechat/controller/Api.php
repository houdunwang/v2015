<?php namespace app\wechat\controller;

use houdunwang\route\Controller;
use system\model\Keyword;
use system\model\Module;
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
        $instance      = WeChat::instance('message');
        $keyworContent = trim($instance->Content);
        $keyword       = Keyword::where('content', $keyworContent)->first();
        if ($keyword) {
            $info  = Module::where('name', $keyword['module'])->first();
            $class = ($info['is_system'] == 1 ? 'module' : 'addons').'\\'.$keyword['module'].'\\system\\Processor';
            call_user_func_array([new $class, 'handler'], [$keyword['id']]);
        }
    }
}
