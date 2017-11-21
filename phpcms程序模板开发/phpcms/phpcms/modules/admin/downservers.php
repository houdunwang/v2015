<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
class downservers extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('downservers_model');
		$this->sites = pc_base::load_app_class('sites');
	}
	
	public function init() {
		if(isset($_POST['dosubmit'])) {
			$info['siteurl'] = trim($_POST['info']['siteurl']);
			$info['sitename'] = trim($_POST['info']['sitename']);
			$info['siteid'] = intval($_POST['info']['siteid']);
			if(empty($info['sitename'])) showmessage(L('downserver_not_empty'), HTTP_REFERER);	
			if(empty($info['siteurl']) || !preg_match('/(\w+):\/\/(.+)[^\/]$/i', $info['siteurl'])) showmessage(L('downserver_error'), HTTP_REFERER);
			$insert_id = $this->db->insert($info,true);
			if($insert_id){
				$this->_set_cache();
				showmessage(L('operation_success'), HTTP_REFERER);
			}
		} else {
			$infos =  $sitelist = array();
			$current_siteid = get_siteid();
			$where = "`siteid`='$current_siteid' or `siteid`=''";
			$sitelists = $this->sites->get_list();
			if($_SESSION['roleid'] == '1') {
				foreach($sitelists as $key=>$v) $sitelist[$key] = $v['name'];
				$default = L('all_site');
			} else {
				$sitelist[$current_siteid] = $sitelists[$current_siteid]['name'];
				$default = '';
			}			
			$page = $_GET['page'] ? $_GET['page'] : '1';
			$infos = $this->db->listinfo($where, 'listorder DESC,id DESC', $page, $pagesize = 20);
			$pages = $this->db->pages;						
			include $this->admin_tpl('downservers_list');
		}
	}
	
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$info['siteurl'] = trim($_POST['info']['siteurl']);
			$info['sitename'] = trim($_POST['info']['sitename']);
			$info['siteid'] = intval($_POST['info']['siteid']);
			if(empty($info['sitename'])) showmessage(L('downserver_not_empty'), HTTP_REFERER);	
			if(empty($info['siteurl']) || !preg_match('/(\w+):\/\/(.+)[^\/]$/i', $info['siteurl'])) showmessage(L('downserver_error'), HTTP_REFERER);
			$id = intval(trim($_POST['id']));
			$this->_set_cache();
			$this->db->update($info,array('id'=>$id));
			showmessage(L('operation_success'), '', '', 'edit');
		} else {
			$info =  $sitelist = array();
			$default = '';
			$sitelists = $this->sites->get_list();
			if($_SESSION['roleid'] == '1') {
				foreach($sitelists as $key=>$v) $sitelist[$key] = $v['name'];
				$default = L('all_site');
			} else {
				$current_siteid = self::get_siteid();
				$sitelist[$current_siteid] = $sitelists[$current_siteid]['name'];
				$default = '';
			}			
			$info = $this->db->get_one(array('id'=>intval($_GET['id'])));
			extract($info);
			$show_validator = true;
			$show_header = true;
			include $this->admin_tpl('downservers_edit');
		}
	}
	
	public function delete() {
		$id = intval($_GET['id']);
		$this->db->delete(array('id'=>$id));
		$this->_set_cache();
		showmessage(L('downserver_del_success'), HTTP_REFERER);
	}	
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}	
	
	private function _set_cache() {
		$infos = $this->db->select();
		foreach ($infos as $info){
			$servers[$info['id']] = $info;
		}
		setcache('downservers', $servers,'commons');
		return $infos;
	}
	
}
?>