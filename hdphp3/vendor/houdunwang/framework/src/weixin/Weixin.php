<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\weixin;

class Weixin extends Error {
	protected $appid;
	protected $appsecret;
	//access_token
	protected $access_token;

	//微信服务器发来的数据
	protected $message;

	//API 根地址
	protected $apiUrl = 'https://api.weixin.qq.com';

	public function __construct() {
		$this->appid        = c( 'weixin.appid' );
		$this->appsecret    = c( 'weixin.appsecret' );
		$this->access_token = $this->getAccessToken();
		//处理 微信服务器 发来的数据
		$this->message = $this->parsePostRequestData();
	}

	//获取微信服务器发来的消息（官网消息或用户消息)
	public function getMessage() {
		return $this->message;
	}

	//解析微信发来的POST/XML数据
	private function parsePostRequestData() {
		if ( isset( $GLOBALS['HTTP_RAW_POST_DATA'] ) ) {
			$post = $GLOBALS['HTTP_RAW_POST_DATA'];

			return simplexml_load_string( $post, 'SimpleXMLElement', LIBXML_NOCDATA );
		}
	}

	//微信接口整合验证进行绑定
	public function valid() {
		if ( ! isset( $_GET["echostr"] ) || ! isset( $_GET["signature"] ) || ! isset( $_GET["timestamp"] ) || ! isset( $_GET["nonce"] ) ) {
			return FALSE;
		}

		$echoStr   = $_GET["echostr"];
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce     = $_GET["nonce"];
		$token     = c( 'weixin.token' );
		$tmpArr    = [ $token, $timestamp, $nonce ];
		sort( $tmpArr, SORT_STRING );
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if ( $tmpStr == $signature ) {
			echo $echoStr;
			exit;
		} else {
			return FALSE;
		}
	}

	/**
	 * 获取accessToken
	 * access_token是公众号的全局唯一票据，公众号调用各接口时都需使用access_token。开发者需要进行妥善保存。access_token的存储
	 * 至少要保留512个字符空间。access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效，
	 * 每天可获取2000次
	 * 服务器返回的 access_token 过期时间，一般2小时
	 *
	 * @param string $cacheKey 缓存key
	 * @param bool $force 强制获取
	 *
	 * @return bool
	 */
	public function getAccessToken( $cacheKey = '', $force = FALSE ) {
		$cacheKey = $cacheKey ?: md5( c( 'weixin.appid' ) . c( 'weixin.appsecret' ) );

		if ( $force === FALSE && $token = Cache::dir( 'storage/weixin' )->get( $cacheKey ) ) {
			$this->access_token = $token;

			return $token;
		}

		$url = $this->apiUrl . '/cgi-bin/token?grant_type=client_credential&appid=' . c( 'weixin.appid' ) . '&secret=' . c( 'weixin.appsecret' );

		$data = Curl::get( $url );

		$json = json_decode( $data, TRUE );

		if ( array_key_exists( 'errcode', $json ) && $json['errcode'] != 0 ) {
			//获取失败
			return FALSE;
		} else {
			$this->access_token = $json['access_token'];
			$this->expires_in   = (int) $json['expires_in'];
			//应该保存缓存。。。
			Cache::dir( 'storage/weixin' )->set( $cacheKey, $this->access_token, 7000 );

			return $this->access_token;
		}
	}

	//将数据中的中文转url编码，因为微信不能识别\uxxx json_encode后的中文
	protected function urlencodeArray( $data ) {
		$result = [ ];
		foreach ( $data as $i => $d ) {
			$result[ urlencode( $i ) ] = is_array( $d ) ? $this->urlencodeArray( $d ) : urlencode( $d );
		}

		return $result;
	}

	//产生随机字符串，不长于32位
	public function getRandStr( $length = 32 ) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str   = "";
		for ( $i = 0;$i < $length;$i ++ ) {
			$str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
		}

		return $str;
	}

	//生成签名,支付或红包等使用
	public function makeSign( $data ) {
		//签名步骤一：按字典序排序参数
		ksort( $data );
		$string = $this->ToUrlParams( $data );
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=" . c( 'weixin.key' );
		//签名步骤三：MD5加密
		$string = md5( $string );
		//签名步骤四：所有字符转为大写
		$result = strtoupper( $string );

		return $result;
	}

	//格式化参数格式化成url参数 为生成签名服务
	protected function ToUrlParams( $data ) {
		$buff = "";
		foreach ( $data as $k => $v ) {
			if ( $k != "sign" && $k != "key" && $v != "" && ! is_array( $v ) ) {
				$buff .= $k . "=" . $v . "&";
			}
		}

		$buff = trim( $buff, "&" );

		return $buff;
	}

	//获取实例
	public function instance( $type ) {
		$class = '\hdphp\weixin\build\\' . ucfirst( $type );

		return new $class;
	}

}