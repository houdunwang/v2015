<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class ipbanned extends admin {
	function __construct() {
		$this->db = pc_base::load_model('ipbanned_model');
		pc_base::load_sys_class('form', '', 0);
		parent::__construct();
	}
	
	function init () {
		$page = $_GET['page'] ? $_GET['page'] : '1';
		$infos = array();
		$infos = $this->db->listinfo('','ipbannedid DESC',$page ,'20');
		$pages = $this->db->pages;	
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=ipbanned&a=add\', title:\''.L('add_ipbanned').'\', width:\'450\', height:\'300\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_ipbanned'));
		include $this->admin_tpl('ipbanned_list');
	}
	
	/**
	 * 验证数据有效性
	 */
	public function public_name() {
		$ip = isset($_GET['ip']) && trim($_GET['ip']) ? (CHARSET == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['ip'])) : trim($_GET['ip'])) : exit('0');
 		//添加判断IP是否重复
		if ($this->db->get_one(array('ip'=>$ip), 'ipbannedid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
		
	/**
	 * IP添加
	 */
	function add() {
		if(isset($_POST['dosubmit'])){
  			$_POST['info']['expires']=strtotime($_POST['info']['expires']);
			$this->db->insert($_POST['info']);
			$this->public_cache_file();//更新缓存 
			showmessage(L('operation_success'),'?m=admin&c=ipbanned&a=add','', 'add');
		}else{
			$show_validator = $show_scroll = $show_header = true;
	 		include $this->admin_tpl('ipbanned_add');
		}	 
	} 
	 
	/**
	 * IP删除
	 */
	function delete() {
 		if(is_array($_POST['ipbannedid'])){
			foreach($_POST['ipbannedid'] as $ipbannedid_arr) {
				$this->db->delete(array('ipbannedid'=>$ipbannedid_arr));
			}
			$this->public_cache_file();//更新缓存 
			showmessage(L('operation_success'),'?m=admin&c=ipbanned');	
		} else {
			$ipbannedid = intval($_GET['ipbannedid']);
			if($ipbannedid < 1) return false;
			$result = $this->db->delete(array('ipbannedid'=>$ipbannedid));
			$this->public_cache_file();//更新缓存 
			if($result){
				showmessage(L('operation_success'),'?m=admin&c=ipbanned');
			} else {
				showmessage(L("operation_failure"),'?m=admin&c=ipbanned');
			}
		}
	}
	
	/**
	 * IP搜索
	 */
	public function search_ip() {
		$where = '';
		if($_GET['search']) extract($_GET['search']);
		if($ip){
			$where .= $where ?  " AND ip LIKE '%$ip%'" : " ip LIKE '%$ip%'";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'ipbannedid DESC',$page, $pages = '2');
		$pages = $this->db->pages;
  		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=ipbanned&a=add\', title:\''.L('add_ipbanned').'\', width:\'450\', height:\'300\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_ipbanned'));
		include $this->admin_tpl('ip_search_list');
	} 
	
	/**
	 * 生成缓存
	 */
	public function public_cache_file() {
		$infos = $this->db->select('','ip,expires','','ipbannedid desc');
		setcache('ipbanned', $infos, 'commons');
		return true;
 	}
}
?>