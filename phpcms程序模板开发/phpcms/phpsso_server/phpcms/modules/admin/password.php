<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class password extends admin {
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('admin_model');
		parent::__construct();
	}
	
	public function init() {
		if (isset($_POST['dosubmit'])) {
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('the_password_cannot_be_empty'), HTTP_REFERER);
			$newpassword = isset($_POST['newpassword']) && trim($_POST['newpassword']) ? trim($_POST['newpassword']) : showmessage(L('new_password_cannot_be_empty'), HTTP_REFERER);
			$newpassword2 = isset($_POST['newpassword2']) && trim($_POST['newpassword2']) ? trim($_POST['newpassword2']) : '';
			if (strlen($newpassword) > 20 || strlen($newpassword) < 6) {
				 showmessage(L('password_len_error'), HTTP_REFERER);
			} elseif ($newpassword != $newpassword2) {
				 showmessage(L('the_two_passwords_are_not_the_same_admin_zh'), HTTP_REFERER);
			}
			$info = $this->get_userinfo();
			if (md5(md5($password).$info['encrypt']) != $info['password']) {
				 showmessage(L('old_password_incorrect'), HTTP_REFERER);
			}
			list($password, $encrypt) = creat_password($newpassword);
			if ($this->db->update(array('password'=>$password, 'encrypt'=>$encrypt), array('id'=>$this->get_userid()))) {
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		}
		include $this->admin_tpl('password');
	}
}