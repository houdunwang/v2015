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

class D5{
    //动作
	public function index(){
//		echo Db::table('user')->where('total','>',5)->count();
//		echo Db::table('user')->max('id');
//		$d = Db::table('news')->field('user.id,user.username,news.title')->join('user','news.uid','=','user.id')->get();
//		$d = Db::table('news')->rightJoin('user','news.uid','=','user.id')->get();
		$d = Db::table('news')->leftJoin('user','news.uid','=','user.id')->get();
		p($d);
	}
}
