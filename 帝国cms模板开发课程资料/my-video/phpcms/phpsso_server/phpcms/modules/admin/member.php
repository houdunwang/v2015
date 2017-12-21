<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_class('messagequeue', 'admin' , 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class member extends admin {
	
	private $db, $config;
	/**
	 * 析构函数
	 */
	public function __construct() {	
		parent::__construct();
		$this->db = pc_base::load_model('member_model');
		$this->config = pc_base::load_config('system');
	}
	
	/**
	 * 管理会员
	 */
	public function manage() {
		/*搜索用户*/
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d', SYS_TIME-date('t', SYS_TIME)*86400);
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);

		if (isset($_GET['search'])) {
			//默认选取一个月内的用户，防止用户量过大给数据造成灾难
			$where_start_time = strtotime($start_time);
			$where_end_time = strtotime($end_time) + 86400;
			//开始时间大于结束时间，置换变量
			if($where_start_time > $where_end_time) {
				$tmp = $where_start_time;
				$where_start_time = $where_end_time;
				$where_end_time = $tmp;
				unset($tmp);
			}
			$where = "regdate BETWEEN '$where_start_time' AND '$where_end_time' AND ";
		
			if ($type == '1') {
				$where .= "username LIKE '%$keyword%'";
			} elseif($type == '2') {
				$where .= "uid = '$keyword'";
			} elseif($type == '3') {
				$where .= "email like '%$keyword%'";
			} elseif($type == '4') {
				$where .= "regip = '$keyword'";
			} else {
				$where .= "username like '%$keyword%'";
			}
		} else {
			$where = '';
		}
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$memberlist = $this->db->listinfo($where, 'uid DESC', $page, 12);
		$pages = $this->db->pages;
		include $this->admin_tpl('member_list');
	}
	
	/**
	 * 添加会员
	 */
	public function add() {
		if (isset($_POST['dosubmit'])) {
			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('nameerror'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_can_not_be_empty'), HTTP_REFERER);
			$email = isset($_POST['email']) && is_email($_POST['email']) ? trim($_POST['email']) : showmessage(L('email_format_incorrect'), HTTP_REFERER);
			$regdate = SYS_TIME;

			if ($this->db->get_one(array('username'=>$username))) {
				showmessage(L('user_already_exist'), HTTP_REFERER);
			} elseif ($this->db->get_one(array('email'=>$email))) {
				showmessage(L('email_already_exist'), HTTP_REFERER);
			} else {
				if (strlen($password) > 20 || strlen($password) < 6) {
					showmessage(L('password_len_error'), HTTP_REFERER);
				}
				$old_password = $password;
				list($password, $random) = creat_password($password);
				
				//UCenter会员注册
				$ucuserid = 0;
				if ($this->config['ucuse']) {
					pc_base::load_config('uc_config');
					include PHPCMS_PATH.'api/uc_client/client.php';
					$uid= uc_user_register($username, $old_password, $email, $random);
					switch ($uid) {
						case '-3':
						case '-6':
						case '-2':
						case '-5':
						case '-1':
						case '-4':
							showmessage(L('ucenter_error_code', array('code'=>$uid)), HTTP_REFERER);
							break;
						default :
							$ucuserid = $uid;
							break;
					}
				}	
				
				if ($uid = $this->db->insert(array('username'=>$username, 'password'=>$password, 'random'=>$random, 'email'=>$email, 'regdate'=>$regdate, 'lastdate'=>SYS_TIME, 'type'=>'app', 'regip'=>ip(), 'appname'=>'phpsso', 'ucuserid'=>$ucuserid), 1)) {
					/*插入消息队列*/
					$noticedata = array('uid'=>$uid, 'username'=>$username, 'password'=>$password, 'random'=>$random, 'email'=>$email, 'regip'=>ip());
					messagequeue::add('member_add', $noticedata);
					
					showmessage(L('member_add').L('operation_success'), 'm=admin&c=member&a=manage');
				} else {
					showmessage(L('database_error'), HTTP_REFERER);
				}
			}
			
		} else {
			include $this->admin_tpl('member_add');
		}
	}
	
	/**
	 * 编辑会员
	 */
	public function edit() {
		if (isset($_POST['dosubmit'])) {
			$uid = isset($_POST['uid']) && trim($_POST['uid']) ? trim($_POST['uid']) : showmessage(L('nameerror'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : '';
			$email = isset($_POST['email']) && is_email(trim($_POST['email'])) ? trim($_POST['email']) : showmessage(L('email_format_incorrect'), HTTP_REFERER);
			
			$updateinfo['random'] = '';
			if (!empty($password)) {
				if (strlen($password) > 20 || strlen($password) < 6) {
					showmessage(L('password_len_error'), HTTP_REFERER);
				} else {
					$passwordarr = creat_password($password);
					$updateinfo['password'] = $passwordarr[0];
					$updateinfo['random'] = $passwordarr[1];
				}
			}
			
			if ($this->db->get_one("`email` = '$email' AND `uid` != '$uid'")) {
				showmessage(L('email_already_exist'), HTTP_REFERER);
			}
			
			$updateinfo['email'] = $email;
			//是否删除头像
			if(isset($_POST['avatar']) && $_POST['avatar']==1) {
				$updateinfo['avatar'] = 0;
				$dir = ps_getavatar($uid, 1);
				ps_unlink($dir);
			}
			
			//ucenter部份
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				include PHPCMS_PATH.'api/uc_client/client.php';
				$userinfo = $this->db->get_one(array('uid'=>$uid));
				$r = uc_user_edit($userinfo['username'], '', (!empty($password) ? $password : ''), $updateinfo['email'],1);
				if ($r < 0) {
				 //{-1:用户不存在;-2:旧密码错误;-3:email已经存在 ;1:成功;0:未作修改}
					showmessage(L('ucenter_error_code', array('code'=>$r)), HTTP_REFERER);
				}
			}
			
			if (empty($updateinfo['random'])) {
				unset($updateinfo['random']);
			}
		
			if ($this->db->update($updateinfo, array('uid'=>$uid))) {
				/*插入消息队列*/
				$noticedata = $updateinfo;
				$noticedata['uid'] = $uid;
				messagequeue::add('member_edit', $noticedata);
			
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} else {
			$uid = isset($_GET['uid']) && trim($_GET['uid']) ? trim($_GET['uid']) : showmessage(L('user_not_exist'), HTTP_REFERER);
			if (!$userinfo = $this->db->get_one(array('uid'=>$uid))) {
				showmessage(L('user_not_exist'), HTTP_REFERER);
			}
			include $this->admin_tpl('member_edit');
		}
	}

	/**
	 * 删除会员
	 */
	public function delete() {
		$uidarr = isset($_POST['uid']) ? $_POST['uid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$new_arr = array();
		foreach($uidarr as $v) {
			$v = intval($v);
			$new_arr[] = $v;
			//删除头像
			$dir = ps_getavatar($v, 1);
			ps_unlink($dir);
		}
			
		$where = to_sqls($new_arr, '', 'uid');
		
		//ucenter部份
		if ($this->config['ucuse']) {
			pc_base::load_config('uc_config');
			include PHPCMS_PATH.'api/uc_client/client.php';
			$s = $this->db->select($where, 'ucuserid');
			if ($s) {
				$uc_data = array();
				foreach ($s as $k=>$v) {
					$uc_data[$k] = $v['ucuserid'];
				}
				if (!empty($uc_data)) $r = uc_user_delete($uc_data);
				if (!$r) {
					showmessage(L('operation_failure'), HTTP_REFERER);
				}
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
			
		}
			
		if ($this->db->delete($where)) {
			/*插入消息队列*/
			$noticedata = array('uids'=>$new_arr);
			messagequeue::add('member_delete', $noticedata);
								
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	public function ajax_username() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit('0');
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
		if ($this->db->get_one(array('username'=>$username))) {
			exit('0');
		} else {
			//UCenter部分
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				include PHPCMS_PATH.'api/uc_client/client.php';
				$rs= uc_user_checkname($username);
				if ($rs < 1) {
					exit('0');
				}
			}
			exit('1');
		}
	}

	public function ajax_email() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit('0');
		$uid = isset($_GET['uid']) && trim($_GET['uid']) ? trim($_GET['uid']) : '';
		$where = !empty($uid) ? "`email` = '$email' AND `uid` != '$uid'" : array('email'=>$email);
		if ($this->db->get_one($where)) {
			exit('0');
		} else {
			//UCenter部分
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				include PHPCMS_PATH.'api/uc_client/client.php';
				$rs= uc_user_checkemail($email);
				if ($rs < 1) {
					exit('0');
				}
			}
			exit('1');
		}
	}
}
?>