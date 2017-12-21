<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class data extends admin {
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('datacall_model');
		parent::__construct();
	}
	
	public function init() {
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=dbsource&c=data&a=add\', title:\''.L('adding_data_source_call').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('adding_data_source_call'));
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$list = $this->db->listinfo('','id desc', $page, 20);
		$pages = $this->db->pages;
		include $this->admin_tpl('data_list');
	}
	
	public function add() {
		pc_base::load_app_func('global');
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'));
			$dis_type = isset($_POST['dis_type']) && intval($_POST['dis_type']) ? intval($_POST['dis_type']) : 1;
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
			$num = isset($_POST['num']) && intval($_POST['num']) ? intval($_POST['num']) : 0;
			$type = isset($_POST['type']) && intval($_POST['type']) ? intval($_POST['type']) : 0;
			//检查名称是否已经存在
			if ($this->db->get_one(array('name'=>$name)))  {
				showmessage(L('name').L('exists'));
			}
			$sql = array();
			if ($type == '1') { //自定义SQL
				$data = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'));
				$sql = array('data'=>$data);
			} else { //模型配置方式
				$module = isset($_POST['module']) && trim($_POST['module']) ? trim($_POST['module']) : showmessage(L('please_select_model'));
				$action = isset($_POST['action']) && trim($_POST['action']) ? trim($_POST['action']) : showmessage(L('please_select_action'));
				$html = pc_tag_class($module);
				$data = array();
				if (isset($html[$action]) && is_array($html[$action])) {
					foreach ($html[$action] as $key=>$val) {
						$val['validator']['reg_msg'] = $val['validator']['reg_msg'] ? $val['validator']['reg_msg'] : $val['name'].L('inputerror');
						$$key = isset($_POST[$key]) && trim($_POST[$key]) ? trim($_POST[$key]) : '';
						if (!empty($val['validator'])) {
							if (isset($val['validator']['min']) && strlen($$key) < $val['validator']['min']) {
								showmessage($val['name'].L('should').L('is_greater_than').$val['validator']['min'].L('lambda'));
							} 
							if (isset($val['validator']['max']) && strlen($$key) > $val['validator']['max']) {
								showmessage($val['name'].L('should').L('less_than').$val['validator']['max'].L('lambda'));
							} 
							if (!preg_match('/'.$val['validator']['reg'].'/'.$val['validator']['reg_param'], $$key)) {
								showmessage($val['name'].$val['validator']['reg_msg']);
							}
						}
						$data[$key] = $$key;
					}
				}
				$sql = array('data'=>array2string($data), 'module'=>$module, 'action'=>$action);
			}
			
			if ($dis_type == 3) {
				$sql['template'] = isset($_POST['template']) && trim($_POST['template']) ? trim($_POST['template']) : '';
			}
			//初始化数据
			$sql['name'] = $name;
			$sql['type'] = $type;
			$sql['dis_type'] = $dis_type;
			$sql['cache'] = $cache;
			$sql['num'] = $num;
			if ($id = $this->db->insert($sql,true)) {
				//当为JS时，输出模板文件
				if ($dis_type == 3) {
					$tpl = pc_base::load_sys_class('template_cache');
					$str = $this->db->get_one(array('id'=>$id), 'template');
					$str = $tpl->template_parse($str['template']);
					$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.'dbsource'.DIRECTORY_SEPARATOR;
					if(!is_dir($filepath)) {
						mkdir($filepath, 0777, true);
				    }
					@file_put_contents($filepath.$id.'.php', $str);
				}
				
				showmessage('', '', '', 'add');
			} else {
				showmessage(L('operation_failure'));
			}
		} else {
			pc_base::load_sys_class('form','',0);
			$modules = array_merge(array(''=>L('please_select')),pc_base::load_config('modules'));
			$show_header = $show_validator = true;
			$type = isset($_GET['type']) && intval($_GET['type']) ? intval($_GET['type']) : 0;
			$module = isset($_GET['module']) && trim($_GET['module']) ? trim($_GET['module']) : '';
			$action = isset($_GET['action']) && trim($_GET['action']) ? trim($_GET['action']) : '';
			if ($module) $html = pc_tag_class($module);
			pc_base::load_app_func('global','template');
			include $this->admin_tpl('data_add');
		}
	}
	
	public function edit() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :  showmessage(L('illegal_parameters'), HTTP_REFERER);
		if (!$edit_data = $this->db->get_one(array('id'=>$id))) {
			showmessage(L('notfound'));
		}
		pc_base::load_app_func('global');
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'));
			$dis_type = isset($_POST['dis_type']) && intval($_POST['dis_type']) ? intval($_POST['dis_type']) : 1;
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
			$num = isset($_POST['num']) && intval($_POST['num']) ? intval($_POST['num']) : 0;
			$type = isset($_POST['type']) && intval($_POST['type']) ? intval($_POST['type']) : 0;
			//检查名称是否已经存在
		if ($edit_data['name'] != $name) {
				if ($this->db->get_one(array('name'=>$name), 'id'))  {
					showmessage(L('name').L('exists'));
				}
			}
			$sql = array();
			if ($type == '1') { //自定义SQL
				$data = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'));
				$sql = array('data'=>$data);
			} else { //模型配置方式
				$module = isset($_POST['module']) && trim($_POST['module']) ? trim($_POST['module']) : showmessage(L('please_select_model'));
				$action = isset($_POST['action']) && trim($_POST['action']) ? trim($_POST['action']) : showmessage(L('please_select_action'));
				$html = pc_tag_class($module);
				$data = array();
				if (isset($html[$action]) && is_array($html[$action])) {
					foreach ($html[$action] as $key=>$val) {
						$val['validator']['reg_msg'] = $val['validator']['reg_msg'] ? $val['validator']['reg_msg'] : $val['name'].L('inputerror');
						$$key = isset($_POST[$key]) && trim($_POST[$key]) ? trim($_POST[$key]) : '';
					if (!empty($val['validator'])) {
							if (isset($val['validator']['min']) && strlen($$key) < $val['validator']['min']) {
								showmessage($val['name'].L('should').L('is_greater_than').$val['validator']['min'].L('lambda'));
							} 
							if (isset($val['validator']['max']) && strlen($$key) > $val['validator']['max']) {
								showmessage($val['name'].L('should').L('less_than').$val['validator']['max'].L('lambda'));
							} 
							if (!preg_match('/'.$val['validator']['reg'].'/'.$val['validator']['reg_param'], $$key)) {
								showmessage($val['name'].$val['validator']['reg_msg']);
							}
						}
						$data[$key] = $$key;
					}
				}
				$sql = array('data'=>array2string($data), 'module'=>$module, 'action'=>$action);
			}
			
			if ($dis_type == 3) {
				$sql['template'] = isset($_POST['template']) && trim($_POST['template']) ? trim($_POST['template']) : '';
			}
			//初始化数据
			$sql['name'] = $name;
			$sql['type'] = $type;
			$sql['dis_type'] = $dis_type;
			$sql['cache'] = $cache;
			$sql['num'] = $num;
			if ($this->db->update($sql,array('id'=>$id))) {
				//当为JS时，输出模板文件
				if ($dis_type == 3) {
					$tpl = pc_base::load_sys_class('template_cache');
					$str = $this->db->get_one(array('id'=>$id), 'template');
					$str = $tpl->template_parse($str['template']);
					$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.'dbsource'.DIRECTORY_SEPARATOR;
					if(!is_dir($filepath)) {
						mkdir($filepath, 0777, true);
				    }
					@file_put_contents($filepath.$id.'.php', $str);
				}
				
				showmessage('', '', '', 'edit');
			} else {
				showmessage(L('operation_failure'));
			}
		} else {
			pc_base::load_sys_class('form','',0);
			$modules = array_merge(array(''=>L('please_select')),pc_base::load_config('modules'));
			$show_header = $show_validator = true;
			$type = isset($_GET['type']) ? intval($_GET['type']) : $edit_data['type'];
			$module = isset($_GET['module']) && trim($_GET['module']) ? trim($_GET['module']) : $edit_data['module'];
			$action = isset($_GET['action']) && trim($_GET['action']) ? trim($_GET['action']) : $edit_data['action'];
			if ($edit_data['type'] == 0) $form_data = string2array($edit_data['data']);
			if ($module) $html = pc_tag_class($module);
			pc_base::load_app_func('global','template');
			include $this->admin_tpl('data_edit');
		}
	}
	
	public function del() {
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if (is_array($id)) {
			foreach ($id as $key => $v) {
				if (intval($v)) {
					$id[$key] = intval($v);
				} else {
					unset($id[$key]);
				}
			}
			$sql = implode('\',\'', $id);
			$this->db->delete("id in ('$sql')");
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$id = intval($id);
			if(empty($id)) showmessage(L('illegal_parameters'), HTTP_REFERER);
			if ($this->db->delete(array('id'=>$id))) {
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		}
	}
	
	public function public_name() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
 		$data = array();
		if ($id) {
			$data = $this->db->get_one(array('id'=>$id), 'name');
			if (!empty($data) && $data['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$name), 'id')) {
			exit('0');
		} else {
			exit('1');
		}
	}
}