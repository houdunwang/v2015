<?php namespace hdphp\middleware;
/**
 * 全局中间件
 * Class App
 * @package hdphp\middleware\build
 */
class App {
	//执行中间件
	public function run() {
		//分配表单验证数据
		View::with( 'errors', Session::flash( 'errors' ) );
		//清除闪存
		Session::flash( '[del]' );
		$this->csrf();
	}

	//令牌验证
	protected function csrf() {
		//获取令牌,不存在时创建令牌
		if ( ! $token = Session::get( 'csrf_token' ) ) {
			$token = md5( clientIp() . microtime( true ) );
			Session::set( 'csrf_token', $token );
		}
		if ( IS_POST ) {
			if ( Config::get( 'app.csrf' ) ) {
				if ( Request::post( 'csrf_token' ) != $token ) {
					throw new \Exception( 'CSRF 令牌验证失败' );
				}
			}
		}
	}
}