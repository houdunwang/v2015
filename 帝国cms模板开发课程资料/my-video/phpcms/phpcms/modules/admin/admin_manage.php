<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('admin');
class admin_manage extends admin {
	private $db,$role_db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('admin_model');
		$this->role_db = pc_base::load_model('admin_role_model');
		$this->op = pc_base::load_app_class('admin_op');
	}
	
	/**
	 * 管理员管理列表
	 */
	public function init() {
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$infos = $this->db->listinfo('', '', $page, 20);
		$pages = $this->db->pages;
		$roles = getcache('role','commons');
		include $this->admin_tpl('admin_list');
	}
	
	/**
	 * 添加管理员
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			if($this->check_admin_manage_code()==false){
				showmessage("error auth code");
			}
			$info = array();
			if(!$this->op->checkname($_POST['info']['username'])){
				showmessage(L('admin_already_exists'));
			}
			$info = checkuserinfo($_POST['info']);		
			if(!checkpasswd($info['password'])){
				showmessage(L('pwd_incorrect'));
			}
			$passwordinfo = password($info['password']);
			$info['password'] = $passwordinfo['password'];
			$info['encrypt'] = $passwordinfo['encrypt'];
			
			$admin_fields = array('username', 'email', 'password', 'encrypt','roleid','realname');
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->insert($info);
			if($this->db->insert_id()){
				showmessage(L('operation_success'),'?m=admin&c=admin_manage');
			}
		} else {
			$roles = $this->role_db->select(array('disabled'=>'0'));
			$admin_manage_code = $this->get_admin_manage_code();
			include $this->admin_tpl('admin_add');
		}
		
	}
	
	/**
	 * 修改管理员
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			if($this->check_admin_manage_code()==false){
				showmessage("error auth code");
			}
			$memberinfo = $info = array();			
			$info = checkuserinfo($_POST['info']);
			if(isset($info['password']) && !empty($info['password']))
			{
				$this->op->edit_password($info['userid'], $info['password']);
			}
			$userid = $info['userid'];
			$admin_fields = array('username', 'email', 'roleid','realname');
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->update($info,array('userid'=>$userid));
			showmessage(L('operation_success'),'','','edit');
		} else {					
			$info = $this->db->get_one(array('userid'=>$_GET['userid']));
			extract($info);	
			$roles = $this->role_db->select(array('disabled'=>'0'));	
			$show_header = true;
			$admin_manage_code = $this->get_admin_manage_code();
			include $this->admin_tpl('admin_edit');		
		}
	}
	
	/**
	 * 删除管理员
	 */
	public function delete() {
		$userid = intval($_GET['userid']);
		if($userid == '1') showmessage(L('this_object_not_del'), HTTP_REFERER);
		$this->db->delete(array('userid'=>$userid));
		showmessage(L('admin_cancel_succ'));
	}
	
	/**
	 * 更新管理员状态
	 */
	public function lock(){
		$userid = intval($_GET['userid']);
		$disabled = intval($_GET['disabled']);
		$this->db->update(array('disabled'=>$disabled),array('userid'=>$userid));
		showmessage(L('operation_success'),'?m=admin&c=admin_manage');
	}
	
	/**
	 * 管理员自助修改密码
	 */
	public function public_edit_pwd() {
		$userid = $_SESSION['userid'];
		if(isset($_POST['dosubmit'])) {
			$r = $this->db->get_one(array('userid'=>$userid),'password,encrypt');
			if ( password($_POST['old_password'],$r['encrypt']) !== $r['password'] ) showmessage(L('old_password_wrong'),HTTP_REFERER);
			if(isset($_POST['new_password']) && !empty($_POST['new_password'])) {
				$this->op->edit_password($userid, $_POST['new_password']);
			}
			showmessage(L('password_edit_succ_logout'),'?m=admin&c=index&a=public_logout');			
		} else {
			$info = $this->db->get_one(array('userid'=>$userid));
			extract($info);
			include $this->admin_tpl('admin_edit_pwd');			
		}

	}
	/*
	 * 编辑用户信息
	 */
	public function public_edit_info() {
		$userid = $_SESSION['userid'];
		if(isset($_POST['dosubmit'])) {
			$admin_fields = array('email','realname','lang');
			$info = array();
			$info = $_POST['info'];
			if(trim($info['lang'])=='') $info['lang'] = 'zh-cn';
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->update($info,array('userid'=>$userid));
			param::set_cookie('sys_lang', $info['lang'],SYS_TIME+86400*30);
			showmessage(L('operation_success'),HTTP_REFERER);			
		} else {
			$info = $this->db->get_one(array('userid'=>$userid));
			extract($info);
			
			$lang_dirs = glob(PC_PATH.'languages/*');
			$dir_array = array();
			foreach($lang_dirs as $dirs) {
				$dir_array[] = str_replace(PC_PATH.'languages/','',$dirs);
			}
			include $this->admin_tpl('admin_edit_info');			
		}	
	
	}
	/**
	 * 异步检测用户名
	 */
	function public_checkname_ajx() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if ($this->db->get_one(array('username'=>$username),'userid')){
			exit('0');
		}
		exit('1');
	}
	/**
	 * 异步检测密码
	 */
	function public_password_ajx() {
		$userid = $_SESSION['userid'];
		$r = array();
		$r = $this->db->get_one(array('userid'=>$userid),'password,encrypt');
		if ( password($_GET['old_password'],$r['encrypt']) == $r['password'] ) {
			exit('1');
		}
		exit('0');
	}
	/**
	 * 异步检测emial合法性
	 */
	function public_email_ajx() {
		$email = $_GET['email'];
		$userid = $_SESSION['userid'];
		$check = $this->db->get_one(array('email'=>$email),'userid');
		if ($check && $check['userid']!=$userid){
			exit('0');
		}else{
			exit('1');
		}
 	}

	//电子口令卡
	function card() {
		if (pc_base::load_config('system', 'safe_card') != 1) {
			showmessage(L('your_website_opened_the_card_no_password'));
		}
		$userid = isset($_GET['userid']) && intval($_GET['userid']) ? intval($_GET['userid']) : showmessage(L('user_id_cannot_be_empty'));
		$data = array();
		if ($data = $this->db->get_one(array('userid'=>$userid), '`card`,`username`')) {
			$pic_url = '';
			if ($data['card']) {
				pc_base::load_app_class('card', 'admin', 0);
				$pic_url = card::get_pic($data['card']);
			}
			$show_header = true;
			include $this->admin_tpl('admin_card');
		} else {
			showmessage(L('users_were_not_found'));
		}
	}
	
	//绑定电子口令卡
	function creat_card() {
		if (pc_base::load_config('system', 'safe_card') != 1) {
			showmessage(L('your_website_opened_the_card_no_password'));
		}
		$userid = isset($_GET['userid']) && intval($_GET['userid']) ? intval($_GET['userid']) : showmessage(L('user_id_cannot_be_empty'));
		$data = $card = '';
		if ($data = $this->db->get_one(array('userid'=>$userid), '`card`,`username`')) {
			if (empty($data['card'])) {
				pc_base::load_app_class('card', 'admin', 0);
				$card = card::creat_card();
				if ($this->db->update(array('card'=>$card), array('userid'=>$userid))) {
					showmessage(L('password_card_application_success'), '?m=admin&c=admin_manage&a=card&userid='.$userid);
				} else {
					showmessage(L('a_card_with_a_local_database_please_contact_the_system_administrators'));
				}
			} else {
				showmessage(L('please_lift_the_password_card_binding'),HTTP_REFERER);
			}
		} else {
			showmessage(L('users_were_not_found'));
		}
	}
	
	//解除口令卡绑定
	function remove_card() {
		if (pc_base::load_config('system', 'safe_card') != 1) {
			showmessage(L('your_website_opened_the_card_no_password'));
		}
		$userid = isset($_GET['userid']) && intval($_GET['userid']) ? intval($_GET['userid']) : showmessage(L('user_id_cannot_be_empty'));
		$data = $result = '';
		if ($data = $this->db->get_one(array('userid'=>$userid), '`card`,`username`,`userid`')) {
			pc_base::load_app_class('card', 'admin', 0);
			if ($result = card::remove_card($data['card'])) {
					$this->db->update(array('card'=>''), array('userid'=>$userid));
					showmessage(L('the_binding_success'), '?m=admin&c=admin_manage&a=card&userid='.$userid);
			}
		} else {
			showmessage(L('users_were_not_found'));
		}
	}
	//添加修改用户 验证串验证
	private function check_admin_manage_code(){
		$admin_manage_code = $_POST['info']['admin_manage_code'];
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
?>