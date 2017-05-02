<?php namespace hdphp\cli;

/**
 * 命令行模式
 * Class Cli
 * @package hdphp\cli
 * @author 向军 <2300071698@qq.com>
 */
class Cli {
	/**
	 * 运行
	 */
	public static function run() {
		//去掉hd
		array_shift( $_SERVER['argv'] );
		$info = explode( ':', array_shift( $_SERVER['argv'] ) );
		//类文件
		$file = 'hdphp/cli/' . ucfirst( $info[0] ) . '/Command.php';
		if ( ! is_file( $file ) ) {
			self::error( 'Command does not exist' );
		} else {
			require $file;
		}
		//命令类
		$class = 'hdphp\\cli\\' . ucfirst( $info[0] ) . '\Command';
		//实例
		$instance = new $class();
		if ( method_exists( $instance, $info[1] ) ) {
			call_user_func_array( [ $instance, $info[1] ], $_SERVER['argv'] );
		} else {
			self::error( "$info[1] method not found\n" );
		}
	}

	/**
	 * 输出错误信息
	 *
	 * @param $content
	 */
	public static function error( $content ) {
		die( "\033[;36m $content \x1B[0m\n" );
	}
}


