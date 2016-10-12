<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\route;

use Exception;
use ReflectionMethod;

//控制器处理类
class Controller {
	//路由参数
	protected static $routeArgs = [ ];

	public static function run( $routeArgs = [ ] ) {
		self::$routeArgs = $routeArgs;
		//URL结构处理
		$param = array_filter( explode( '/', q( 'get.' . c( 'http.url_var' ) ) ) );
		switch ( count( $param ) ) {
			case 2:
				array_unshift( $param, c( 'http.default_module' ) );
				break;
			case 1:
				array_unshift( $param, c( 'http.default_controller' ) );
				array_unshift( $param, c( 'http.default_module' ) );
				break;
			case 0:
				array_unshift( $param, c( 'http.default_action' ) );
				array_unshift( $param, c( 'http.default_controller' ) );
				array_unshift( $param, c( 'http.default_module' ) );
				break;
		}
		$_GET[ c( 'http.url_var' ) ] = implode( '/', $param );
		$param[1]                    = preg_replace_callback( '/_([a-z])/', function ( $matches ) {
			return ucfirst( $matches[1] );
		}, $param[1] );
		define( 'MODULE', $param[0] );
		define( 'CONTROLLER', ucfirst( $param[1] ) );
		define( 'ACTION', $param[2] );
		define( 'MODULE_PATH', ROOT_PATH . '/app/' . MODULE );
		define( 'VIEW_PATH', MODULE_PATH . '/' . 'view' );
		define( '__VIEW__', __ROOT__ . '/app/' . MODULE . '/view' );
		self::action();
	}

	//执行动作
	private static function action() {
		//禁止使用模块检测
		if ( in_array( MODULE, C( 'http.deny_module' ) ) ) {
			throw new Exception( "模块禁止访问" );
		}
		$class = 'app\\' . MODULE . '\\controller\\' . CONTROLLER;
		//控制器不存在
		if ( ! class_exists( $class ) ) {
			throw new Exception( "{$class} 不存在" );
		}
		$controller = Route::$app->make( $class, TRUE );
		//执行控制器中间件
		\Middleware::performControllerMiddleware();
		//执行动作
		try {
			$reflection = new ReflectionMethod( $controller, ACTION );
			if ( $reflection->isPublic() ) {
				//执行动作
				if ( $result = call_user_func_array( [ $controller, ACTION ], self::$routeArgs ) ) {
					if ( IS_AJAX && is_array( $result ) ) {
						ajax( $result );
					} else {
						echo( $result );
					}
				}
			} else {
				throw new ReflectionException( '请求地址不存在' );
			}

		} catch ( ReflectionException $e ) {
			$action = new ReflectionMethod( $controller, '__call' );
			$action->invokeArgs( $controller, [ ACTION, '' ] );
		}
	}
}