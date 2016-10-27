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
		define( 'IS_MOBILE', $this->isMobile() );

	}

	public function query( $name, $value, $method = [ ] ) {
		$exp = explode( '.', $name );
		if ( empty( $exp ) || ! method_exists( $this, $exp[0] ) ) {
			return null;
		}
		$action = array_shift( $exp );

		return $this->$action( implode( '.', $exp ), $value, $method );
	}

	public function get( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['GET'];
		}
		$data = Arr::get( self::$items['GET'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	public function post( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['POST'];
		}
		$data = Arr::get( self::$items['POST'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	public function cookie( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['COOKIE'];
		}
		$data = Arr::get( self::$items['COOKIE'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	public function request( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['REQUEST'];
		}
		$data = Arr::get( self::$items['REQUEST'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	public function globals( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['GLOBALS'];
		}
		$data = Arr::get( self::$items['GLOBALS'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	public function session( $name = '', $value = null, $method = [ ] ) {
		if ( empty( $name ) ) {
			return self::$items['SESSION'];
		}
		$data = Arr::get( self::$items['SESSION'], $name );
		if ( $data && $method ) {
			return Tool::batchFunctions( $data );
		}

		return $data ?: $value;
	}

	//客户端IP
	public function ip( $type = 0 ) {
		return clientIp($type);
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

	//手机判断
	public function isMobile() {
		//微信客户端检测
		if ( IS_WEIXIN ) {
			return true;
		}
		if ( ! empty( $_GET['mobile'] ) ) {
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