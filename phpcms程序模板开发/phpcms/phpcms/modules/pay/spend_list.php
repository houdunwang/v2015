<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_class('foreground','member');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class spend_list extends foreground {
	private $spend_db;
	
	function __construct() {
		if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists')); 
		$this->spend_db = pc_base::load_model('pay_spend_model');
		parent::__construct();
	}
	
	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$userid  = param::get_cookie('_userid');
		$sql =  " `userid` = '$userid'";
		if (isset($_GET['dosubmit'])) {
			$type = isset($_GET['type']) && intval($_GET['type']) ? intval($_GET['type']) : '';
			$endtime = isset($_GET['endtime'])  &&  trim($_GET['endtime']) ? strtotime(trim($_GET['endtime'])) : '';
			$starttime = isset($_GET['starttime']) && trim($_GET['starttime']) ? strtotime(trim($_GET['starttime'])) : '';
			
			if (!empty($starttime) && empty($endtime)) {
				$endtime = SYS_TIME;
			}
			
			if (!empty($starttime) && !empty($endtime) && $endtime < $starttime) {
				showmessage(L('wrong_time_over_time_to_time_less_than'));
			}
						
			if (!empty($starttime)) {
				$sql .= $sql ? " AND `creat_at` BETWEEN '$starttime' AND '$endtime' " : " `creat_at` BETWEEN '$starttime' AND '$endtime' ";
			}
			
			if (!empty($type)) {
				$sql .= $sql ? " AND `type` = '$type' " : " `type` = '$type'";
			}
			
		}
		$list = $this->spend_db->listinfo($sql, '`id` desc', $page);
		$pages = $this->spend_db->pages;
		include template('pay', 'spend_list');
	}
}