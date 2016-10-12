<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

//表名加前缀
if ( ! function_exists( 'tablename' ) ) {
	function tablename( $table ) {
		return c( 'database.prefix' ) . $table;
	}
}

/**
 * 显示模板
 */
if ( ! function_exists( 'view' ) ) {
	function view( $tpl = '' ) {
		return View::make( $tpl );
	}
}
/**
 * 集合
 */
if ( ! function_exists( 'collect' ) ) {
	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	function collect( $data ) {
		return \Collection::make( $data );
	}
}
if ( ! function_exists( 'nopic' ) ) {
	function nopic( $file ) {
		return is_file( $file ) ? $file : 'resource/images/nopic.jpg';
	}
}
/**
 * 生成url
 *
 * @param string $path 模块/动作/方法
 * @param array $args GET参数
 *
 * @return mixed|string
 */
if ( ! function_exists( 'u' ) ) {
	function u( $path, $args = [ ] ) {
		if ( empty( $path ) || preg_match( '@^http@i', $path ) ) {
			return $path;
		}
		//URL请求参数
		$urlParam = explode( '/', $_GET[ c( 'http.url_var' ) ] );
		$path     = str_replace( '.', '/', $path );
		switch ( count( explode( '/', $path ) ) ) {
			case 2:
				$path = $urlParam[0] . '/' . $path;
				break;
			case 1:
				$path = $urlParam[0] . '/' . $urlParam[1] . '/' . $path;
				break;
		}
		$url = C( 'http.rewrite' ) ? __ROOT__ : __ROOT__ . '/' . basename( $_SERVER['SCRIPT_FILENAME'] );
		$url .= '?' . c( 'http.url_var' ) . '=' . $path;
		//添加参数
		if ( ! empty( $args ) ) {
			$url .= '&' . http_build_query( $args );
		}

		return $url;
	}
}

/**
 * 操作配置项
 *
 * @param string $name
 * @param string $value
 *
 * @return mixed
 */
if ( ! function_exists( 'c' ) ) {
	function c( $name = '', $value = '' ) {
		if ( $name === '' ) {
			return Config::all();
		}

		if ( $value === '' ) {
			return Config::get( $name );
		}

		return Config::set( $name, $value );
	}
}
/**
 * 请求参数
 *
 * @param $var 变量名
 * @param null $default 默认值
 * @param string $filter 数据处理函数
 *
 * @return mixed
 */
if ( ! function_exists( 'q' ) ) {
	function q( $var, $default = NULL, $filter = '' ) {
		return Request::query( $var, $default, $filter );
	}
}
/**
 * 输出404页面
 */
if ( ! function_exists( '_404' ) ) {
	function _404() {
		\Response::sendHttpStatus( 302 );
		if ( is_file( c( 'view.404' ) ) ) {
			require( c( 'view.404' ) );
		}
		exit;
	}
}
if ( ! function_exists( 'model' ) ) {
	function model( $model ) {
		static $instance = [ ];
		$class = strpos( $model, '\\' ) === FALSE ? '\system\model\\' . ucfirst( $model ) : $model;
		if ( isset( $instance[ $class ] ) ) {
			return $instance[ $class ];
		}

		return $instance[ $class ] = new $class;
	}
}

/**
 * 打印输出数据
 *
 * @param $var
 */
if ( ! function_exists( 'p' ) ) {
	function p( $var ) {
		echo "<pre>" . print_r( $var, TRUE ) . "</pre>";
	}
}

//打印数据有数据类型
if ( ! function_exists( 'dd' ) ) {
	function dd( $var ) {
		ob_start();
		var_dump( $var );
		echo "<pre>" . ob_get_clean() . "</pre>";
	}
}

/**
 * 跳转网址
 *
 * @param $url
 * @param int $time
 * @param string $msg
 */
if ( ! function_exists( 'go' ) ) {
	function go( $url, $time = 0, $msg = '' ) {
		$url = u( $url );
		if ( ! headers_sent() ) {
			$time == 0 ? header( "Location:" . $url ) : header( "refresh:{$time};url={$url}" );
			exit( $msg );
		} else {
			echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
			if ( $msg ) {
				echo( $msg );
			}
			exit;
		}
	}
}
/**
 * 文件缓存
 *
 * @param $name
 * @param string $value
 * @param string $path
 *
 * @return bool
 */
if ( ! function_exists( 'f' ) ) {
	function f( $name, $value = '[get]', $path = 'storage/cache' ) {
		static $cache = [ ];

		$file = $path . '/' . $name . '.php';

		if ( $value == '[del]' ) {
			if ( is_file( $file ) ) {
				unlink( $file );
				if ( isset( $cache[ $name ] ) ) {
					unset( $cache[ $name ] );
				}
			}

			return TRUE;
		}

		if ( $value === '[get]' ) {
			if ( isset( $cache[ $name ] ) ) {
				return $cache[ $name ];
			} else if ( is_file( $file ) ) {
				return $cache[ $name ] = include $file;
			} else {
				return FALSE;
			}
		}

		$data = "<?php if(!defined('ROOT_PATH'))exit;\nreturn " . var_export( $value, TRUE ) . ";\n?>";

		if ( ! is_dir( $path ) ) {
			mkdir( $path, 0755, TRUE );
		}

		if ( ! file_put_contents( $file, $data ) ) {
			return FALSE;
		}

		$cache[ $name ] = $value;

		return TRUE;
	}
}

if ( ! function_exists( 'cli' ) ) {
	function cli() {
		$argv[] = 'hd';
		foreach ( func_get_args() as $v ) {
			$argv[] = $v;
		}
		$_SERVER['argv'] = $argv;
		\hdphp\cli\Cli::run();
	}
}
/**
 * 快速数据库缓存
 *
 * @param $key
 * @param null $value
 *
 * @return mixed
 */
if ( ! function_exists( 'd' ) ) {
	function d( $key, $value = '[get]' ) {
		$db = Db::table( c( 'cache.mysql.table' ) );
		switch ( $value ) {
			case '[get]':
				//获取
				$cache = $db->where( '`key`', $key )->pluck( 'value' );
				if ( $cache ) {
					return unserialize( $cache );
				}
				break;
			case '[del]':
				//删除
				return $db->where( '`key`', '=', $key )->delete();
			case '[truncate]':
				//删除所有缓存
				return $db->truncate();
			default:
				$data = [ 'key' => $key, 'value' => serialize( $value ) ];

				return $db->replace( $data );
		}
	}
}

/**
 * 导入类库
 *
 * @param string $class
 *
 * @return bool
 */
if ( ! function_exists( 'import' ) ) {
	function import( $class ) {
		$file = str_replace( [ '@', '.', '#' ], [ APP_PATH, '/', '.' ], $class );
		if ( is_file( $file ) ) {
			require_once $file;
		} else {
			return FALSE;
		}
	}
}
//打印用户常量
if ( ! function_exists( 'print_const' ) ) {
	function print_const() {
		$d = get_defined_constants( TRUE );
		p( $d['user'] );
	}
}

/**
 * trace
 *
 * @param string $value 变量
 * @param string $label 标签
 * @param string $level 日志级别(或者页面Trace的选项卡)
 * @param bool|false $record 是否记录日志
 *
 * @return mixed
 */
if ( ! function_exists( 'trace' ) ) {
	function trace( $value = '[hdphp]', $label = '', $level = 'DEBUG', $record = FALSE ) {
		return Error::trace( $value, $label, $level, $record );
	}
}
/**
 * 全局变量
 *
 * @param $name 变量名
 * @param string $value 变量值
 *
 * @return mixed 返回值
 */
if ( ! function_exists( 'v' ) ) {
	function v( $name = NULL, $value = '[null]' ) {
		static $vars = [ ];
		if ( is_null( $name ) ) {
			return $vars;
		} else if ( $value == '[null]' ) {
			//取变量
			$tmp = $vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( isset( $tmp[ $d ] ) ) {
					$tmp = $tmp[ $d ];
				} else {
					return NULL;
				}
			}

			return $tmp;
		} else {
			//设置
			$tmp = &$vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( ! isset( $tmp[ $d ] ) ) {
					$tmp[ $d ] = [ ];
				}
				$tmp = &$tmp[ $d ];
			}

			return $tmp = $value;
		}
	}
}
/**
 * 反转义
 *
 * @param array $data
 *
 * @return mixed
 */
if ( ! function_exists( 'unaddslashes' ) ) {
	function unaddslashes( &$data ) {
		foreach ( (array) $data as $k => $v ) {
			if ( is_numeric( $v ) ) {
				$data[ $k ] = $v;
			} else {
				$data[ $k ] = is_array( $v ) ? unaddslashes( $v ) : stripslashes( $v );
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'confirm' ) ) {
	/**
	 * 有确定提示的提示页面
	 *
	 * @param string $message 提示文字
	 * @param string $sUrl 确定按钮跳转的url
	 * @param string $eUrl 取消按钮跳转的url
	 */
	function confirm( $message, $sUrl, $eUrl ) {
		View::with( [ 'message' => $message, 'sUrl' => $sUrl, 'eUrl' => $eUrl ] );
		echo view( Config::get( 'view.confirm' ) );
		exit;
	}
}

if ( ! function_exists( 'ajax' ) ) {
	/**
	 * Ajax输出
	 *
	 * @param  mixed $data 数据
	 * @param string $type 数据类型 text html xml json
	 */
	function ajax( $data, $type = "JSON" ) {
		Response::ajax( $data, $type );
	}
}

/**
 * 获取客户端ip
 */
if ( ! function_exists( 'clientIp' ) ) {
	function clientIp() {
		return \Request::ip();
	}
}

if ( ! function_exists( 'message' ) ) {
	/**
	 * 消息提示
	 *
	 * @param string $content 消息内容
	 * @param string $redirect 跳转地址有三种方式 1:back(返回上一页)  2:refresh(刷新当前页)  3:具体Url
	 * @param string $type 信息类型  success(成功），error(失败），warning(警告），info(提示）
	 */
	function message( $content, $redirect = 'back', $type = 'success', $timeout = 2 ) {
		if ( IS_AJAX ) {
			ajax( [ 'valid' => $type == 'success' ? 1 : 0, 'message' => $content ] );
		} else {
			switch ( $redirect ) {
				case 'back':
					//有回调地址时回调,没有时返回主页
					$url = 'window.history.go(-1)';
					break;
				case 'refresh':
					$url = "location.replace('" . __URL__ . "')";
					break;
				default:
					if ( empty( $redirect ) ) {
						$url = 'window.history.go(-1)';
					} else {
						$url = "location.replace('" . u( $redirect ) . "')";
					}
					break;
			}
			//图标
			switch ( $type ) {
				case 'success':
					$ico = 'fa-check-circle';
					break;
				case 'error':
					$ico = 'fa-times-circle';
					break;
				case 'info':
					$ico = 'fa-info-circle';
					break;
				case 'warning':
					$ico = 'fa-warning';
					break;
			}
			View::with( [
				'content'  => $content,
				'redirect' => $redirect,
				'type'     => $type,
				'url'      => $url,
				'ico'      => $ico,
				'timeout'  => $timeout * 1000
			] );
			echo view( Config::get( 'view.message' ) );
		}
		exit;
	}
}