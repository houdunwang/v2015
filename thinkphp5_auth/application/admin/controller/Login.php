<?php

namespace app\admin\controller;

use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;

class Login extends Controller
{
    public function login()
	{
		//echo Crypt::encrypt('admin888');//加密 h3vPU8JGuF3VS/uxIpjRSw==
		//echo Crypt::decrypt('h3vPU8JGuF3VS/uxIpjRSw==');//测试解密  admin888
		//测试数据库连接
		//$data = db('admin')->find(1);
		//dump($data);
		if(request()->isPost()){
			$res = (new Admin())->login(input('post.'));
			if($res['valid'])
			{
				//说明登录成功
				$this->success($res['msg'],'admin/entry/index');exit;
			}else{
				//说明登录失败
				$this->error($res['msg']);exit;
			}
		}
		//加载我们登录页面
		return $this->fetch('index');
	}
}
