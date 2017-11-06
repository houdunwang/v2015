<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use Gregwar\Captcha\CaptchaBuilder;
use system\model\User;

class Login extends Controller{
	public function index(){
		if($_POST){
			if(trim($_POST['captcha']) == ''){
				$this->message('验证码不能为空','?s=admin/login/index');

			}
			//先判断验证码是否正确
			if(strtolower($_POST['captcha']) != $_SESSION['captcha']){
				$this->message('验证码不正确','?s=admin/login/index');
			}
			//用户名或者密码不能为空
			if(trim($_POST['username']) == '' || trim($_POST['password']) == ''){
				$this->message('用户名或者密码不能为空','?s=admin/login/index');
			}
			$user = User::query("SELECT * FROM user WHERE username='{$_POST['username']}'");
			if(!$user || $user[0]['password'] != md5($_POST['password'])){
				$this->message('用户名或者密码错误','?s=admin/login/index');
			}
			$_SESSION['user'] = [
				'username' => $_POST['username'],
				'uid' => $user[0]['uid']
			];

			$this->message('登陆成功!','?s=admin/entry/index');


		}
		View::make();
	}

	public function captcha(){
		$builder = new CaptchaBuilder;
		$builder->build();
		header('Content-type: image/jpeg');
		$builder->output();
		$_SESSION['captcha'] = strtolower($builder->getPhrase());
	}


	public function logout(){
		session_unset();
		session_destroy();
		$this->message('退出成功',"?s=admin/login/index");
	}
}