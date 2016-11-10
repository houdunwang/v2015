<?php namespace wechat;
/**
 * 微信操作的基础类
 * Class Wx
 * @package wechat
 */
class Wx {
	//微信的配置项
	static $config = [ ];
	//粉丝发来的消息内容
	protected $message;

	public function __construct( array $config = [ ] ) {
		if ( ! empty( $config ) ) {
			self::$config = $config;
		}
		$this->message = $this->parsePostRequestData();
	}

	//与微信服务器进行绑定
	public function valid() {
		//只有以下这些get参数时,才是微信绑定服务器的行为
		if ( isset( $_GET["signature"] ) && isset( $_GET["timestamp"] ) && isset( $_GET["nonce"] ) && isset( $_GET["echostr"] ) ) {
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce     = $_GET["nonce"];
			$token     = self::$config['token'];
			$tmpArr    = [ $token, $timestamp, $nonce ];
			sort( $tmpArr, SORT_STRING );
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			if ( $tmpStr == $signature ) {
				echo $_GET["echostr"];
			}
		}
	}

	//获取粉丝发来的消息内容
	public function getMessage() {
		return $this->message;
	}

	//获取并解析粉丝发来的消息内容
	private function parsePostRequestData() {
		if ( isset( $GLOBALS['HTTP_RAW_POST_DATA'] ) ) {
			return simplexml_load_string( $GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA );
		}
	}

	//获取功能实例如消息管理实例
	//wx->instance('message');
	public function instance( $name ) {
		$class = '\wechat\build\\' . ucfirst( $name );

		return new $class;
	}

}




















