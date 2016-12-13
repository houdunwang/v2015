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
		$param = array_filter( explode( '/', Request::get( c( 'http.url_var' ) ) ) );
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
		Request::set( 'get.' . c( 'http.url_var' ), implode( '/', $param ) );
		$param[1] = preg_replace_callback( '/_([a-z])/', function ( $matches ) {
			return ucfirst( $matches[1] );
		}, $param[1] );
		define( 'MODULE', $param[0] );
		define( 'CONTROLLER', ucfirst( $param[1] ) );
		define( 'ACTION', $param[2] );
		define( 'MODULE_PATH', ROOT_PATH . '/' . c( 'app.path' ) . '/' . MODULE );
		define( 'VIEW_PATH', MODULE_PATH . '/' . 'view' );
		define( '__VIEW__', __ROOT__ . '/' . c( 'app.path' ) . '/' . MODULE . '/view' );
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
		$controller = App::make( $class, true );
		//执行控制器中间件
		Middleware::controller();

		//执行动作
		try {
			/**
			 * 参数处理
			 * 控制器路由方式访问时解析路由参数并注入到控制器方法参数中
			 */
			//反射方法实例
			$reflectionMethod = new \ReflectionMethod( $class, ACTION );
			$args             = [ ];
			foreach ( $reflectionMethod->getParameters() as $k => $p ) {
				if ( isset( self::$routeArgs[ $p->name ] ) ) {
					//如果GET变量中存在则将GET变量值赋予,也就是说GET优先级高
					$args[ $p->name ] = self::$routeArgs[ $p->name ];
				} else {
					//如果类型为类时分析类
					if ( $dependency = $p->getClass() ) {
						$args[ $p->name ] = App::build( $dependency->name );
					} else {
						//普通参数时获取默认值
						$args[ $p->name ] = App::resolveNonClass( $p );
					}
				}
			}
			//执行控制器方法
			$result = $reflectionMethod->invokeArgs( $controller, $args );
			if ( IS_AJAX && is_array( $result ) ) {
				ajax( $result );
			} else {
				echo( $result );
			}
		} catch ( ReflectionException $e ) {
			$action = new ReflectionMethod( $controller, '__call' );
			$action->invokeArgs( $controller, [ ACTION, '' ] );
		}
	}
}