<?php namespace houdunwang\model\build;
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

trait SoftDeletes {
	/**
	 * 软删除
	 */
	public function delete() {
		array_walk( $this->dates, function ( $value, $key ) {
			$this->$value = time();
		} );

		return $this->save();
	}

	/**
	 * 恢复软删除
	 */
	public function restore() {
		array_walk( $this->dates, function ( $value, $key ) {
			$this->$value = 0;
		} );

		return $this->save();
	}

	/**
	 * 真正删除数据
	 */
	public function forceDelete() {
		return parent::delete();
	}
}