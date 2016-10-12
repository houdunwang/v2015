<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\auto;

/**
 * 自动完成
 * Class Auto
 * @package hdphp\auto
 * @author 向军
 */
class Auto {
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
	function make( $auto, &$data = NULL ) {
		if ( is_null( $data ) ) {
			$data =& $_POST;
		}
		foreach ( $auto as $name => $auto ) {
			//处理类型
			$auto[2] = isset( $auto[2] ) ? $auto[2] : 'string';

			//验证条件
			$auto[3] = isset( $auto[3] ) ? $auto[3] : self::EXISTS_VALIDATE;

			//有这个字段处理
			if ( $auto[3] == self::EXISTS_VALIDATE && ! isset( $data[ $auto[0] ] ) ) {
				continue;
			} else if ( $auto[3] == self::VALUE_VALIDATE && empty( $data[ $auto[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $auto[3] == self::VALUE_NULL && ! empty( $data[ $auto[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $auto[3] == self::NO_EXISTS_VALIDATE && isset( $data[ $auto[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $auto[3] == self::MUST_VALIDATE ) {
				//必须处理
			}

			//为字段设置默认值
			if ( empty( $bas[ $auto[0] ] ) ) {
				$data[ $auto[0] ] = '';
			}
			if ( $auto[2] == 'method' ) {
				$data[ $auto[0] ] = $this->$auto[1]( $data[ $auto[0] ] );
			} else if ( $auto[2] == 'function' ) {
				$data[ $auto[0] ] = $auto[1]( $data[ $auto[0] ] );
			} else if ( $auto[2] == 'string' ) {
				$data[ $auto[0] ] = $auto[1];
			} else if ( $auto[2] == 'callback' && $auto[1] instanceof Closure ) {
				return $auto[1]( $data[ $auto[0] ] );
			}
		}
	}
}