<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\error;
//错误处理
class Error {

	private $app;

	public function __construct( $app ) {
//		error_reporting(E_ALL);
		$this->app = $app;

	}

	public function bootstrap() {
		set_error_handler( [ $this, 'error' ], E_ALL );
		set_exception_handler( [ $this, 'exception' ] );
		register_shutdown_function( [ $this, 'fatalError' ] );
	}

	//自定义异常理
	public function exception( $e ) {
		Log::write( $e->getMessage(), 'EXCEPTION' );
		//命令行模式
		IS_CLI and \hdphp\cli\Cli::error( $e->getMessage() );
		if ( c( 'app.debug' ) ) {
			require __DIR__ . '/view/exception.php';
		} else {
			_404();
		}
	}

	//错误处理
	public function error( $errno, $error, $file, $line ) {
		$msg = $error . "($errno)" . $file . " ($line).";
		//命令行模式
		IS_CLI and \hdphp\cli\Cli::error( $msg );
		switch ( $errno ) {
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_DEPRECATED:
				break;
			default:
				if ( c( 'app.debug' ) ) {
					require __DIR__ . '/view/debug.php';
				} else {
					class_exists( 'Log', FALSE ) && Log::write( $msg, $this->errorType( $errno ) );
					_404();
				}
		}
	}

	//致命错误处理
	public function fatalError() {
		if ( function_exists( 'error_get_last' ) ) {
			if ( $e = error_get_last() ) {
				$errno = $this->errorType( $e['type'] );
				$error = $e['message'];
				$file  = $e['file'];
				$line  = $e['line'];
				$this->error( $errno, $error, $file, $line );
				exit;
			}
		}
	}

	/**
	 * 获取错误标识
	 *
	 * @param $type
	 *
	 * @return string
	 */
	public function errorType( $type ) {
		switch ( $type ) {
			case E_ERROR: // 1 //
				return 'E_ERROR';
			case E_WARNING: // 2 //
				return 'E_WARNING';
			case E_PARSE: // 4 //
				return 'E_PARSE';
			case E_NOTICE: // 8 //
				return 'E_NOTICE';
			case E_CORE_ERROR: // 16 //
				return 'E_CORE_ERROR';
			case E_CORE_WARNING: // 32 //
				return 'E_CORE_WARNING';
			case E_COMPILE_ERROR: // 64 //
				return 'E_COMPILE_ERROR';
			case E_COMPILE_WARNING: // 128 //
				return 'E_COMPILE_WARNING';
			case E_USER_ERROR: // 256 //
				return 'E_USER_ERROR';
			case E_USER_WARNING: // 512 //
				return 'E_USER_WARNING';
			case E_USER_NOTICE: // 1024 //
				return 'E_USER_NOTICE';
			case E_STRICT: // 2048 //
				return 'E_STRICT';
			case E_RECOVERABLE_ERROR: // 4096 //
				return 'E_RECOVERABLE_ERROR';
			case E_DEPRECATED: // 8192 //
				return 'E_DEPRECATED';
			case E_USER_DEPRECATED: // 16384 //
				return 'E_USER_DEPRECATED';
		}

		return $type;
	}

	/**
	 * trace 信息
	 *
	 * @param  string $value 变量
	 * @param  string $label 标签
	 * @param  string $level 日志级别(或者页面Trace的选项卡)
	 * @param  boolean $record 是否记录日志
	 *
	 * @return void|array
	 */
	public function trace( $value = '[hdphp]', $label = '', $level = 'DEBUG', $record = FALSE ) {
		static $trace = [ ];

		if ( '[hdphp]' === $value ) {
			// 获取trace信息
			return $trace;
		} else {
			$info  = ( $label ? $label . ':' : '' ) . print_r( $value, TRUE );
			$level = strtoupper( $level );
			if ( IS_AJAX || $record ) {
				Log::record( $info, $level, $record );
			} else {
				if ( ! isset( $trace[ $level ] ) ) {
					$trace[ $level ] = [ ];
				}
				$trace[ $level ][] = $info;
			}
		}
	}
}