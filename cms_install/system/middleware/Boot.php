<?php namespace system\middleware;

use houdunwang\middleware\build\Middleware;
use Request;

class Boot implements Middleware
{
    //执行中间件
    public function run($next)
    {
        $this->isInstall();
        if (is_file('lock.php')) {
            $this->loadSiteConfig();
            $this->loadWeChatConfig();
        }
        $next();
    }

    /**
     * 安装检测
     * 没有安装时跳转到安装界面
     */
    protected function isInstall()
    {
        if ( ! is_file('lock.php') && ! preg_match('@system/install@i', Request::get('s'))) {
            go(u('system/install/copyright'));
        }
    }

    protected function loadSiteConfig()
    {
        $model = \system\model\Config::find(1);
        if ($model) {
            v('config', json_decode($model['content'], true));
        }
    }

    protected function loadWeChatConfig()
    {
        $config = \system\model\WeChatConfig::find(1);
        if ($config) {
            \Config::set('wechat', array_merge(\Config::get('wechat'), $config->toArray()));
        }
    }
}