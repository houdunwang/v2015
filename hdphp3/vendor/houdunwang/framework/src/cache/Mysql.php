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
/**
 * Mysql缓存
 * Class Mysql
 * @package hdphp\cache
 */
class Mysql implements InterfaceCache {
	use Base;
	//缓存目录
	protected $link;

	//连接
	public function connect() {
		$this->link = Db::table( c( 'cache.mysql.table' ) );
	}

	//设置
	public function set( $name, $data, $expire = 0 ) {
		$data = [ 'name' => $name, 'data' => serialize( $data ), 'create_at' => NOW, 'expire' => $expire ];
		if ( ! $this->link->where( 'name', $name )->get() ) {
			return $this->link->insert( $data ) ? true : false;
		}
	}

	//获取
	public function get( $name ) {
		$data = $this->link->where( 'name', $name )->first();
		if ( $data['expire'] > 0 && $data['create_at'] + $data['expire'] < NOW ) {
			//缓存过期
			$this->link->where( 'name', $name )->delete();
		} else {
			return unserialize( $data['data'] );
		}
	}

	//删除
	public function del( $name ) {
		return $this->link->where( 'name', $name )->delete();
	}

	//删除所有
	public function flush() {
		return Schema::truncate( c( 'cache.mysql.table' ) );
	}
}