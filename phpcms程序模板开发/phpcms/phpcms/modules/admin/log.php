<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class log extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('log_model');
		pc_base::load_sys_class('form');
		$admin_username = param::get_cookie('admin_username');//管理员COOKIE
		$userid = $_SESSION['userid'];//登陆USERID　
	}
	
	function init () {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where = '',$order = 'logid DESC',$page, $pages = '13');
		$pages = $this->db->pages;
		//模块数组
		$module_arr = array();
		$modules = getcache('modules','commons');
		$default = L('open_module');
		foreach($modules as $module=>$m) $module_arr[$m['module']] = $m['module'];
 		include $this->admin_tpl('log_list');
	}
		
	/**
	 * 操作日志删除 包含批量删除 单个删除
	 */
	function delete() {
		$week = intval($_GET['week']);
		if($week){
			$where = '';
			$start = SYS_TIME - $week*7*24*3600;
			$d = date("Y-m-d",$start); 
 			//$end = strtotime($end_time);
			//$where .= "AND `message_time` >= '$start' AND `message_time` <= '$end' ";
			$where .= "`time` <= '$d'";
			$this->db->delete($where);
			showmessage(L('operation_success'),'?m=admin&c=log');
		} else {
			return false;
		}
	}
 		
 	
	/**
	 * 日志搜索
	 */
	public function search_log() {
 		$where = '';
		extract($_GET['search'],EXTR_SKIP);
		if($username){
			$where .= $where ?  " AND username='$username'" : " username='$username'";
		}
		if ($module){
			$where .= $where ?  " AND module='$module'" : " module='$module'";
		}
		if($start_time && $end_time) {
			$start = $start_time;
			$end = $end_time;
			$where .= "AND `time` >= '$start' AND `time` <= '$end' ";
		}
 
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1; 
		$infos = $this->db->listinfo($where,$order = 'logid DESC',$page, $pages = '12'); 
 		$pages = $this->db->pages;
 		//模块数组
		$module_arr = array();
		$modules = getcache('modules','commons');
		$default = $module ? $module : L('open_module');//未设定则显示 不限模块 ，设定则显示指定的
 		foreach($modules as $module=>$m) $module_arr[$m['module']] = $m['module'];
		
 		include $this->admin_tpl('log_search_list');
	} 
	
}
?>