<?php namespace web\home\controller;
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

class Entry {
	public function __construct() {
		Middleware::set( 'auth', [ 'except' => [ 'login' ] ] );
	}

	//首页
	public function index() {
		if ( IS_POST ) {

		}
		View::make();
	}

	//登录
	public function login() {
		if ( IS_POST ) {
			if ( m( 'User' )->login() ) {
				message( '登录成功', 'index', 'success' );
			}
			message( m( 'User' )->getError(), 'refresh', 'warning' );
		}

		View::make();
	}

	//退出
	public function logout() {
		session_unset();
		session_destroy();
		message( '你已经成功退出登录', 'login', 'success' );
	}
}