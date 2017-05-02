<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace web\home\controller;

class D1{
    //动作
	public function index(){
		$res = Db::table('news')->get();
		p($res);
		$user = Db::table('user')->get();
		p($user);
	}
}
