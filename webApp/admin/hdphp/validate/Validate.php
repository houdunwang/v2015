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

use Closure;

/**
 * 表单验证
 * Class Validate
 * @package hdphp\validate
 * @author 向军
 */
class Validate extends VaAction {
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

	//扩展验证规则
	private $validate = [ ];

	//错误信息
	protected $error;

	/**
	 * 表单难
	 *
	 * @param $validates 验证规则
	 * @param array $data 数据
	 *
	 * @return $this
	 */
	public function make( $validates, array $data = [ ] ) {
		$_SESSION['_validate'] = $this->error = '';
		$data                  = $data ? $data : $_POST;

		foreach ( $validates as $validate ) {
			//验证条件
			$validate[3] = isset( $validate[3] ) ? $validate[3] : self::MUST_VALIDATE;

			if ( $validate[3] == self::EXISTS_VALIDATE && ! isset( $data[ $validate[0] ] ) ) {
				continue;
			} else if ( $validate[3] == self::VALUE_VALIDATE && empty( $data[ $validate[0] ] ) ) {
				//不为空时处理
				continue;
			} else if ( $validate[3] == self::VALUE_NULL && ! empty( $data[ $validate[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $validate[3] == self::NO_EXISTS_VALIDATE && isset( $data[ $validate[0] ] ) ) {
				//值为空时处理
				continue;
			} else if ( $validate[3] == self::MUST_VALIDATE ) {
				//必须处理
			}
			//表单值
			$value = isset( $data[ $validate[0] ] ) ? $data[ $validate[0] ] : '';

			//验证规则
			if ( $validate[1] instanceof Closure ) {
				$method = $validate[1];
				//闭包函数
				if ( $method( $value ) !== TRUE ) {
					$_SESSION['_validate'] = $this->error = $validate[2];

					return $this;
				}
			} else {
				$actions = explode( '|', $validate[1] );
				foreach ( $actions as $action ) {
					$info   = explode( ':', $action );
					$method = $info[0];
					$params = isset( $info[1] ) ? $info[1] : '';
					if ( method_exists( $this, $method ) ) {
						//类方法验证
						if ( $this->$method( $validate[0], $value, $params, [ ] ) !== TRUE ) {
							$_SESSION['_validate'] = $this->error = $validate[2];

							return $this;
						}
					} else if ( isset( $this->validate[ $method ] ) ) {
						$callback = $this->$validate[ $method ];
						if ( $callback instanceof Closure ) {
							//闭包函数
							if ( $callback( $validate[0], $value, $params, [ ] ) !== TRUE ) {
								$_SESSION['_validate'] = $this->error = $validate[2];

								return $this;
							}
						}
					}
				}
			}
		}

		return $this;
	}

	//添加验证闭包
	public function extend( $name, $callback ) {
		if ( $callback instanceof Closure ) {
			$this->validate[ $name ] = $callback;
		}
	}

	//验证失败检测
	public function fail() {
		return ! empty( $this->error );
	}

	//获取错误信息
	public function getError() {
		return $this->error;
	}

}