<?php
/** .-------------------------------------------------------------------
* |  Software: [HDCMS framework]
* |      Site: www.hdcms.com
* |-------------------------------------------------------------------
* |    Author: 向军 <2300071698@qq.com>
* |    WeChat: aihoudun
* | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
* '-------------------------------------------------------------------*/

namespace app\home\controller;

class Conf{
    //动作
    public function base(){
//      dd(Config::get('middleware.middleware.app_start.0'));
//	    dd(c('app.debug'));
//	    dd(Config::has('app.debug'));
//	    p(Config::getExtName('database',['write','read']));
//	    p(Config::get('sina.openid'));
//	    Config::set('database.host','localhost');
	    c('database.host','houdunwang.com');
	    p(Config::get('database'));
    }
}
