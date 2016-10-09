<?php namespace system\middleware;
class Auth {
	//执行中间件
	public function run() {
		if ( ! Session::get( 'user' ) ) {
			go( 'home/entry/login' );
		}
	}
}