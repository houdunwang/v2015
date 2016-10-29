<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\config;

//配置项处理
class Config {
	//配置集合
	protected $items = [ ];

	/**
	 * 添加配置
	 *
	 * @param $key
	 * @param $name
	 *
	 * @return bool
	 */
	public function set( $key, $name ) {
		$tmp    = &$this->items;
		$config = explode( '.', $key );
		foreach ( (array) $config as $d ) {
			if ( ! isset( $tmp[ $d ] ) ) {
				$tmp[ $d ] = [ ];
			}
			$tmp = &$tmp[ $d ];
		}

		$tmp = $name;

		return true;
	}

	/**
	 * 获取配置
	 *
	 * @param $key
	 *
	 * @return array|void|null
	 */
	public function get( $key ) {
		$tmp    = $this->items;
		$config = explode( '.', $key );
		foreach ( (array) $config as $d ) {
			if ( isset( $tmp[ $d ] ) ) {
				$tmp = $tmp[ $d ];
			} else {
				return null;
			}
		}

		return $tmp;
	}

	/**
	 * 排队字段获取数据
	 *
	 * @param string $key 获取键名
	 * @param array $extName 排除的字段
	 *
	 * @return array
	 */
	public function getExtName( $key, array $extName ) {
		$config = $this->get( $key );
		$data   = [ ];
		foreach ( (array) $config as $k => $v ) {
			if ( ! in_array( $k, $extName ) ) {
				$data[ $k ] = $v;
			}
		}

		return $data;
	}

	/**
	 * 检测配置是否存在
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function has( $key ) {
		$tmp    = $this->items;
		$config = explode( '.', $key );
		foreach ( (array) $config as $d ) {
			if ( isset( $tmp[ $d ] ) ) {
				$tmp = $tmp[ $d ];
			} else {
				return false;
			}
		}

		return true;
	}

	/**
	 * 获取所有配置项
	 * @return array
	 */
	public function all() {
		return $this->items;
	}

	/**
	 * 设置items也就是一次更改全部配置
	 *
	 * @param $items
	 *
	 * @return mixed
	 */
	public function setItems( $items ) {
		return $this->items = $items;
	}
}