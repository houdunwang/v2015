<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\hook;

class Hook {
	//钓子
	private $hook = [ ];

	/**
	 * 添加钓子事件
	 *
	 * @param $hook
	 * @param $action
	 */
	public function add( $hook, $action ) {
		if ( ! isset( $this->hook[ $hook ] ) ) {
			$this->hook[ $hook ] = [ ];
		}

		if ( is_array( $action ) ) {
			$this->hook[ $hook ] = array_merge( $this->hook[ $hook ], $action );
		} else {
			$this->hook[ $hook ][] = $action;
		}
	}

	/**
	 * 获得钓子信息
	 *
	 * @param string $hook 钩子名称
	 *
	 * @return array
	 */
	public function get( $hook = '' ) {
		if ( empty( $hook ) ) {
			return $this->hook;
		} else {
			return $this->hook[ $hook ];
		}
	}

	/**
	 * 批量导入钓子
	 *
	 * @param $data
	 */
	public function import( $data ) {
		$this->hook = array_merge( $this->hook, $data );
	}

	/**
	 * 监听钓子
	 *
	 * @param $hook 钩子名称
	 * @param null $param 参数
	 *
	 * @return bool
	 */
	public function listen( $hook, $param = NULL ) {
		if ( ! isset( $this->hook[ $hook ] ) ) {
			return FALSE;
		}
		foreach ( $this->hook[ $hook ] as $name ) {
			if ( FALSE === $this->exe( $name, $hook, $param ) ) {
				return FALSE;
			}
		}

		return $param ?: TRUE;
	}

	/**
	 * 执行钓子
	 *
	 * @param $name 钓子名
	 * @param string $action 钓子方法
	 * @param null $param 参数
	 *
	 * @return bool|null
	 */
	public function exe( $name, $action, $param = NULL ) {
		if ( class_exists( $name ) ) {
			$obj = new $name;
			if ( method_exists( $obj, $action ) ) {
				$obj->$action( $param );
			}
		}

		return $param;
	}
}