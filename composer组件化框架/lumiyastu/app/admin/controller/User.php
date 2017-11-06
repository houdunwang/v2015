<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;

class User extends Common {
	public function changePassword(){
		if($_POST){
			//1.先判断新密码不得少于6位
			if(strlen(trim($_POST['new_password'])) < 6){
				$this->message('新密码不得少于6位',"?s=admin/user/changePassword");
			}
			//2.两次密码是否一致
			if($_POST['new_password'] != $_POST['confirm_password']){
				$this->message('两次密码不一致',"?s=admin/user/changePassword");
			}
			//3.旧密码是否正确
			$data = \system\model\User::query("SELECT * FROM user WHERE uid=" . $_SESSION['user']['uid']);
			$data = current($data);
			if($data['password'] != md5($_POST['password'])){
				$this->message('原始密码错误',"?s=admin/user/changePassword");
			}
			//4.修改
			\system\model\User::exec("UPDATE user SET password=md5('{$_POST['new_password']}') WHERE uid={$_SESSION['user']['uid']}");
			//5.重新去登陆
			session_unset();
			session_destroy();
			$this->message('修改成功，请重新登录',"?s=admin/login/index");

		}
		View::make();
	}

}