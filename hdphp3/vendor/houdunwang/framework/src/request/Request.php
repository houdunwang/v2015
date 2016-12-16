<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\request;
//请求处理
class Request {
	static $items = [ ];

	public function __construct() {
		self::$items['GET']     = $_GET;
		self::$items['POST']    = $_POST;
		self::$items['REQUEST'] = $_REQUEST;
		self::$items['SERVER']  = $_SERVER;
		self::$items['GLOBALS'] = $GLOBALS;
		self::$items['SESSION'] = Session::all();
		self::$items['COOKIE']  = Cookie::all();
	}

	/**
	 * 获取数据
	 *
	 * @param $name
	 * @param $value
	 * @param array $method
	 *
	 * @return null
	 */
	public function query( $name, $value = null, $method = [ ] ) {
		$exp    = explode( '.', $name );
		$action = array_shift( $exp );

		return $this->__call( $action, [ implode( '.', $exp ), $value, $method ] );
	}

	/**
	 * 设置值
	 *
	 * @param $name 类型如get.name,post.id
	 * @param $value
	 *
	 * @return bool
	 */
	public function set( $name, $value ) {
		$info   = explode( '.', $name );
		$action = strtoupper( array_shift( $info ) );
		if ( isset( self::$items[ $action ] ) ) {
			self::$items[ $action ] = Arr::set( self::$items[ $action ], implode( '.', $info ), $value );

			return true;
		}
	}

	/**
	 * 获取数据
	 * 示例: Request::get('name')
	 *
	 * @param $action 类型如get,post
	 * @param $arguments 参数结构如下
	 * [
	 *  'name'=>'变量名',//config.a 可选
	 *  'value'=>'默认值',//可选
	 *  'method'=>'回调函数',//数组类型 可选
	 * ]
	 *
	 * @return mixed
	 */
	public function __call( $action, $arguments ) {
		$action = strtoupper( $action );
		if ( empty( $arguments ) ) {
			return self::$items[ $action ];
		}
		$data = Arr::get( self::$items[ $action ], $arguments[0] );
		if ( ! is_null( $data ) && ! empty( $arguments[2] ) ) {
			return Tool::batchFunctions( $arguments[2], $data );
		}

		return is_null( $data ) ? $arguments[1] : $data;
	}

	//客户端IP
	public function ip( $type = 0 ) {
		$type = intval( $type );
		//保存客户端IP地址
		if ( isset( $_SERVER ) ) {
			if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if ( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} else if ( isset( $_SERVER["REMOTE_ADDR"] ) ) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				return '';
			}
		} else {
			if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
				$ip = getenv( "HTTP_X_FORWARDED_FOR" );
			} else if ( getenv( "HTTP_CLIENT_IP" ) ) {
				$ip = getenv( "HTTP_CLIENT_IP" );
			} else if ( getenv( "REMOTE_ADDR" ) ) {
				$ip = getenv( "REMOTE_ADDR" );
			} else {
				return '';
			}
		}
		$long     = ip2long( $ip );
		$clientIp = $long ? [ $ip, $long ] : [ "0.0.0.0", 0 ];

		return $clientIp[ $type ];
	}

	//判断请求来源是否为本网站域名
	public function isDomain() {
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$referer = parse_url( $_SERVER['HTTP_REFERER'] );
			$root    = parse_url( __ROOT__ );

			return $referer['host'] == $root['host'];
		}
	}

	//https请求
	public function isHttps() {
		if ( isset( $_SERVER['HTTPS'] ) && ( '1' == $_SERVER['HTTPS'] || 'on' == strtolower( $_SERVER['HTTPS'] ) ) ) {
			return true;
		} elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}

		return false;
	}

	//微信客户端检测
	public function isWeChat() {
		return isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false;
	}

	//手机客户端判断
	public function isMobile() {
		//微信客户端检测
		if ( $this->isWeChat() ) {
			return true;
		}
		if ( ! empty( $_GET['_mobile'] ) ) {
			return true;
		}
		$_SERVER['ALL_HTTP'] = isset( $_SERVER['ALL_HTTP'] ) ? $_SERVER['ALL_HTTP'] : '';
		$mobile_browser      = '0';
		if ( preg_match( '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower( $_SERVER['HTTP_USER_AGENT'] ) ) ) {
			$mobile_browser ++;
		}
		if ( ( isset( $_SERVER['HTTP_ACCEPT'] ) ) and ( strpos( strtolower( $_SERVER['HTTP_ACCEPT'] ), 'application/vnd.wap.xhtml+xml' ) !== false ) ) {
			$mobile_browser ++;
		}
		if ( isset( $_SERVER['HTTP_X_WAP_PROFILE'] ) ) {
			$mobile_browser ++;
		}
		if ( isset( $_SERVER['HTTP_PROFILE'] ) ) {
			$mobile_browser ++;
		}
		$mobile_ua     = strtolower( substr( $_SERVER['HTTP_USER_AGENT'], 0, 4 ) );
		$mobile_agents = [
			'w3c ',
			'acs-',
			'alav',
			'alca',
			'amoi',
			'audi',
			'avan',
			'benq',
			'bird',
			'blac',
			'blaz',
			'brew',
			'cell',
			'cldc',
			'cmd-',
			'dang',
			'doco',
			'eric',
			'hipt',
			'inno',
			'ipaq',
			'java',
			'jigs',
			'kddi',
			'keji',
			'leno',
			'lg-c',
			'lg-d',
			'lg-g',
			'lge-',
			'maui',
			'maxo',
			'midp',
			'mits',
			'mmef',
			'mobi',
			'mot-',
			'moto',
			'mwbp',
			'nec-',
			'newt',
			'noki',
			'oper',
			'palm',
			'pana',
			'pant',
			'phil',
			'play',
			'port',
			'prox',
			'qwap',
			'sage',
			'sams',
			'sany',
			'sch-',
			'sec-',
			'send',
			'seri',
			'sgh-',
			'shar',
			'sie-',
			'siem',
			'smal',
			'smar',
			'sony',
			'sph-',
			'symb',
			't-mo',
			'teli',
			'tim-',
			'tosh',
			'tsm-',
			'upg1',
			'upsi',
			'vk-v',
			'voda',
			'wap-',
			'wapa',
			'wapi',
			'wapp',
			'wapr',
			'webc',
			'winw',
			'winw',
			'xda',
			'xda-',
		];
		if ( in_array( $mobile_ua, $mobile_agents ) ) {
			$mobile_browser ++;
		}
		if ( strpos( strtolower( $_SERVER['ALL_HTTP'] ), 'operamini' ) !== false ) {
			$mobile_browser ++;
		}
		// Pre-final check to reset everything if the user is on Windows
		if ( strpos( strtolower( $_SERVER['HTTP_USER_AGENT'] ), 'windows' ) !== false ) {
			$mobile_browser = 0;
		}
		// But WP7 is also Windows, with a slightly different characteristic
		if ( strpos( strtolower( $_SERVER['HTTP_USER_AGENT'] ), 'windows phone' ) !== false ) {
			$mobile_browser ++;
		}
		if ( $mobile_browser > 0 ) {
			return true;
		} else {
			return false;
		}
	}
}