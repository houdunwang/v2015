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

	public function __construct() {
		foreach ( glob( ROOT_PATH . DS . 'system/config/*' ) as $file ) {
			$info = pathinfo( $file );
			$this->set( $info['filename'], require $file );
		}
		//加载.env配置
		if ( is_file( '.env' ) ) {
			$config = [ ];
			foreach ( file( '.env' ) as $file ) {
				$data                       = explode( '=', $file );
				$config[ trim( $data[0] ) ] = trim( $data[1] );
			}
			$this->set( 'database.read.host', $config['DB_HOST'] );
			$this->set( 'database.read.user', $config['DB_USERNAME'] );
			$this->set( 'database.read.password', $config['DB_PASSWORD'] );
			$this->set( 'database.read.database', $config['DB_DATABASE'] );
			$this->set( 'database.read.prefix', $config['DB_PREFIX'] );
			$this->set( 'database.write.host', $config['DB_HOST'] );
			$this->set( 'database.write.user', $config['DB_USERNAME'] );
			$this->set( 'database.write.password', $config['DB_PASSWORD'] );
			$this->set( 'database.write.database', $config['DB_DATABASE'] );
			$this->set( 'database.write.prefix', $config['DB_PREFIX'] );
		}
	}

	/**
	 * 添加配置
	 *
	 * @param $key
	 * @param $name
	 *
	 * @return bool
	 */
	public function set( $key, $name ) {
		$tmp = &$this->items;
		foreach ( explode( '.', $key ) as $d ) {
			if ( ! isset( $tmp[ $d ] ) ) {
				$tmp[ $d ] = [ ];
			}
			$tmp = &$tmp[ $d ];
		}

		$tmp = $name;

		return TRUE;
	}

	/**
	 * 获取配置
	 *
	 * @param $key
	 *
	 * @return array|void
	 */
	public function get( $key ) {
		$tmp = $this->items;
		foreach ( explode( '.', $key ) as $d ) {
			if ( isset( $tmp[ $d ] ) ) {
				$tmp = $tmp[ $d ];
			} else {
				return;
			}
		}

		return $tmp;
	}

	/**
	 * 排队字段获取数据
	 *
	 * @param $key 获取键名
	 * @param $extName 排除的字段
	 *
	 * @return array
	 */
	public function getExtName( $key, $extName ) {
		$config = $this->get( $key );
		$data   = [ ];
		foreach ( $config as $k => $v ) {
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
		$tmp = $this->items;
		foreach ( explode( '.', $key ) as $d ) {
			if ( isset( $tmp[ $d ] ) ) {
				$tmp = $tmp[ $d ];
			} else {
				return FALSE;
			}
		}

		return TRUE;
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