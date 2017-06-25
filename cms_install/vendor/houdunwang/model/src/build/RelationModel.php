<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\model\build;

define( "HAS_ONE", "HAS_ONE" );
define( "HAS_MANY", "HAS_MANY" );
define( "BELONGS_TO", "BELONGS_TO" );
define( "MANY_TO_MANY", "MANY_TO_MANY" );

class RelationModel extends Model {
	/**
	 * 关联模型定义
	 * @var array
	 */
	public $relation = [ ];

	public function find( $id ) {
		if ( $instance = parent::find( $id ) ) {
			$data = $this->relationSelect( [ $instance ] );

			return current( $data );
		} else {
			return $instance;
		}
	}

	public function all() {
		if ( $instance = parent::all() ) {
			$data = $this->relationSelect( $instance );

			return $data;
		} else {
			return $instance;
		}
	}

	/**
	 * 关联查询
	 *
	 * @param  [type] $instance [description]
	 *
	 * @return [type]           [description]
	 */
	private function relationSelect( $instance ) {
		foreach ( $this->relation as $table => $relation ) {
			$foreign_key = $relation['foreign_key'];
			$parent_key  = $relation['parent_key'];
			switch ( $relation['type'] ) {
				case HAS_ONE:
					foreach ( $instance as $key => $ins ) {
						$instance[ $key ][ '_' . $table ] = Db::table( $table )->where( $parent_key, $ins[ $foreign_key ] )->first();
					}
					break;
				case HAS_MANY:
					foreach ( $instance as $key => $ins ) {
						$instance[ $key ][ '_' . $table ] = Db::table( $table )->where( $parent_key, $ins[ $foreign_key ] )->get();
					}
					break;
				case BELONGS_TO:
					foreach ( $instance as $key => $ins ) {
						$instance[ $key ][ '_' . $table ] = Db::table( $table )->where( $foreign_key, $ins[ $parent_key ] )->get();
					}
					break;
				case MANY_TO_MANY:
					foreach ( $instance as $key => $ins ) {
						$rel = Db::table( $relation['relation_table'] )->where( $parent_key, $ins->getPrimaryKey() )->lists( $foreign_key );
						if ( $rel ) {
							$instance[ $key ][ '_' . $table ] = Db::table( $table )->whereIn( $foreign_key, $rel )->get();
						}
					}
					break;
			}
		}

		return $instance;
	}


	public function insert( array $params = [ ] ) {
		if ( $instance = parent::insert( $params ) ) {
			$data = $this->relationInsert( $instance, $params );

			return $data;
		}

		return $instance;
	}

	//关联插入
	private function relationInsert( $instance, $params ) {
		foreach ( $this->relation as $table => $relation ) {
			$foreign_key = $relation['foreign_key'];
			$parent_key  = $relation['parent_key'];
			switch ( $relation['type'] ) {
				case HAS_ONE:
				case HAS_MANY:
					$id                      = Db::table( $table )->insert( $params[ '_' . $table ] );
					$instance[ $parent_key ] = $id;
					$instance->save();
					break;
				case BELONGS_TO:
					$params[ '_' . $table ][ $foreign_key ] = $instance->getPrimaryKey();
					Db::table( $table )->insert( $params[ '_' . $table ] );
					break;
				case MANY_TO_MANY:
					$id                   = Db::table( $table )->insert( $params[ '_' . $table ] );
					$data[ $foreign_key ] = $id;
					$data[ $parent_key ]  = $instance->getPrimaryKey();
					Db::table( $relation['relation_table'] )->insert( $data );
					break;
			}
		}

		return $instance;
	}

	//更新
	public function save( array $data = [ ] ) {
		if ( $state = parent::save( $data ) ) {
			$this->relationSave( $this, $data );
		}

		return $state;
	}

	//关联更新
	private function relationSave( $instance, $data ) {
		foreach ( $this->relation as $table => $relation ) {
			$foreign_key = $relation['foreign_key'];
			$parent_key  = $relation['parent_key'];
			switch ( $relation['type'] ) {
				case HAS_ONE:
				case HAS_MANY:
				case BELONGS_TO:
				case MANY_TO_MANY:
					Db::table( $table )->update( $data[ substr( $table, 1 ) ] );
					break;
			}
		}

		return $instance;
	}

	//删除
	public function delete() {
		if ( $state = parent::delete() ) {
			$this->relationDelete( $instance );
		}

		return $state;
	}

	//关联删除
	private function relationDelete( $instance ) {
		foreach ( $this->relation as $table => $relation ) {
			$foreign_key = $relation['foreign_key'];
			$parent_key  = $relation['parent_key'];

			switch ( $relation['type'] ) {
				case HAS_ONE:
				case HAS_MANY:
					break;
				case BELONGS_TO:
					Db::table( $table )->where( $foreign_key, $instance->getPrimaryKey() )->delete();
					break;
				case MANY_TO_MANY:
					Db::table( $relation[ $relation_table ] )->where( $parent_key, $instance->getPrimaryKey() )->delete();
					break;
			}
		}

		return $instance;
	}
}