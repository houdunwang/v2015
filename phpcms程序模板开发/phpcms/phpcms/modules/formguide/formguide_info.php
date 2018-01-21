<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class formguide_info extends admin {
	
	private $db, $f_db, $tablename;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->f_db = pc_base::load_model('sitemodel_model');
		if (isset($_GET['formid']) && !empty($_GET['formid'])) {
			$formid = intval($_GET['formid']);
			$f_info = $this->f_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->get_siteid()), 'tablename');
			$this->tablename = 'form_'.$f_info['tablename'];
			$this->db->change_table($this->tablename);
		}
	}
	
	/**
	 * 用户提交表单信息列表
	 */
	public function init() {
		if (!isset($_GET['formid']) || empty($_GET['formid'])) {
			showmessage(L('illegal_operation'), HTTP_REFERER);
		}
		$formid = intval($_GET['formid']);
		if (!$this->tablename) {
			$f_info = $this->f_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->get_siteid()), 'tablename');
			$this->tablename = 'form_'.$f_info['tablename'];
			$this->db->change_table($this->tablename);
		}
		$page = max(intval($_GET['page']), 1);
		$r = $this->db->get_one(array(), "COUNT(dataid) sum");
		$total = $r['sum'];
		$this->f_db->update(array('items'=>$total), array('modelid'=>$formid));
		$pages = pages($total, $page, 20);
		$offset = ($page-1)*20;
		$datas = $this->db->select(array(), '*', $offset.', 20', '`dataid` DESC');
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=formguide&c=formguide&a=add\', title:\''.L('formguide_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('formguide_add'));
		include $this->admin_tpl('formguide_info_list');
	}
	
	/**
	 * 查看
	 */
	public function public_view() {
		if (!$this->tablename || !isset($_GET['did']) || empty($_GET['did'])) showmessage(L('illegal_operation'), HTTP_REFERER);
		$did = intval($_GET['did']);
		$formid = intval($_GET['formid']);
		$info = $this->db->get_one(array('dataid'=>$did));
		pc_base::load_sys_class('form', '', '');
		define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
		require CACHE_MODEL_PATH.'formguide_output.class.php';
		$formguide_output = new formguide_output($formid);
		$forminfos_data = $formguide_output->get($info);
		$fields = $formguide_output->fields;
		include $this->admin_tpl('formguide_info_view');
	}
	
	/**
	 * 删除
	 */
	public function public_delete() {
		$formid = intval($_GET['formid']);
		if (isset($_GET['did']) && !empty($_GET['did'])) {
			$did = intval($_GET['did']);
			$this->db->delete(array('dataid'=>$did));
			$this->f_db->update(array('items'=>'-=1'), array('modelid'=>$formid));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else if(is_array($_POST['did']) && !empty($_POST['did'])) {
			foreach ($_POST['did'] as $did) {
				$did = intval($did);
				$this->db->delete(array('dataid'=>$did));
				$this->f_db->update(array('items'=>'-=1'), array('modelid'=>$formid));
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('illegal_operation'), HTTP_REFERER);
		}
	}
}
?>