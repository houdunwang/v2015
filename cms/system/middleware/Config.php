<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;

class Config implements Middleware
{
    //执行中间件
    public function run($next)
    {
        $model = \system\model\Config::find(1);
        if ($model) {
            v('config', json_decode($model['content'], true));
        }
        $this->loadWeChatConfig();
        $next();
    }

    protected function loadWeChatConfig()
    {
        $config = \system\model\WeChatConfig::find(1);
        if ($config) {
            \Config::set('wechat', array_merge(\Config::get('wechat'),$config->toArray()));
        }
    }
}