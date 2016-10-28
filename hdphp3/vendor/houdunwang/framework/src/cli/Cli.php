<?php namespace hdphp\cli;

/**
 * 命令行模式
 * Class Cli
 * @package hdphp\cli
 * @author 向军 <2300071698@qq.com>
 */
class Cli {
	public function __construct() {
	}

	//运行
	public function bootstrap() {
		//去掉hd
		array_shift( $_SERVER['argv'] );
		$info = explode( ':', array_shift( $_SERVER['argv'] ) );
		//命令类
		$class  = 'hdphp\cli\\' . ucfirst( $info[0] );
		$action = isset( $info[1] ) ? $info[1] : 'run';
		//实例
		if ( class_exists( $class ) ) {
			$instance = new $class();
			call_user_func_array( [ $instance, $action ], $_SERVER['argv'] );
		} else {
			$this->error( 'Command does not exist' );
		}
	}

	//输出错误信息
	final public function error( $content ) {
		die( "\033[;36m $content \x1B[0m\n" );
	}

	//成功信息
	final public function success( $content ) {
		die( "\033[;32m $content \x1B[0m\n" );
	}
}


