<?php namespace hdphp\cloud;
/**
 * 云接口
 * Class Cloud
 * @package hdphp\cloud
 * @author 向军
 */
class Cloud {
	private   $app;
	protected $url;

	public function __construct( $app ) {
		$this->app = $app;
		$this->url = c( 'api.cloud' );
	}


	/**
	 * 发送短信
	 *
	 * @param $mobile 手机号
	 * @param $content 内容
	 *
	 * @return bool 返回true发送成功,否则返回错误消息内容
	 */
	public function mobile( $mobile, $content ) {
		$data = [ 'mobile' => $mobile, 'content' => $content ];
		$data = http_build_query( $data );
		$res  = Curl::post( $this->url . '?a=cloud/mobile_message&t=web&siteid=1&m=store', $data );

		return Xml::toSimpleArray( $res );
	}

	/**
	 * 测试云帐号连接
	 *
	 * @param string $username 帐号
	 * @param string $password 密码
	 *
	 * @return mixed
	 */
	public function connect( $data ) {
		$res = Curl::post( $this->url . "?a=cloud/connect&t=web&siteid=1&m=store", $data );

		return json_decode( $res, TRUE );
	}

	/**
	 * 获取HDCMS最新版信息
	 * @return mixed
	 */
	public function getHdcmsLatestVersion() {
		$res = Curl::get( $this->url . "?a=cloud/hdcms_latest_version&t=web&siteid=1&m=store" );

		return Xml::toSimpleArray( $res );
	}
}