<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class search_type extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('type_model');
		$this->siteid = $this->get_siteid();
		$this->model = getcache('model','commons');
		$this->yp_model = getcache('yp_model','model');
		$this->module_db = pc_base::load_model('module_model');
	}
	
	public function init () {
		$datas = array();
		$page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
		$result_datas = $this->db->listinfo(array('siteid'=>$this->siteid,'module'=>'search'),'listorder ASC', $page);
		$pages = $this->db->pages;
		foreach($result_datas as $r) {
			$r['modelname'] = $this->model[$r['modelid']]['name'];
			$datas[] = $r;
		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=search&c=search_type&a=add\', title:\''.L('add_search_type').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_search_type'));
		$this->cache();
		include $this->admin_tpl('type_list');
	}
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['module'] = 'search';
			if($_POST['module']=='content') {
				$_POST['info']['modelid'] = intval($_POST['info']['modelid']);
				$_POST['info']['typedir'] = $_POST['module'];
			} elseif($_POST['module']=='yp') {
				$_POST['info']['modelid'] = intval($_POST['info']['yp_modelid']);
				$_POST['info']['typedir'] = $_POST['module'];				
			} else {
				$_POST['info']['typedir'] = $_POST['module'];
				$_POST['info']['modelid'] = 0;
			}
			
			//删除黄页模型变量无该字段
			unset($_POST['info']['yp_modelid']);

			$this->db->insert($_POST['info']);
			showmessage(L('add_success'), '', '', 'add');
		} else {
			$show_header = $show_validator = '';
			
			foreach($this->model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$model_data[$_key] = $_value['name'];
			}
			if(is_array($this->yp_model)){
				foreach($this->yp_model as $_key=>$_value) {
					if($_value['siteid']!=$this->siteid) continue;
					$yp_model_data[$_key] = $_value['name'];
				}	
			}
					

			$module_data = array('special' => L('special'),'content' => L('content').L('module'),'yp'=>L('yp'));

			include $this->admin_tpl('type_add');
		}
	}
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$typeid = intval($_POST['typeid']);
			
			if($_POST['module']=='content') {
				$_POST['info']['modelid'] = intval($_POST['info']['modelid']);
			} elseif($_POST['module']=='yp') {
				$_POST['info']['modelid'] = intval($_POST['info']['yp_modelid']);
				$_POST['info']['typedir'] = $_POST['module'];				
			} else {
				$_POST['info']['typedir'] = $_POST['typedir'];
				$_POST['info']['modelid'] = 0;
			}
				
			//删除黄页模型变量无该字段
			unset($_POST['info']['yp_modelid']);
	
			$this->db->update($_POST['info'],array('typeid'=>$typeid));
			showmessage(L('update_success'), '', '', 'edit');
		} else {
			$show_header = $show_validator = '';
			$typeid = intval($_GET['typeid']);
			foreach($this->model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$model_data[$_key] = $_value['name'];
			}
			foreach($this->yp_model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$yp_model_data[$_key] = $_value['name'];
			}
						
			$module_data = array('special' => L('special'),'content' => L('content').L('module'),'yp'=>L('yp'));
			$r = $this->db->get_one(array('typeid'=>$typeid));

			extract($r);
			include $this->admin_tpl('type_edit');
		}
	}
	public function delete() {
		$_GET['typeid'] = intval($_GET['typeid']);
		$this->db->delete(array('typeid'=>$_GET['typeid']));
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('typeid'=>intval($id)));
			}
			showmessage(L('operation_success'));
		} else {
			showmessage(L('operation_failure'));
		}
	}
	
	public function cache() {
		$datas = $search_model = array();
		$result_datas = $result_datas2 = $this->db->select(array('siteid'=>$this->siteid,'module'=>'search'),'*',1000,'listorder ASC');
		foreach($result_datas as $_key=>$_value) {
			if(!$_value['modelid']) continue;
			$datas[$_value['modelid']] = $_value['typeid'];
			$search_model[$_value['modelid']]['typeid'] = $_value['typeid'];
			$search_model[$_value['modelid']]['name'] = $_value['name'];
			$search_model[$_value['modelid']]['sort'] = $_value['listorder'];
		}

		setcache('type_model_'.$this->siteid,$datas,'search');
		$datas = array();	
		foreach($result_datas2 as $_key=>$_value) {
			if($_value['modelid']) continue;
			$datas[$_value['typedir']] = $_value['typeid'];
			$search_model[$_value['typedir']]['typeid'] = $_value['typeid'];
			$search_model[$_value['typedir']]['name'] = $_value['name'];
		}
		setcache('type_module_'.$this->siteid,$datas,'search');
		//搜索header头中使用类型缓存
		setcache('search_model_'.$this->siteid,$search_model,'search');
		return true;
	}
}
?>