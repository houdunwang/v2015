<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('global');
class payment extends admin {
	private $db, $account_db, $member_db;
	function __construct() {
		if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists')); 
		parent::__construct();
		$this->db = pc_base::load_model('pay_payment_model');
		$this->account_db = pc_base::load_model('pay_account_model');
		$this->member_db = pc_base::load_model('member_model');
		$this->modules_path = PC_PATH.'modules'.DIRECTORY_SEPARATOR.'pay';
		pc_base::load_app_class('pay_method','','0');
		$this->method = new pay_method($this->modules_path);
	}
	/**
	 * 支付模块列表
	 */
	public function init() {	
		$infos = $this->method->get_list();
		$show_dialog = true;
		include $this->admin_tpl('payment_list');
	}
	/*
	 * 增加支付模块
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$info = $infos = array();
			$infos = $this->method->get_payment($_POST['pay_code']);
			$config = $infos['config'];
			foreach ($_POST['config_name'] as $key => $value) {
				$config[$value]['value'] = trim($_POST['config_value'][$key]);
			}
			$info['config'] = array2string($config);
			$info['name'] = $_POST['name'];
			$info['pay_name'] = $_POST['pay_name'];
			$info['pay_desc'] = $_POST['description'];
			$info['pay_id'] = $_POST['pay_id'];
			$info['pay_code'] = $_POST['pay_code'];
			$info['is_cod'] = $_POST['is_cod'];
			$info['is_online'] = $_POST['is_online'];
			$info['pay_fee'] = intval($_POST['pay_fee']);
			$info['pay_method'] = intval($_POST['pay_method']);
			$info['pay_order'] = intval($_POST['pay_order']);
			$info['enabled'] = '1';
			$info['author'] = $infos['author'];
			$info['website'] = $infos['website'];
			$info['version'] = $infos['version'];
			$this->db->insert($info);
			if($this->db->insert_id()){
				showmessage(L('operation_success'), '', '', 'add');
			}		
		} else {
			$infos = $this->method->get_payment($_GET['code']);
			extract($infos);
			$show_header = true;
			$show_validator = true;
			include $this->admin_tpl('payment_detail');			
		}
	}
	/*
	 * 编辑支付模块
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$infos = $this->method->get_payment($_POST['pay_code']);
			$config = $infos['config'];
			foreach ($_POST['config_name'] as $key => $value) {
				$config[$value]['value'] = trim($_POST['config_value'][$key]);
			}
			$info['config'] = array2string($config);
			$info['name'] = trim($_POST['name']);
			$info['pay_name'] = trim($_POST['pay_name']);
			$info['pay_desc'] = trim($_POST['description']);
			$info['pay_id'] = $_POST['pay_id'];
			$info['pay_code'] = trim($_POST['pay_code']);
			$info['pay_order'] = intval($_POST['pay_order']);
			$info['pay_method'] = intval($_POST['pay_method']);	
			$info['pay_fee']  = (intval($_POST['pay_method'])==0) ? intval($_POST['pay_rate']) : intval($_POST['pay_fix']);		
			$info['is_cod'] = trim($_POST['is_cod']);
			$info['is_online'] = trim($_POST['is_online']);
			$info['enabled'] = '1';
			$info['author'] = $infos['author'];
			$info['website'] = $infos['website'];
			$info['version'] = $infos['version'];
			$infos = $this->db->update($info,array('pay_id'=>$info['pay_id']));
			showmessage(L('edit').L('succ'), '', '', 'edit');						
		} else {
			$pay_id = intval($_GET['id']);
			$infos = $this->db->get_one(array('pay_id'=>$pay_id));
			extract($infos);
			$config = string2array($config);
			$show_header = true;
			$show_validator = true;
			include $this->admin_tpl('payment_detail');			
		}
	}
	
	/**
	 * 卸载支付模块
	 */
	public function delete() {
		$pay_id = intval($_GET['id']);
		$this->db->delete(array('pay_id'=>$pay_id));
		showmessage(L('delete_succ'),'?m=pay&c=payment');
	}
	
	/**
	 * 支付订单列表
	 */
	public function pay_list() {
		$where = '';
		if($_GET['dosubmit']){
			extract($_GET['info']);
			if($trade_sn) $where = "AND `trade_sn` LIKE '%$trade_sn%' ";
			if($username) $where = "AND `username` LIKE '%$username%' ";
			if($start_addtime && $end_addtime) {
				$start = strtotime($start_addtime.' 00:00:00');
				$end = strtotime($end_addtime.' 23:59:59');
				$where .= "AND `addtime` >= '$start' AND  `addtime` <= '$end'";				
			}
			if($status) $where .= "AND `status` LIKE '%$status%' ";			
			if($where) $where = substr($where, 3);
		}			
		$infos = array();
		foreach(L('select') as $key=>$value) {
			$trade_status[$key] = $value;
		}
		$page = $_GET['page'] ? $_GET['page'] : '1';
		
		$infos = $this->account_db->listinfo($where, $order = 'addtime DESC,id DESC', $page, $pagesize = 20);
		$pages = $this->account_db->pages;
		$number = count($infos);
		include $this->admin_tpl('pay_list');	
	}
	
	/**
	 * 财务统计
	 * Enter description here ...
	 */
	public function pay_stat() {
		$where = '';
		$infos = array();
		if($_GET['dosubmit']){
			extract($_GET['info']);
			if($username) $where = "AND `username` LIKE '%$username%' ";
			if($start_addtime && $end_addtime) {
				$start = strtotime($start_addtime.' 00:00:00');
				$end = strtotime($end_addtime.' 23:59:59');
				$where .= "AND `addtime` >= '$start' AND  `addtime` <= '$end'";				
			}
			if($status) $where .= "AND `status` LIKE '%$status%' ";			
			if($where) $where = substr($where, 3);
			$infos = $this->account_db->select($where);
			$num= count($infos);
			foreach ($infos as $_v) {
				if($_v['type'] == 1) {
					$amount_num++;
					$amount += $_v['money']; 
					if($_v['status'] =='succ') {$amount_succ += $_v['money'];$amount_num_succ++;}
				}  elseif ($_v['type'] == 2) {
					$point_num++;
					$point += $_v['money']; 
					if($_v['status'] =='succ') {$point_succ += $_v['money'];$point_num_succ++;}
				}
			}			
		}		
		foreach(L('select') as $key=>$value) $trade_status[$key] = $value;		
		$total_infos = $this->account_db->select();
		$total_num= count($total_infos);
		foreach ($total_infos as $_v) {
			if($_v['type'] == 1) {
				$total_amount_num++;
				$total_amount += $_v['money']; 
				if($_v['status'] =='succ') {$total_amount_succ += $_v['money'];$total_amount_num_succ++;}
			}  elseif ($_v['type'] == 2) {
				$total_point_num++;
				$total_point += $_v['money']; 
				if($_v['status'] =='succ') {$total_point_succ += $_v['money'];$total_point_num_succ++;}
			}			
		}
		include $this->admin_tpl('pay_stat');
	}
	
	/**
	 * 支付打折
	 * Enter description here ...
	 */
	public function discount() {
		if(isset($_POST['dosubmit'])) {
			$discount = floatval($_POST['discount']);
			$id = intval($_POST['id']);
			$infos = $this->account_db->update(array('discount'=>$discount),array('id'=>$id));
			showmessage(L('public_discount_succ'), '', '', 'discount');			
		} else {
			$show_header = true;
			$show_validator = true;
			$id = intval($_GET['id']);
			$infos = $this->account_db->get_one(array('id'=>$id));
			extract($infos);
			include $this->admin_tpl('pay_discount');			
		}
	}
	
	/**
	 * 修改财务
	 * Enter description here ...
	 */
	public function modify_deposit() {
		if(isset($_POST['dosubmit'])) {
			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('username').L('error'));
			$usernote = isset($_POST['usernote']) && trim($_POST['usernote']) ? addslashes(trim($_POST['usernote'])) : showmessage(L('usernote').L('error'));	
			$userinfo = $this->get_useid($username);
			if($userinfo) {	
				//如果增加金钱或点数，想pay_account 中记录数据
				if($_POST['pay_unit']) {
					$value = floatval($_POST['unit']);
					$payment = L('admin_recharge');
					$receipts = pc_base::load_app_class('receipts');
					$func = $_POST['pay_type'] == '1' ? 'amount' :'point';
					$receipts->$func($value, $userinfo['userid'] , $username, create_sn(), 'offline', $payment, param::get_cookie('admin_username'), $status = 'succ',$usernote);					
					
				} else {
					$value = floatval($_POST['unit']);
					$msg = L('background_operation').$usernote;
					$spend = pc_base::load_app_class('spend');
					$func = $_POST['pay_type'] == '1' ? 'amount' :'point';
					$spend->$func($value,$msg,$userinfo['userid'],$username,param::get_cookie('userid'),param::get_cookie('admin_username'));
				}
				if(intval($_POST['sendemail'])) {
					pc_base::load_sys_func('mail');
					$op = $_POST['pay_unit'] ? $value: '-'.$value;
					$op = $_POST['pay_type'] ? $op.L('yuan') : $op.L('point');
					$msg = L('account_changes_notice_tips',array('username'=>$username,'time'=>date('Y-m-d H:i:s',SYS_TIME),'op'=>$op,'note'=>$usernote,'amount'=>$userinfo['amount'],'point'=>$userinfo['point']));
					sendmail($userinfo['email'],L('send_account_changes_notice'),$msg);
				}
				showmessage(L('public_discount_succ'),HTTP_REFERER);	
			}
		} else {
			$show_validator = true;
			include $this->admin_tpl('modify_deposit');			
		}

	}
	
	/*
	 * 支付删除
	 */
	public function pay_del() {
		$id = intval($_GET['id']);
		$this->account_db->delete(array('id'=>$id));
		showmessage(L('delete_succ'),'?m=pay&c=payment&a=pay_list&menuid='.$_GET['menuid']);
	}
	
	/*
	 * 支付取消
	 */
	public function pay_cancel() {
		$id = intval($_GET['id']);
		$this->account_db->update(array('status'=>'cancel'),array('id'=>$id));
		showmessage(L('state_change_succ'),HTTP_REFERER);
	}
	/*
	 * 支付详情
	 */
	public function public_pay_detail() {
		$id = intval($_GET['id']);
		$infos = $this->account_db->get_one(array('id'=>$id));
		extract($infos);
		$show_header = true;
		include $this->admin_tpl('pay_detail');
	}
	
	public function public_check() {
		$id = intval($_GET['id']);
		$infos = $this->account_db->get_one(array('id'=>$id));
		$userinfo = $this->member_db->get_one(array('userid'=>$infos['userid']));
		$amount = $userinfo['amount'] + $infos['money'];
		$this->account_db->update(array('status'=>'succ','adminnote'=>param::get_cookie('admin_username')),array('id'=>$id));
		$this->member_db->update(array('amount'=>$amount),array('userid'=>$infos['userid']));
		showmessage(L('check_passed'),'?m=pay&c=payment&a=pay_list');
	}
		
	private function get_useid($username) {
		$username = trim($username);
		if ($result = $this->member_db->get_one(array('username'=>$username))){
			return $result;
		} else {
			return false;
		}		
	}
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
		$this->member_db = pc_base::load_model('member_model');
		if ($r = $this->member_db->get_one(array('username'=>$username))){
			exit(L('user_balance').$r['amount'].'  '.L('point').'  '.$r['point']);
		} else {
			exit('FALSE');
		}		
	}	
}
?>