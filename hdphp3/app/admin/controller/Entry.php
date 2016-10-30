<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\admin\controller;

//后台入口
use system\model\User;

class Entry {
	public function __construct() {
		Middleware::set( 'auth', [ 'except' => [ 'login' ] ] );
	}

	//后台主页
	public function index() {
		return view();
	}

	public function login() {
		if ( IS_POST ) {
			Validate::make( [
				[ 'username', 'required', '用户名不能为空' ],
				[ 'password', 'required', '密码不能为空' ],
			] );
			$user = Db::table( 'user' )->where( 'username', Request::post( 'username' ) )->first();
			if ( empty( $user ) ) {
				message( '帐号不存在', '', 'error' );
			}
			if ( decrypt( $user['password'] ) != Request::post( 'password' ) ) {
				message( '密码错误', '', 'error' );
			}
			Session::set( 'uid', $user['uid'] );
			message( '登录成功', 'index', 'success' );
		}

		return view();
	}
}
