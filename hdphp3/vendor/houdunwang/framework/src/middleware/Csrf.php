<?php namespace hdphp\middleware;
/**
 * 表单令牌验证
 * Class Csrf
 * @package hdphp\middleware
 */
class Csrf {

	public function run() {
		$open = Config::get( 'csrf.open' );
		//服务器令牌数据
		$token = Session::get( 'csrf_token' );
		//不存在时创建令牌
		if ( $open && ! $token ) {
			Session::set( 'csrf_token', md5( clientIp() . microtime( true ) ) );
		}
		//令牌检测
		if ( $open && $token && Request::post() && Request::isDomain() ) {
			if ( Request::post( 'csrf_token' ) != $token ) {
				//存在过滤的验证时忽略验证
				$except = c( 'csrf.except' );
				foreach ( (array) $except as $f ) {
					if ( preg_match( "@$f@", __URL__ ) ) {
						return;
					}
				}
				throw new \Exception( 'CSRF 令牌验证失败' );
			}
		}
	}
}