<?php namespace system\middleware;

class Common {
	//执行中间件
	public function run() {
		//用户已经登录时获取用户资料
		if ( $uid = Session::get( 'uid' ) ) {
			$user = Db::table( 'user' )->find( $uid );
			v( 'user', $user );
		}
	}
}