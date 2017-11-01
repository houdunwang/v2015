<?php

namespace app\admin\controller;

use houdunwang\arr\Arr;
use think\Controller;
use app\common\model\Rules as RulesModel;

/**
 * 权限之规则管理控制器类
 * Class Rules
 *
 * @package app\admin\controller
 */
class Rules extends Common
{
	/**
	 * 规则管理首页
	 *
	 * @return \think\response\View
	 */
	public function index ()
	{
		$field = db ( 'auth_rule' )->select ();
		$field = Arr::tree ( $field , 'title' , 'id' , 'pid' );

		return view ( '' , compact ( 'field' ) );
	}

	/**
	 * 规则添加
	 *
	 * @param RulesModel $rules
	 *
	 * @return \think\response\View|void
	 */
	public function store ( RulesModel $rules )
	{
		if ( request ()->isPost () ) {
			$res = $rules->store ( input ( 'post.' ) );
			if ( $res[ 'valid' ] ) {
				return $this->success ( $res[ 'msg' ] , 'index' );
			} else {
				return $this->error ( $res[ 'msg' ] );
			}
		}
		//获取所有规则数据
		$field = db ( 'auth_rule' )->select ();
		$field = Arr::tree ( $field , 'title' , 'id' , 'pid' );

		return view ( '' , compact ( 'field' ) );
	}

	/**
	 * 编辑规则
	 *
	 * @param RulesModel $rules
	 *
	 * @return \think\response\View|void
	 */
	public function edit ( RulesModel $rules )
	{
		if ( request ()->isPost () ) {
			$res = $rules->edit ( input ( 'post.' ) );
			if ( $res[ 'valid' ] ) {
				return $this->success ( $res[ 'msg' ] , 'index' );
			} else {
				return $this->error ( $res[ 'msg' ] );
			}
		}
		//接受id
		$id = input ( 'param.id' );
		//处理数据，不包含自己和自己的子集
		$field = $rules->getSonData ( $id );
		//获取编辑旧数据
		$oldData = RulesModel::find ( $id );

		//halt($oldData->toArray());
		return view ( '' , compact ( 'field' , 'oldData' ) );
	}

	/**
	 * 删除规则
	 */
	public function del ()
	{
		$id = input ( 'param.id' );
		//如果有子集，不允许进行删除

		if ( $res = RulesModel::where ( 'pid' , $id )->find () ) {
			return $this->error ( '请先删除子集数据' );
		}
		//执行删除
		$res = RulesModel::destroy ( $id );
		if ( $res ) {
			return $this->success ( '操作成功' , 'index' );
		} else {
			return $this->error ( '操作失败' );
		}
	}
}
