<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
pc_base::load_app_func('global', 'phpsso');
class login extends admin {
	
	/**
	 * 初始化页面
	 */
	public function init() {
		include $this->admin_tpl('login');
	}
	
	/**
	 * 登陆
	 */
	public function logind() {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');	
		$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('nameerror'), '?m=admin&a=init&c=login');
		$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_can_not_be_empty'), '?m=admin&a=init&c=login');
		$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
		if ($_SESSION['code'] != strtolower($code)) {
			showmessage(L('code_error'), HTTP_REFERER);
		}
		if(!is_username($username)){
			showmessage(L('username_illegal'), HTTP_REFERER);
		}
		if ($this->login($username,$password)) {
			$forward = isset($_POST['forward']) ? urldecode($_POST['forward']) : '';
			showmessage(L('login_succeeded'), '?m=admin&c=index&a=init&forward='.$forward);
		} else {
			showmessage($this->get_err(), '?m=admin&c=login&a=init&forward='.$_POST['forward']);
		}
	}
	
	/**
	 * 退出登录
	 */
	public function logout() {
		$this->log_out();
		$forward = isset($_GET['forward']) ? urlencode($_GET['forward']) : '';
		showmessage(L('logout_succeeded'), '?m=admin&c=login&a=init&forward='.$forward);
	}
}