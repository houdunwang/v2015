<?php

namespace app\admin\controller;

use app\common\model\Groupaccess;
use houdunwang\crypt\Crypt;
use think\Controller;
use app\common\model\Admin as AdminModel;

/**
 * 用户管理控制器
 * Class Admin
 *
 * @package app\admin\controller
 */
class Admin extends Common
{

	/**
	 * 用户管理首页
	 *
	 * @return \think\response\View
	 */
	public function index ()
	{
		$field = AdminModel::order ( 'admin_id desc' )->paginate ( 20 );

		return view ( '' , compact ( 'field' ) );
	}

	/**
	 * 添加用户
	 *
	 * @param AdminModel $admin
	 *
	 * @return \think\response\View
	 */
	public function store ( AdminModel $admin )
	{
		//请求判断
		if ( request ()->isPost () ) {
			$res = $admin->store ( input ( 'post.' ) );
			if ( $res[ 'valid' ] ) {
				$this->success ( $res[ 'msg' ] , 'index' );
			} else {
				$this->error ( $res[ 'msg' ] );
			}
		}

		return view ();
	}

	/**
	 * 编辑用户
	 *
	 * @param AdminModel $admin
	 *
	 * @return \think\response\View
	 */
	public function edit ( AdminModel $admin )
	{
		//请求判断
		if ( request ()->isPost () ) {
			$res = $admin->edit ( input ( 'post.' ) );
			if ( $res[ 'valid' ] ) {
				$this->success ( $res[ 'msg' ] , 'index' );
			} else {
				$this->error ( $res[ 'msg' ] );
			}
		}
		$admin_id = input ( 'param.admin_id' );
		//获取当前编辑的用户数据
		$userInfo = AdminModel::find ( $admin_id );
		//使用解密方法进行密码的解密功能
		$userInfo[ 'admin_password' ] = Crypt::decrypt ( $userInfo[ 'admin_password' ] );

		return view ( '' , compact ( 'userInfo' ) );
	}

	/**
	 * 删除用户
	 */
	public function del ()
	{
		$admin_id = input ( 'param.admin_id' );
		//执行删除操作
		AdminModel::destroy ( $admin_id );

		return $this->success ( '操作成功' , 'index' );
	}

	/**
	 * 给用户设置权限
	 */
	public function setAuth ( Groupaccess $groupaccess )
	{
		if ( request ()->isPost () ) {
			$res = $groupaccess->setAuth ( input ( 'post.' ) );
			if ( $res[ 'valid' ] ) {
				return $this->success ( $res[ 'msg' ] , 'index' );
			} else {
				return $this->error ( $res[ 'msg' ] );
			}
		}
		//接受后台管理员的id
		$admin_id = input ( 'param.admin_id' );
		//获取当前管理员信息
		$adminInfo = AdminModel::find ( $admin_id );
		//获取所有的用组
		$groupData = \app\common\model\Group::select ();
		//获取当前用户已经有的组id
		$accessData = db('auth_group_access')->where('uid',$admin_id)->column('group_id');
		return view ( '' , compact ( 'groupData' , 'adminInfo' ,'accessData') );

	}
}










