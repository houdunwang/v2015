<?php
/**
 * 管理员后台会员审核操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);

class member_verify extends admin {
	
	private $db, $member_db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('member_verify_model');
		$this->_init_phpsso();
	}

	/**
	 * defalut
	 */
	function init() {

		include $this->admin_tpl('member_init');
	}
	
	/**
	 * member list
	 */
	function manage() {
		$status = !empty($_GET['s']) ? $_GET['s'] : 0;
		$where = array('status'=>$status);
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$memberlist = $this->db->listinfo($where, 'regdate DESC', $page, 10);
		$pages = $this->db->pages;
		$member_model = getcache('member_model', 'commons');
		include $this->admin_tpl('member_verify');
	}
	
	function modelinfo() {
		$userid = !empty($_GET['userid']) ? intval($_GET['userid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$modelid = !empty($_GET['modelid']) ? intval($_GET['modelid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		
		$memberinfo = $this->db->get_one(array('userid'=>$userid));
		//模型字段名称
		$this->member_field_db = pc_base::load_model('sitemodel_field_model');
		$model_fieldinfo = $this->member_field_db->select(array('modelid'=>$modelid), "*", 100);
		//用户模型字段信息
		$member_fieldinfo = string2array($memberinfo['modelinfo']);
		
		//交换数组key值
		foreach($model_fieldinfo as $v) {
			if(array_key_exists($v['field'], $member_fieldinfo)) {
				$tmp = $member_fieldinfo[$v['field']];
				unset($member_fieldinfo[$v['field']]);
				$member_fieldinfo[$v['name']] = $tmp;
				unset($tmp);
			}
		}

		include $this->admin_tpl('member_verify_modelinfo');
	}
		
	/**
	 * pass member
	 */
	function pass() {
		if (isset($_POST['userid'])) {
			$this->member_db = pc_base::load_model('member_model');
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$userarr = $this->db->listinfo($where);
			$success_uids = $info = array();
			
			foreach($userarr as $v) {
				$status = $this->client->ps_member_register($v['username'], $v['password'], $v['email'], $v['regip'], $v['encrypt']);
				if ($status > 0) {
					$info['phpssouid'] = $status;
					$info['password'] = password($v['password'], $v['encrypt']);
					$info['regdate'] = $info['lastdate'] = $v['regdate'];
					$info['username'] = $v['username'];
					$info['nickname'] = $v['nickname'];
					$info['email'] = $v['email'];
					$info['regip'] = $v['regip'];
					$info['point'] = $v['point'];
					$info['groupid'] = $this->_get_usergroup_bypoint($v['point']);
					$info['amount'] = $v['amount'];
					$info['encrypt'] = $v['encrypt'];
					$info['modelid'] = $v['modelid'] ? $v['modelid'] : 10;
					if($v['mobile']) $info['mobile'] = $v['mobile'];
					$userid = $this->member_db->insert($info, 1);

					if($v['modelinfo']) {	//如果数据模型不为空
						//插入会员模型数据
						$user_model_info = string2array($v['modelinfo']);
						$user_model_info['userid'] = $userid;
						$this->member_db->set_model($info['modelid']);
						$this->member_db->insert($user_model_info);
					}
					
					if($userid) {
						$success_uids[] = $v['userid'];
					}
				}
			}
			$where = to_sqls($success_uids, '', 'userid');			
			$this->db->update(array('status'=>1, 'message'=>$_POST['message']), $where);
			
			//phpsso注册失败的用户状态直接置为审核期间phpsso已注册该会员
			$fail_uids = array_diff($uidarr, $success_uids);
			if (!empty($fail_uids)) {
				$where = to_sqls($fail_uids, '', 'userid');
				$this->db->update(array('status'=>5, 'message'=>$_POST['message']), $where);
			}
			
			//发送 email通知
			if($_POST['sendemail']) {
				$memberinfo = $this->db->select($where);
				pc_base::load_sys_func('mail');
				foreach ($memberinfo as $v) {
					sendmail($v['email'], L('reg_pass'), $_POST['message']);
				}
			}
			
			showmessage(L('pass').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/**
	 * delete member
	 */
	function delete() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$message = stripslashes($_POST['message']);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->delete($where);
						
			showmessage(L('delete').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * reject member
	 */
	function reject() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$res = $this->db->update(array('status'=>4, 'message'=>$_POST['message']), $where);
			//发送 email通知
			if($res) {
				if($_POST['sendemail']) {
					$memberinfo = $this->db->select($where);
					pc_base::load_sys_func('mail');
					foreach ($memberinfo as $v) {
						sendmail($v['email'], L('reg_reject'), $_POST['message']);
					}
				}
			}
			
			showmessage(L('reject').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * ignore member
	 */
	function ignore() {
		if(isset($_POST['userid'])) {		
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$res = $this->db->update(array('status'=>2, 'message'=>$_POST['message']), $where);
			//发送 email通知
			if($res) {
				if($_POST['sendemail']) {
					$memberinfo = $this->db->select($where);
					pc_base::load_sys_func('mail');
					foreach ($memberinfo as $v) {
						sendmail($v['email'], L('reg_ignore'), $_POST['message']);
					}
				}
			}
			showmessage(L('ignore').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
		
	/*
	 * change password
	 */
	function _edit_password($userid, $password){
		$userid = intval($userid);
		if($userid < 1) return false;
		if(!is_password($password))
		{
			showmessage(L('password_format_incorrect'));
			return false;
		}
		$passwordinfo = password($password);
		return $this->db->update($passwordinfo,array('userid'=>$userid));
	}
	
	private function _checkuserinfo($data, $is_edit=0) {
		if(!is_array($data)){
			showmessage(L('need_more_param'));return false;
		} elseif (!is_username($data['username']) && !$is_edit){
			showmessage(L('username_format_incorrect'));return false;
		} elseif (!isset($data['userid']) && $is_edit) {
			showmessage(L('username_format_incorrect'));return false;
		}  elseif (empty($data['email']) || !is_email($data['email'])){
			showmessage(L('email_format_incorrect'));return false;
		}
		return $data;
	}
		
	private function _checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}
	
	private function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	/**
	 *根据积分算出用户组
	 * @param $point int 积分数
	 */
	private function _get_usergroup_bypoint($point=0) {
		$groupid = 2;
		if(empty($point)) {
			$member_setting = getcache('member_setting');
			$point = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		}
		$grouplist = getcache('grouplist');
		
		foreach ($grouplist as $k=>$v) {
			$grouppointlist[$k] = $v['point'];
		}
		arsort($grouppointlist);

		//如果超出用户组积分设置则为积分最高的用户组
		if($point > max($grouppointlist)) {
			$groupid = key($grouppointlist);
		} else {
			foreach ($grouppointlist as $k=>$v) {
				if($point >= $v) {
					$groupid = $tmp_k;
					break;
				}
				$tmp_k = $k;
			}
		}
		return $groupid;
	}
	
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
	/**
	 * check uername status
	 */
	public function checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		$username = iconv('utf-8', CHARSET, $username);
		
		$status = $this->client->ps_checkname($username);
		if($status == -4) {	//deny_register
			exit('0');
		}
		
		$status = $this->client->ps_get_member_info($username, 2);
		if (is_array($status)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * check email status
	 */
	public function checkemail_ajax() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//deny_register
			exit('0');
		}
				
		$status = $this->client->ps_get_member_info($email, 3);
		if(isset($_GET['phpssouid']) && isset($status['uid'])) {
			if ($status['uid'] == intval($_GET['phpssouid'])) {
				exit('1');
			}
		}

		if (is_array($status)) {
			exit('0');
		} else {
			exit('1');
		}
	}
}
?>