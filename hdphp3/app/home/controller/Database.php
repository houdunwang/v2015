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
class Database {
	//动作
	public function connect() {
		$d = \Db::table( 'news' )->get();
		p( $d );
	}

	public function core() {
		//		$d= Db::table('news')->insert(['title'=>'后盾人','qq'=>'2300071698']);
		//		p(Db::getQueryLog());
		//		dd($d);

		//		$d = Db::execute("update hd_news set click=? where id=?",[115,2]);
		//		dd($d);

		//		$d= Db::table('news')->get();
		//		p($d);

		//		Db::table('news')->replace(['title'=>'后盾云','click'=>88]);

		//		Db::table('news')->where("id",1)->update(['title'=>'后盾网论坛']);

		//		$d = Db::table('news')->delete([1,2]);
		//		dd($d);
		//		Db::table("news")->where('id',1)->decrement('click',99);
		//		$d = Db::table('news')->insertGetId(['title'=>'向军']);
		//		dd($d);
		$db = Db::table( 'news' );
		$db->delete( [ 1, 13 ] );
		dd( $db->getAffectedRow() );
	}

	//查询构造器
	public function query() {
		//		$d = Db::table('news')->get(['title']);
		//		p($d);
		//		$d=  Db::table('news')->where('id',1)->first();
		//		$d=  Db::table('news')->find(2);
		//		$d = Db::table('news')->where('id',2)->pluck('title');
//		$d = Db::table( 'news' )->where( 'id', '>=', 1 )->lists( 'id,title,click' );
		$d = Db::table('news')->field('title as t')->get();
		p( $d );
	}
}





























