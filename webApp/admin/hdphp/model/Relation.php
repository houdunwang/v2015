<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\model;

trait Relation {

	/**
	 * 一对一关联
	 *
	 * @param  [type]  $class      [description]
	 * @param  [type]  $relationId [description]
	 * @param  [type]  $primaryKey [description]
	 *
	 * @return boolean             [description]
	 */
	protected function hasOne( $class, $relationId, $primaryKey ) {
		$instance = ( new $class )->where( $relationId, $this->original->$primaryKey )->first();

		return $instance;
	}

	/**
	 * 多表关联hasMany
	 *
	 * @param  [string]  $class      [description]
	 * @param  [string]  $relationId [description]
	 *
	 * @return [object]              [description]
	 */
	protected function hasMany( $class, $rid, $pid = 'id' ) {
		if ( $items = ( new $class )->where( $rid, $this->$pid )->get() ) {
			return $items;
		}
	}

	/**
	 * 副表关联主表
	 *
	 * @param  [string] $class      [description]
	 * @param  [string] $relationId [description]
	 * @param  [string] $primaryKey [description]
	 *
	 * @return [type]             [description]
	 */
	protected function belongsTo( $class, $rid, $pid ) {
		return ( new $class )->where( $pid, $this->$rid )->first();
	}

	/**
	 * 多对多关联
	 *
	 * @param  [string] $class       [关联类]
	 * @param  [string] $middleTabe [中间表]
	 * @param  [string] $relationId  [主表字段]
	 * @param  [string] $primaryKey  [关联表字段]
	 *
	 * @return [object]
	 */
	protected function belongsToMany( $class, $middleTable, $middlePrimaryKey, $middleRelationId ) {
		$pKey   = $this->primaryKey;
		$middle = Db::table( $middleTable )->where( $middlePrimaryKey, $this->$pKey )->lists( $middleRelationId );

		$instance = ( new $class );

		return $instance->whereIn( $instance->primaryKey, array_values( $middle ) )->get();
	}

	/**
	 * 根据关联条件查询
	 *
	 * @param  [type]  $relation [description]
	 *
	 * @return boolean           [description]
	 */
	public function has( $relation ) {
		// $this->
	}

	/**
	 * 预载入
	 *
	 * @param  [type] $param [description]
	 *
	 * @return [type]        [description]
	 */
	public function with( $param ) {
		$this->with[ $param ];
		// return $
	}
}





