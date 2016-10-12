<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\validate;

class VaAction {

	/**
	 * 字段不存在时验证失败
	 *
	 * @param $field 变量名
	 * @param $value 变量值
	 * @param $params 参数
	 * @param $data 所有字段数据
	 *
	 * @return bool
	 */
	public function required( $field, $value, $params, $data ) {
		return empty( $value ) ? FALSE : TRUE;
	}

	//验证码验证
	public function captcha( $field, $value, $params, $data ) {
		$post = Request::post();

		return isset( $post[ $field ] ) && strtoupper( $post[ $field ] ) == \Code::get();
	}

	//存在字段时验证失败
	public function exists( $field, $value, $params, $data ) {
		return isset( $data[ $field ] ) ? FALSE : TRUE;
	}

	//自动验证字段值唯一
	public function unique( $field, $value, $params, $data ) {
		$args = explode( ',', $params );
		$db   = Db::table( $args[0] )->where( $field, $value );
		if ( isset( $data[ $args[1] ] ) ) {
			$db->where( $args[1], '<>', $data[ $args[1] ] );
		}

		return empty( $value ) || ! $db->pluck( $field ) ? TRUE : FALSE;
	}

	//邮箱验证
	public function email( $name, $value, $params ) {
		$preg = "/^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//验证用户名长度
	public function user( $field, $value, $params, $data ) {
		$params = explode( ',', $params );

		return preg_match( '/^[\x{4e00}-\x{9fa5}a-z0-9]{' . ( $params[0] - 1 ) . ',' . ( $params[1] - 1 ) . '}$/ui', $value ) ? TRUE : FALSE;
	}

	//邮编验证
	public function zipCode( $name, $value, $params ) {
		$preg = "/^\d{6}$/i";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//最大长度验证
	public function maxlen( $name, $value, $params ) {
		if ( mb_strlen( $value, 'utf-8' ) <= $params ) {
			return TRUE;
		}
	}

	//最小长度验证
	public function minlen( $name, $value, $params ) {
		if ( mb_strlen( $value, 'utf-8' ) >= $params ) {
			return TRUE;
		}
	}

	//网址验证
	public function http( $name, $value, $params ) {
		$preg
			= "/^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//固定电话
	public function tel( $name, $value, $params ) {
		$preg = "/(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//手机号验证
	public function phone( $name, $value, $params ) {
		$preg = "/^\d{11}$/";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//身份证验证
	public function identity( $name, $value, $params ) {
		$preg = "/^(\d{15}|\d{18})$/";
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//用户名验证
	public function range( $name, $value, $params ) {
		//用户名长度
		$len    = mb_strlen( $value, 'utf-8' );
		$params = explode( ',', $params );
		if ( $len >= $params[0] && $len <= $params[1] ) {
			return TRUE;
		}
	}

	//数字范围
	public function num( $name, $value, $params ) {
		$params = explode( ',', $params );
		if ( intval($value) >= $params[0] && intval($value) <= $params[1] ) {
			return TRUE;
		}
	}

	//正则验证
	public function regexp( $name, $value, $preg ) {
		if ( preg_match( $preg, $value ) ) {
			return TRUE;
		}
	}

	//两个表单比对
	public function confirm( $name, $value, $params, $data ) {
		if ( $value == $data[ $params ] ) {
			return TRUE;
		}
	}

	//中文验证
	public function china( $name, $value, $params ) {
		if ( preg_match( '/^[\x{4e00}-\x{9fa5}a-z0-9]+$/ui', $value ) ) {
			return TRUE;
		}
	}
}