<?php namespace hdphp\cli;

/**
 * 命令行模式
 * Class Cli
 * @package hdphp\cli
 * @author 向军 <2300071698@qq.com>
 */
class Cli {
	//运行
	public static function run() {
		//去掉hd
		array_shift( $_SERVER['argv'] );
		$info = explode( ':', array_shift( $_SERVER['argv'] ) );
		//命令类
		$class = 'hdphp\cli\\' . $info[0] . '\\' . ucfirst( $info[1] );
		//实例
		if ( class_exists( $class ) ) {
			$instance = new $class();
			call_user_func_array( [ $instance, 'run' ], $_SERVER['argv'] );
		} else {
			self::error( 'Command does not exist' );
		}
	}

	//输出错误信息
	public static function error( $content ) {
		if ( IS_CLI ) {
			die( "\033[;36m $content \x1B[0m\n" );
		} else {
			message( $content, 'back', 'error' );
		}
	}

	//成功信息
	public static function success( $content ) {
		if ( IS_CLI ) {
			die( "\033[;32m $content \x1B[0m\n" );
		} else {
			message( $content, 'back', 'error' );
		}
	}
}


