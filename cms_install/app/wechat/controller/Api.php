<?php namespace app\wechat\controller;

use houdunwang\route\Controller;
use system\model\Keyword;
use system\model\Module;
use WeChat;
use system\model\Config;

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
        //根据用户通过微信APP提交的内容来回复消息
        $instance = WeChat::instance('message');
        $this->parsekeyword($instance->Content);
        //没有关注词匹配时回复默认消息
        $config = Config::find(1);
        $this->parsekeyword($config['default_message']);
        //默认回复消息不是一个关键词时直接回复内容
        $instance->text($config['default_message']);
    }

    /**
     * 根据内容检测系统是否有匹配的关键词
     * 有存在的关键词时回复相应内容
     *
     * @param $content
     */
    protected function parsekeyword($content)
    {
        $keyworContent = trim($content);
        $keyword       = Keyword::where('content', $keyworContent)->first();
        if ($keyword) {
            $info  = Module::where('name', $keyword['module'])->first();
            $class = ($info['is_system'] == 1 ? 'module' : 'addons').'\\'.$keyword['module'].'\\system\\Processor';
            call_user_func_array([new $class, 'handler'], [$keyword['id']]);
        }
    }
}
