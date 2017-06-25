<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\framework\build;

use houdunwang\config\Config;
use houdunwang\error\Error;
use houdunwang\loader\Loader;
trait Initial
{
    //系统服务
    protected $providers = [];
    //外观别名
    protected $facades = [];

    public function init()
    {
        $this->constant();
        $this->configSetting();
        //设置自动加载
        Loader::bootstrap();
        Loader::register([$this, 'autoload']);
        Error::bootstrap();
    }

    /**
     * 加载配置项
     */
    protected function configSetting()
    {
        //加载.env文件
        Config::env('.env');
        //加载服务配置项
        $servers = require __DIR__.'/../build/service.php';
        //加载配置文件
        Config::loadFiles(ROOT_PATH.'/system/config');
        $this->providers = array_merge($servers['providers'], Config::get('service.providers'));
        $this->facades   = array_merge($servers['facades'], Config::get('service.facades'));
        //设置时区
        date_default_timezone_set(Config::get('app.timezone'));
    }

    /**
     * 常量设置
     */
    protected function constant()
    {
        if ( ! defined('__ROOT__')) {
            define('__ROOT__', RUN_MODE != 'HTTP'
                ? '' : trim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\'));
        }
        if ( ! defined('__WEB__')) {
            define('__WEB__', Config::get('http.rewrite') ? __ROOT__ : __ROOT__.'/index.php');
        }
        //根目录即Vendor同级目录
        define('ROOT_PATH', realpath(dirname(__DIR__).'/../../../..'));
        define('DS', DIRECTORY_SEPARATOR);
    }
}