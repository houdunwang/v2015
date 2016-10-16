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
		return View::make()->with( 'url', 'www.houdunren.com' );
	}

	public function assign() {
		//success error   warning
		message( '操作成功', 'refresh', 'warning', 95 );

		//		confirm( '你确定删除吗?', u('post'), u('cancel') );
	}

	public function post() {
		echo '执行了post...';
	}

	public function cancel() {
		echo '执行了  cancel';

	}

}




























