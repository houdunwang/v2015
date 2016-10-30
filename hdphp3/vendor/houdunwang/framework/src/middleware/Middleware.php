<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\middleware;

class Middleware {
	protected $app;

	protected static $run = [ ];

	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * 添加控制器执行的中间件
	 *
	 * @param string $name 中间件名称
	 * @param array $mod 类型
	 *  ['only'=>array('a','b')] 仅执行a,b控制器动作
	 *  ['except']=>array('a','b')], 除了a,b控制器动作
	 */
	public function set( $name, $mod = [ ] ) {
		if ( $mod ) {
			foreach ( $mod as $type => $data ) {
				switch ( $type ) {
					case 'only':
						if ( in_array( ACTION, $data ) ) {
							self::$run[] = Config::get( 'middleware.controller.' . $name );
						}
						break;
					case 'except':
						if ( ! in_array( ACTION, $data ) ) {
							self::$run[] = Config::get( 'middleware.controller.' . $name );
						}
						break;
				}
			}
		} else {
			self::$run[] = Config::get( 'middleware.controller.' . $name );
		}
	}

	//执行控制器中间件
	public function controller() {
		foreach ( self::$run as $class ) {
			if ( class_exists( $class ) ) {
				$obj = $this->app->make( $class );
				if ( method_exists( $obj, 'run' ) ) {
					$obj->run();
				}
			}
		}
	}

	//执行全局中间件
	public function globals() {
		$middleware = array_unique( c( 'middleware.global' ) );
		foreach ( $middleware as $class ) {
			if ( class_exists( $class ) ) {
				$obj = $this->app->make( $class );
				if ( method_exists( $obj, 'run' ) ) {
					$obj->run();
				}
			}
		}
	}

	//执行应用中间件
	public function exe( $name ) {
		$class = c( 'middleware.web.' . $name );
		$obj   = $this->app->make( $class );
		if ( method_exists( $obj, 'run' ) ) {
			$obj->run();
		}
	}
}