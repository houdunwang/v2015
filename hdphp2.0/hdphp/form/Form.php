<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\form;

class Form {
	private $app;

	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * 设置options的selected
	 *
	 * @param $v
	 * @param $e
	 *
	 * @return string
	 */
	public function selected( $v, $e ) {
		return $v == $e ? 'selected' : '';
	}

	/**
	 * 设置 radio 的checked
	 *
	 * @param $v
	 * @param $e
	 *
	 * @return string
	 */
	public function checked( $v, $e ) {
		return $v == $e ? 'checked' : '';
	}
}