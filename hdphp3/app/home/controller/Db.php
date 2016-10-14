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
class Db{
    //动作
    public function connect(){
        $d = \Db::table('news')->get();
	    p($d);
    }
}
