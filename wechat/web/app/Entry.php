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
		$content = $this->wx->getMessage();
	}
}