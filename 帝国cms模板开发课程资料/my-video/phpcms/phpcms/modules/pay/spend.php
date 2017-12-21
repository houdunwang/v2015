<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class spend extends admin {
	private $db;
	
	public function __construct() {
		$this->db = pc_base::load_model('pay_spend_model');
		parent::__construct();
	}
	
	public function init() {
		pc_base::load_sys_class('form', '', 0);
		pc_base::load_sys_class('format', '', 0);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$sql =  "";
		if (isset($_GET['dosubmit'])) {
			$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : '';
			$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : '';
			$user_type = isset($_GET['user_type']) && intval($_GET['user_type']) ? intval($_GET['user_type']) : '';
			$op_type = isset($_GET['op_type']) && intval($_GET['op_type']) ? intval($_GET['op_type']) : '';
			$type = isset($_GET['type']) && intval($_GET['type']) ? intval($_GET['type']) : '';
			$endtime = isset($_GET['endtime'])  &&  trim($_GET['endtime']) ? strtotime(trim($_GET['endtime'])) : '';
			$starttime = isset($_GET['starttime']) && trim($_GET['starttime']) ? strtotime(trim($_GET['starttime'])) : '';
			
			if (!empty($starttime) && empty($endtime)) {
				$endtime = SYS_TIME;
			}
			
			if (!empty($starttime) && !empty($endtime) && $endtime < $starttime) {
				showmessage(L('wrong_time_over_time_to_time_less_than'));
			}
			
			
			if (!empty($username) && $user_type == 1) {
				$sql .= $sql ? " AND `username` = '$username'" : " `username` = '$username'";
			}
			
			if (!empty($username) && $user_type == 2) {
				$sql .= $sql ? " AND `userid` = '$username'" : " `userid` = '$username'";
			}
			
			if (!empty($starttime)) {
				$sql .= $sql ? " AND `creat_at` BETWEEN '$starttime' AND '$endtime' " : " `creat_at` BETWEEN '$starttime' AND '$endtime' ";
			}
			
			if (!empty($op) && $op_type == 1) {
				$sql .= $sql ? " AND `op_username` = '$op' " : " `op_username` = '$op' ";
			} elseif (!empty($op) && $op_type == 2) {
				$sql .= $sql ? " AND `op_userid` = '$op' " : " `op_userid` = '$op' ";
			}
			
			if (!empty($type)) {
				$sql .= $sql ? " AND `type` = '$type' " : " `type` = '$type'";
			}
		}
		$list = $this->db->listinfo($sql, '`id` desc', $page);
		$pages = $this->db->pages;
		include $this->admin_tpl('spend_list');
	}
}