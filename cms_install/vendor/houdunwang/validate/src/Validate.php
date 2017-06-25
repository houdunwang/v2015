<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\validate;

use houdunwang\validate\build\Base;

/**
 * 表单验证
 * Class Validate
 * @package hdphp\validate
 */
class Validate {
	//有字段时验证
	const EXISTS_VALIDATE = 1;
	//值不为空时验证
	const VALUE_VALIDATE = 2;
	//必须验证
	const MUST_VALIDATE = 3;
	//值是空时处理
	const VALUE_NULL = 4;
	//不存在字段时处理
	const NO_EXISTS_VALIDATE = 5;
	//驱动连接
	protected $link;

	//获取实例
	protected function driver() {
		$this->link = new Base( $this );

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	public static function single() {
		static $link;
		if ( is_null( $link ) ) {
			$link = new static();
		}

		return $link;
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ static::single(), $name ], $arguments );
	}
}