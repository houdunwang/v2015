<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\kernel;

class Loader {
	// 类库映射
	protected static $alias = [ ];

	// 注册自动加载机制
	public static function register( $autoload = '' ) {
		spl_autoload_register( $autoload ? $autoload : [ 'hdphp\kernel\Loader', 'autoload' ] );
	}

	//自动加载文件
	public static function autoloadFile() {
		foreach ( \Config::get( 'app.auto_load_file' ) as $f ) {
			if ( is_file( $f ) ) {
				include $f;
			}
		}
	}

	//类库映射
	public static function addMap( $alias, $namespace = '' ) {
		if ( is_array( $alias ) ) {
			foreach ( $alias as $key => $value ) {
				self::$alias[ $key ] = $value;
			}
		} else {
			self::$alias[ $alias ] = $namespace;
		}
	}

	//类自动加载
	public static function autoload( $class ) {
		$file = str_replace( '\\', DS, $class ) . '.php';
		if ( isset( self::$alias[ $class ] ) ) {
			//检测类库映射
			require_once str_replace( '\\', DS, self::$alias[ $class ] );
		} else if ( is_file( ROOT_PATH . DS . $file ) ) {
			require_once ROOT_PATH . DS . $file;
		} else if ( class_exists( 'Config', FALSE ) ) {
			//自动加载命名空间
			foreach ( (array) \Config::get( 'app.autoload_namespace' ) as $key => $value ) {
				if ( strpos( $class, $key ) !== FALSE ) {
					$file = str_replace( $key, $value, $class ) . '.php';
					require_once( str_replace( '\\', DS, $file ) );
				}
			}
		}
	}
}