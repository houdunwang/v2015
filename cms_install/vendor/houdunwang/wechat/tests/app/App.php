<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app;

use houdunwang\config\Config;
use houdunwang\wechat\WeChat;

include '../../vendor/autoload.php';

class App
{
    use Message, Event, ButtonEvent, Scope, Pay, Cash;

    public function __construct()
    {
        Config::loadFiles('../config');
        WeChat::valid();
    }

    public function handler()
    {
        $this->messageHandler();
        $this->eventHandler();
        $this->buttonHander();
    }
//    public function snsapiBaseaa(){
//        echo <<<str
//<a href="http://dev.hdcms.com/component/wechat/tests/app/App.php?action=scopeSnsapiBase">获取基本授权</a>
//str;
//    }
}

$action   = isset($_GET['action']) ? $_GET['action'] : 'handler';
$instance = new App();
if ($action) {
    echo call_user_func_array([$instance, $action], []);
}