<?php

namespace app\admin\controller;

use think\auth\Auth;
use think\Controller;
use think\Request;

class Common extends Controller
{
    public function __construct ( Request $request = null )
	{
		parent::__construct( $request );
		//执行登录验证
		//$_SESSION['admin']['admin_id'];
		if(!session('admin.admin_id'))
		{
			$this->redirect('admin/login/login');
		}
		//权限验证
		//添加规则
		$rule = request ()->module () . '/' . request()->controller () . '/' . request()->action ();
		//执行Auth类中check方法进行验证
		$res = (new Auth())->check ($rule,session('admin.admin_id'));
		//做出判断，没有权限的给出提示信息
		if(!$res){
			return $this->error('没有操作权限');
		}
	}
}
