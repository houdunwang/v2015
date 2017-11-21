<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class administrator extends admin{
	
	private $db;
	
	public function __construct() {
		$this->db = pc_base::load_model('admin_model');
		parent::__construct(1);
	}
	
	public function init() {
		$total = $this->db->count();
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = 20;
		$offset = ($page - 1) * $pagesize;
		$list = $this->db->select('', '*', $offset.','.$pagesize);
		pc_base::load_sys_class('format', '', 0);
		foreach ($list as $key=> $v) {
			$list[$key]['lastlogin'] = format::date($v['lastlogin'], 1);
		}
		$pages = pages($total, $page, $pagesize);
		include $this->admin_tpl('administrator_list');
	}
	
	public function add() {
		if (isset($_POST['dosubmit'])) {
			if($this->check_admin_manage_code()==false){
				showmessage("error auth code");
			}
			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('nameerror'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_can_not_be_empty'), HTTP_REFERER);
			$issuper = isset($_POST['issuper']) && intval($_POST['issuper']) ? intval($_POST['issuper']) : 0;
			if ($this->db->get_one(array('username'=>$username))) {
				showmessage(L('user_already_exist'), HTTP_REFERER);
			} else {
				if (strlen($username) > 20 || strlen($username) < 6) {
					showmessage(L('username').L('between_6_to_20'), HTTP_REFERER);
				}
				if (strlen($password) > 20 || strlen($password) < 6) {
					showmessage(L('password_len_error'), HTTP_REFERER);
				}
				list($password, $encrypt) = creat_password($password);
				if ($this->db->insert(array('username'=>$username, 'password'=>$password, 'encrypt'=>$encrypt, 'issuper'=>$issuper))) {
					showmessage(L('add_admin').L('operation_success'), 'm=admin&c=administrator&a=init');
				} else {
					showmessage(L('database_error'), HTTP_REFERER);
				}
			}
		}
		$admin_manage_code = $this->get_admin_manage_code();
		include $this->admin_tpl('administrator_add');
	}
	
	public function del() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$r = $this->db->get_one(array('id'=>$id));
		if ($r) {
			if ($r['issuper']) {
				$super_num = $this->db->count(array('issuper'=>1));
				if ($super_num <=1) {
					showmessage(L('least_there_is_a_super_administrator'), HTTP_REFERER);
				}
			}
			if ($this->db->delete(array('id'=>$id))) {
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}		
		} else {
			showmessage(L('User_name_could_not_find'), HTTP_REFERER);
		}
	}
	
	public function edit() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$data = $this->db->get_one(array('id'=>$id));
		if ($data) {
			if (isset($_POST['dosubmit'])) {
				if($this->check_admin_manage_code()==false){
					showmessage("error auth code");
				}
				$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : '';
				$issuper = isset($_POST['issuper']) && intval($_POST['issuper']) ? intval($_POST['issuper']) : 0;
				$update = array('issuper'=>$issuper);
				if ($password) {
					if (strlen($password) > 20 || strlen($password) < 6) {
					showmessage(L('password_len_error'), HTTP_REFERER);
					}
					list($password, $encrypt) = creat_password($password);
					$update['password'] = $password;
					$update['encrypt'] = $encrypt;
				}
				if ($this->db->update($update, array('id'=>$id))) {
					showmessage(L('operation_success'), 'm=admin&c=administrator&a=init');
				} else {
					showmessage(L('database_error'), HTTP_REFERER);
				}
			}
			$admin_manage_code = $this->get_admin_manage_code();
			include $this->admin_tpl('administrator_edit');
		} else {
			showmessage(L('User_name_could_not_find'), HTTP_REFERER);
		}
	}
	
	public function ajax_username() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if ($this->db->get_one(array('username'=>$username))) {
			echo 0;exit();
		} else {
			echo 1;exit();
		}
	}
	//添加修改用户 验证串验证
	private function check_admin_manage_code(){
		$admin_manage_code = $_POST['admin_manage_code'];
		$pc_auth_key = md5(pc_base::load_config('system','auth_key').'adminuser');
		$admin_manage_code = sys_auth($admin_manage_code, 'DECODE', $pc_auth_key);	
		if($admin_manage_code==""){
			return false;
		}
		$admin_manage_code = explode("_", $admin_manage_code);
		if($admin_manage_code[0]!="adminuser" || $admin_manage_code[1]!=$_POST[pc_hash]){
			return false;
		}
		return true;
	}
	//添加修改用户 生成验证串
	private function get_admin_manage_code(){
		$pc_auth_key = md5(pc_base::load_config('system','auth_key').'adminuser');
		$code = sys_auth("adminuser_".$_GET[pc_hash]."_".time(), 'ENCODE', $pc_auth_key);
		return $code;
	}
}