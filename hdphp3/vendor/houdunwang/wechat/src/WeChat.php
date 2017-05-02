<?php namespace wechat;
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class WeChat extends Error {
	use Xml;
	//配置项
	protected static $config = [ ];
	//access_token
	protected $access_token;
	//微信服务器发来的数据
	protected $message;
	//API 根地址
	protected $apiUrl = 'https://api.weixin.qq.com';

	public function __construct( array $config = [ ] ) {
		if ( empty( $config ) && defined( 'HDPHP_PATH' ) && function_exists( 'c' ) ) {
			$config = c( 'wechat' );
		}
		if ( ! empty( $config ) ) {
			self::$config = $config;
		}
		$this->access_token = $this->getAccessToken();
		//处理 微信服务器 发来的数据
		$this->message = $this->parsePostRequestData();
	}

	//设置配置项
	public function config( $config ) {
		self::$config = $config;
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
			return false;
		}
		$echoStr   = $_GET["echostr"];
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce     = $_GET["nonce"];
		$token     = self::$config['token'];
		$tmpArr    = [ $token, $timestamp, $nonce ];
		sort( $tmpArr, SORT_STRING );
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if ( $tmpStr == $signature ) {
			echo $echoStr;
			exit;
		} else {
			return false;
		}
	}

	/**
	 * 获取accessToken
	 * access_token是公众号的全局唯一票据，公众号调用各接口时都需使用access_token。开发者需要进行妥善保存。access_token的存储
	 * 至少要保留512个字符空间。access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效，
	 * 每天可获取2000次
	 * 服务器返回的 access_token 过期时间，一般2小时
	 *
	 * @param bool $force 强制获取
	 *
	 * @return bool
	 */
	public function getAccessToken( $force = false ) {
		//缓存名
		$cacheName = md5( self::$config['appid'] . self::$config['appsecret'] );
		//缓存文件
		$file = __DIR__ . '/cache/' . $cacheName . '.php';
		if ( $force === false && is_file( $file ) && filemtime( $file ) + 7000 > time() ) {
			//缓存有效
			$data = include $file;
		} else {
			$url  = $this->apiUrl . '/cgi-bin/token?grant_type=client_credential&appid=' . self::$config['appid'] . '&secret=' . self::$config['appsecret'];
			$data = $this->curl( $url );
			$data = json_decode( $data, true );
			//获取失败
			if ( isset( $data['errcode'] ) ) {
				return false;
			}
			//缓存access_token
			$dir = dirname( $file );
			is_dir( $dir ) || mkdir( $dir, 0755, true );
			file_put_contents( $file, '<?php return ' . var_export( $data, true ) . ';?>' );
		}

		//获取access_token成功
		return $this->access_token = $data['access_token'];
	}

	/**
	 * 发送请求,第二个参数有值时为Post请求
	 *
	 * @param string $url 请求地址
	 * @param array $fields 发送的post表单
	 *
	 * @return string
	 */
	public function curl( $url, $fields = [ ] ) {
		$ch = curl_init();
		//设置我们请求的地址
		curl_setopt( $ch, CURLOPT_URL, $url );
		//数据返回后不要直接显示
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		//禁止证书校验
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		if ( $fields ) {
			curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
		}
		$data = '';
		if ( curl_exec( $ch ) ) {
			//发送成功,获取数据
			$data = curl_multi_getcontent( $ch );
		}
		curl_close( $ch );

		return $data;

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
		$string = $string . "&key=" . self::$config['key'];
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
		$class = '\wechat\build\\' . ucfirst( $type );

		return new $class( self::$config );
	}

}