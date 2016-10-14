<?php namespace app\home\controller;

class Entry {
	public function index() {
		//		dd(u('admin/user/add',['id'=>1,'cid'=>22]));
		return view();
	}

	public function add() {
		echo 'add...';
	}

	public function change() {
		//		View::with( 'a', 23 );
		View::with( "data", [ 'username' => '后盾网', "url" => 'houdunwang.com' ] );
		View::with( "news", [ 'title' => '后盾人在线学习平台' ] );

//		return view()->with( 'url', 'houdunren.com' );
//		return View::with('url','www.houdunren.com')->make();
		return View::make()->with('url','www.houdunren.com');
	}
}