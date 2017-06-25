<?php namespace houdunwang\wechat;

use houdunwang\framework\build\Provider;

class WeChatProvider extends Provider
{
    //延迟加载
    public $defer = true;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->single(
            'WeChat',
            function () {
                return new WeChat();
            }
        );
    }
}