<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace hdphp\db;
/**
 * Class Db
 * @package hdphp\db
 */
class Db {

	protected $app;

	public function __construct( $app ) {
		$this->app = $app;
	}

	//获取数据驱动
	public function connect() {
		return new Query();
	}

	/**
	 * @param $method
	 * @param $params
	 *
	 * @return mixed
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this->connect(), $method ], $params );
	}

}