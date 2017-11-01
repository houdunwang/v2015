<?php

namespace app\common\model;

use think\Model;

class Group extends Model
{
	//操作数据表
	protected $table = 'blog_auth_group';
	//主键
	protected $pk = 'id';

	/**
	 * 执行数据添加
	 * @param $data  post提交数据
	 *
	 * @return array
	 */
	public function store ( $data )
	{
		$data[ 'rules' ] = isset( $data[ 'rules' ] ) ? implode ( ',' , $data[ 'rules' ] ) : '';
		$res             = $this->validate ( true )->save ( $data );
		if ( $res === false ) {
			return [ 'valid' => 0 , 'msg' => $this->getError () ];
		} else {
			return [ 'valid' => 1 , 'msg' => '操作成功' ];
		}
	}

	/**
	 * 执行数据编辑
	 * @param $data		post提交的全部数据
	 *
	 * @return array
	 */
	public function edit($data){
		$data[ 'rules' ] = isset( $data[ 'rules' ] ) ? implode ( ',' , $data[ 'rules' ] ) : '';
		$res             = $this->validate ( true )->save ( $data ,[$this->pk=>$data['id']]);
		if ( $res === false ) {
			return [ 'valid' => 0 , 'msg' => $this->getError () ];
		} else {
			return [ 'valid' => 1 , 'msg' => '操作成功' ];
		}
	}
}
