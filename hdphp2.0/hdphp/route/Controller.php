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
		define( 'MODULE_PATH', APP_PATH . '/' . MODULE );
		define( 'VIEW_PATH', defined( 'MODULE_PATH' ) ? MODULE_PATH . '/' . 'view' : C( 'view.path' ) );
		define( '__VIEW__', __ROOT__ . '/' . rtrim( VIEW_PATH, '/' ) );
		self::action();
	}

	//执行动作
	private static function action() {
		//禁止使用模块检测
		if ( in_array( MODULE, C( 'http.deny_module' ) ) ) {
			_404();
		}
		$class = APP . '\\' . MODULE . '\\controller\\' . CONTROLLER;
		//控制器不存在
		if ( ! class_exists( $class ) ) {
			if ( DEBUG ) {
				throw new Exception( "{$class} 不存在" );
			} else {
				_404();
			}
		}
		$controller = Route::$app->make( $class, TRUE );
		$action     = method_exists( $controller, ACTION ) ? ACTION : '__empty';
		//执行中间件
		\Middleware::run();
		//执行动作
		try {
			$reflection = new ReflectionMethod( $controller, $action );
			if ( $reflection->isPublic() ) {
				//执行动作
				if ( $result = call_user_func_array( [ $controller, $action ], self::$routeArgs ) ) {
					if ( IS_AJAX ) {
						\Response::ajax( $result );
					} else {
						die( $result );
					}
				}
			} else {
				if ( DEBUG ) {
					throw new ReflectionException( '动作不存在' );
				} else {
					success( '页面不存在', __ROOT__, 'error' );
				}
			}

		} catch ( ReflectionException $e ) {
			$action = new ReflectionMethod( $controller, '__call' );
			$action->invokeArgs( $controller, [ ACTION, '' ] );
		}
	}
}