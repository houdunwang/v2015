<?php namespace hdphp\middleware;
/**
 * 表单令牌验证
 * Class Csrf
 * @package hdphp\middleware
 */
class Csrf {
	public function run() {
		//获取令牌,不存在时创建令牌
		if ( ! $token = Session::get( 'csrf_token' ) ) {
			$token = md5( clientIp() . microtime( true ) );
			Session::set( 'csrf_token', $token );
		}

		//令牌检测
		if ( IS_POST && Config::get( 'csrf.open' ) ) {
			if ( Request::post( 'csrf_token' ) != $token ) {
				/**
				 * 存在过滤的验证时忽略验证
				 */
				foreach ( (array) c( 'csrf.except' ) as $f ) {
					if ( preg_match( "@$f@", __URL__ ) ) {
						return;
					}
				}
				throw new \Exception( 'CSRF 令牌验证失败' );
			}
		}
	}
}