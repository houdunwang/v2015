<?php namespace system\middleware;

class Auth {
	//执行中间件
	public function run() {
		if ( ! Session::get( 'uid' ) ) {
			go( 'admin/entry/login' );
		}
	}
}