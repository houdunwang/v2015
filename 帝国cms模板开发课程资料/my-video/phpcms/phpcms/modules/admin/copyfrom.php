<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class copyfrom extends admin {
	private $db;
	public $siteid;
	function __construct() {
		$this->db = pc_base::load_model('copyfrom_model');
		pc_base::load_sys_class('form', '', 0);
		parent::__construct();
		$this->siteid = $this->get_siteid();
	}
	
	/**
	 * 来源管理列表
	 */
	public function init () {
		$datas = array();
		$datas = $this->db->listinfo(array('siteid'=>$this->siteid),'listorder ASC',$_GET['page']);
		$pages = $this->db->pages;

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=copyfrom&a=add\', title:\''.L('add_copyfrom').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_copyfrom'));
		$this->public_cache();
		include $this->admin_tpl('copyfrom_list');
	}
	
	/**
	 * 添加来源
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info'] = $this->check($_POST['info']);
			$this->db->insert($_POST['info']);
			showmessage(L('add_success'), '', '', 'add');
		} else {
			$show_header = $show_validator = '';
			
			include $this->admin_tpl('copyfrom_add');
		}
	}
	
	/**
	 * 管理来源
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			$_POST['info'] = $this->check($_POST['info']);
			$this->db->update($_POST['info'],array('id'=>$id));
			showmessage(L('update_success'), '', '', 'edit');
		} else {
			$show_header = $show_validator = '';
			$id = intval($_GET['id']);
			if (!$id) showmessage(L('illegal_action'));
			$r = $this->db->get_one(array('id'=>$id, 'siteid'=>$this->siteid));
			if (empty($r)) showmessage(L('illegal_action'));
			extract($r);
			include $this->admin_tpl('copyfrom_edit');
		}
	}
	
	/**
	 * 删除来源
	 */
	public function delete() {
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['id']) showmessage(L('illegal_action'));
		$this->db->delete(array('id'=>$_GET['id'], 'siteid'=>$this->siteid));
		exit('1');
	}
	
	/**
	 * 检查POST数据
	 * @param array $data 前台POST数据
	 * @return array $data
	 */
	private function check($data = array()) {
		if (!is_array($data) || empty($data)) return array();
		if (!preg_match('/^((http|https):\/\/)?([^\/]+)/i', $data['siteurl'])) showmessage(L('input').L('copyfrom_url'));
		if (empty($data['sitename'])) showmessage(L('input').L('copyfrom_name'));
		if ($data['thumb'] && !preg_match('/^((http|https):\/\/)?([^\/]+)/i', $data['thumb'])) showmessage(L('copyfrom_logo').L('format_incorrect'));
		$data['siteid'] = $this->siteid;
		return $data;
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}

	/**
	 * 生成缓存
	 */
	public function public_cache() {
		$infos = $this->db->select('','*','','listorder DESC','','id');
		setcache('copyfrom', $infos, 'admin');
		return true;
 	}
}
?>