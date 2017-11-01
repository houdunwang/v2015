<?php

namespace app\common\model;

use houdunwang\arr\Arr;
use think\Model;

class Rules extends Model
{
	//指定操作数据表
	protected $table = 'blog_auth_rule';
	//指定主键
	protected $pk = 'id';

	/**
	 * 执行添加
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function store ( $data )
	{
		$res = $this->validate ( true )->save ( $data );
		if ( $res === false ) {
			return [ 'valid' => 0 , 'msg' => $this->getError () ];
		} else {
			return [ 'valid' => 1 , 'msg' => '操作成功' ];
		}
	}

	/**
	 * 执行获取除了自己和自己子集的数据
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getSonData ( $id )
	{
		//1.找子集
		$data = db ( 'auth_rule' )->select ();
		$ids  = $this->getSon ( $data , $id );
		//2.将自己追加进去
		$ids[] = $id;
		//3.将这些数据排除在外
		$field = db ( 'auth_rule' )->whereNotIn ( 'id' , $ids )->select ();

		//4.转为树状结构
		return Arr::tree ( $field , 'title' , 'id' , 'pid' );
	}

	/**
	 * 查找子集
	 *
	 * @param $data
	 * @param $id
	 *
	 * @return array
	 */
	public function getSon ( $data , $id )
	{
		static $temp = [];
		foreach ( $data as $k => $v ) {
			if ( $v[ 'pid' ] == $id ) {
				$temp[] = $v[ 'id' ];
				$this->getSon ( $data , $v[ 'id' ] );
			}
		}

		return $temp;
	}

	/**
	 * 编辑数据
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function edit ( $data )
	{
		$res = $this->validate ( true )->save ( $data , [ $this->pk => $data[ 'id' ] ] );
		if ( $res === false ) {
			return [ 'valid' => 0 , 'msg' => $this->getError () ];
		} else {
			return [ 'valid' => 1 , 'msg' => '操作成功' ];
		}

	}
}
