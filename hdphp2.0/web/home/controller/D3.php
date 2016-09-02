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

class D3 {
	//动作
	public function index() {
		//		$d = Db::table( 'user' )->get(['username','mail']);
		//		$d= Db::table('user')->where('id',2)->first();
		//		$d = Db::table('user')->first(2);
		//		$d = Db::table('user')->where('id',2)->pluck('username');
		//		$d = Db::table('user')->where('id','>',1)->lists('id,username,mail');
		//		$d = Db::table('user')->field(['username','mail'])->get();
		//		$d = Db::table('user')->getByUsername("后盾人");
		$db = Db::table( 'user' )->where( 'id', '>', 1 );
		$db->field( ['username','mail'] );
		$d = $db->get();
		p( $d );
		p( Db::getQueryLog() );

	}
}
