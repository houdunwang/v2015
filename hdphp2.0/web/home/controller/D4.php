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

class D4{
    //动作
	public function index(){
		//此处书写代码...
//		$d = Db::table('user')->where('id','>',1)->logic('or')->where('id','<',3)->get();

//		$d =Db::table('user')->whereRaw('id > ? and total >?', [1,50])->get();
//		$d = Db::table('user')->WhereNotNull('nickname')->get();
//		$d = Db::table('user')->orderBy('total','ASC')->orderBy('id','desc')->get();
//		$d = Db::table('user')->groupBy('groupid')->field('groupid')->get();

//		$d = Db::table('user')->groupBy('groupid')->having('count(*)','=',1)->field('groupid')->get();
		$d = Db::table('user')->limit(1,1)->orderBy('id','ASC')->get();
		p($d);
		p(Db::getQueryLog());

	}
}
