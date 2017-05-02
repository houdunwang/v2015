<?php namespace system\service\build;
//用户管理服务
class User {
	//是否登录
	public function isLogin() {
		return Session::get( 'uid' );
	}
}