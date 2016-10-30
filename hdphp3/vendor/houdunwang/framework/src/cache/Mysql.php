<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cache;

use Exception;

/**
 * Mysql缓存
 * Class Mysql
 * @package hdphp\cache
 */
class Mysql implements InterfaceCache {

	//缓存目录
	protected $obj;

	public function __construct() {
		$this->connect();
	}

	//连接
	public function connect() {
		$this->obj = Db::table( c( 'cache.mysql.table' ) );
	}

	//设置
	public function set( $name, $data, $expire = 0 ) {
		$data = [ 'name' => $name, 'data' => serialize( $data ), 'create_at' => NOW, 'expire' => $expire ];

		return $this->obj->insert( $data ) ? true : false;
	}

	//获取
	public function get( $name ) {
		$data = $this->obj->where( 'name', $name )->first();
		if ( empty( $data ) ) {
			return null;
		} else if ( $data['expire'] > 0 && $data['create_at'] + $data['expire'] < NOW ) {
			//缓存过期
			$this->obj->where( 'name', $name )->delete();

			return null;
		} else {
			return unserialize( $data['data'] );
		}
	}

	//删除
	public function del( $name ) {
		return $this->obj->where( 'name', $name )->delete();
	}

	//删除所有
	public function flush() {
		return Schema::truncate( c( 'cache.mysql.table' ) );
	}
}