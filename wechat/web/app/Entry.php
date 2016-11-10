<?php namespace app;
//业务代码,为了测试微信SDK功能
use wechat\Wx;

class Entry {
	protected $wx;

	public function __construct() {
		$config   = [
			'token' => 'houdunren'
		];
		$this->wx = new Wx( $config );
		$this->wx->valid();
	}

	public function handler() {
		$message = $this->wx->getMessage();
		$this->wx->instance('message')->text('我收到了你的消息:'.$message->Content);
	}
}