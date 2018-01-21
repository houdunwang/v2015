<?php
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'formguide'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('util');

class formguide_field extends admin {
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->model_db = pc_base::load_model('sitemodel_model');
		$this->siteid = $this->get_siteid();
	}
	
	public function init() {
		if (isset($_GET['formid']) && !empty($_GET['formid'])) {
			$formid = intval($_GET['formid']);
			$this->cache_field($formid);
			$datas = $this->db->select(array('modelid'=>$formid),'*',100,'listorder ASC');
			$r = $this->model_db->get_one(array('modelid'=>$formid));
		} else {
			$data = $datas = array();
			$data = getcache('form_public_field_array', 'model');
			if (is_array($data)) {
				foreach ($data as $_k => $_v) {
					$datas[$_k] = $_v['info'];
				}
			}
		}
		$show_header = $show_validator = $show_dialog = '';
		require MODEL_PATH.'fields.inc.php';
		include $this->admin_tpl('formguide_field_list');
	}
	
	/**
	 * 添加字段，当没有formid时为添加公用字段
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$field = $_POST['info']['field'];
			$minlength = $_POST['info']['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $_POST['info']['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $_POST['info']['formtype'];
			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting']);
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['unsetgroupids'] = isset($_POST['unsetgroupids']) ? implode(',',$_POST['unsetgroupids']) : '';
			$_POST['info']['unsetroleids'] = isset($_POST['unsetroleids']) ? implode(',',$_POST['unsetroleids']) : '';
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
				
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $_POST['setting']['fieldtype'];
			}
			if (isset($_POST['info']['modelid']) && !empty($_POST['info']['modelid'])) {
				$formid = intval($_POST['info']['modelid']);
				$forminfo = $this->model_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->siteid), 'tablename');
				$tablename = $this->db->db_tablepre.'form_'.$forminfo['tablename'];
				require MODEL_PATH.'add.sql.php';
				
				$this->db->insert($_POST['info']);
				$this->cache_field($formid);
			} else {
				$unrunsql = 1;
				$tablename = 'formguide_table';
				require MODEL_PATH.'add.sql.php';
				
				$form_public_field_array = getcache('form_public_field_array', 'model');
				if (array_key_exists($_POST['info']['field'], $form_public_field_array)) {
					showmessage(L('fields').L('already_exist'), HTTP_REFERER);
				} else {
					$form_public_field_array[$_POST['info']['field']] = array('info'=>$_POST['info'], 'sql'=>$sql); 
					setcache('form_public_field_array', $form_public_field_array, 'model');	
				}
			}
			showmessage(L('add_success'),'?m=formguide&c=formguide_field&a=init&formid='.$formid);
		} else {
			$show_header = $show_validator = $show_dialog = '';
			pc_base::load_sys_class('form','',0);
			require MODEL_PATH.'fields.inc.php';
			$formid = intval($_GET['formid']);
			$f_datas = $this->db->select(array('modelid'=>$formid),'field,name',100,'listorder ASC');
			$m_r = $this->model_db->get_one(array('modelid'=>$formid));
			foreach($f_datas as $_k=>$_v) {
				$exists_field[] = $_v['field'];
			}

			$all_field = array();
			foreach($fields as $_k=>$_v) {
				$all_field[$_k] = $_v;
			}

			$grouplist = array();
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			header("Cache-control: private");
			include $this->admin_tpl('formguide_field_add');
		}
	}
	
	public function edit() {
		if (isset($_POST['dosubmit'])) {
			$field = $_POST['info']['field'];
			$minlength = $_POST['info']['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $_POST['info']['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $_POST['info']['formtype'];
			
			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting']);
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['unsetgroupids'] = isset($_POST['unsetgroupids']) ? implode(',',$_POST['unsetgroupids']) : '';
			$_POST['info']['unsetroleids'] = isset($_POST['unsetroleids']) ? implode(',',$_POST['unsetroleids']) : '';
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
				
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $_POST['setting']['fieldtype'];
			}
			$oldfield = $_POST['oldfield'];
			if (isset($_POST['info']['modelid']) && !empty($_POST['info']['modelid'])) {
				$formid = intval($_POST['info']['modelid']);
				$forminfo = $this->model_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->siteid), 'tablename');
				$tablename = $this->db->db_tablepre.'form_'.$forminfo['tablename'];
				
				$fieldid = intval($_POST['fieldid']);

				require MODEL_PATH.'edit.sql.php';
				$this->db->update($_POST['info'],array('fieldid'=>$fieldid,'siteid'=>$this->siteid));
			} else {
				$unrunsql = 1;
				$tablename = 'formguide_table';
				require MODEL_PATH.'add.sql.php';
				
				$form_public_field_array = getcache('form_public_field_array', 'model');
				if ($oldfield) {
					if ($form_public_field_array[$oldfield]['info']['listorder']) {
						$_POST['info']['listorder'] = $form_public_field_array[$oldfield]['info']['listorder'];
					}
					if ($oldfield == $_POST['info']['field']) {
						$form_public_field_array[$_POST['info']['field']] = array('info'=>$_POST['info'], 'sql'=>$sql);
					} else {
						if (array_key_exists($_POST['info']['field'], $form_public_field_array)) {
							showmessage(L('fields').L('already_exist'), HTTP_REFERER);
						}
						$new_form_field = $form_public_field_array;
						$form_public_field_array = array();
						foreach ($new_form_field as $name => $v) {
							if ($name == $oldfield) {
								$form_public_field_array[$_POST['info']['field']] = array('info'=>$_POST['info'], 'sql'=>$sql);
							} else {
								$form_public_field_array[$name] = $v;
							}
						}
					}
				}
				setcache('form_public_field_array', $form_public_field_array, 'model');	
			}
			showmessage(L('update_success'),'?m=formguide&c=formguide_field&a=init&formid='.$formid);
		} else {
			if (isset($_GET['formid']) && !empty($_GET['formid'])) {
				pc_base::load_sys_class('form','',0);
				require MODEL_PATH.'fields.inc.php'; 
				$formid = intval($_GET['formid']);
				$fieldid = intval($_GET['fieldid']);
				
				$m_r = $this->model_db->get_one(array('modelid'=>$formid));
				$r = $this->db->get_one(array('fieldid'=>$fieldid));
				extract($r);
				require MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'config.inc.php';
			} else {
				if (!isset($_GET['field']) || empty($_GET['field'])) {
					showmessage(L('illegal_operation'), HTTP_REFERER);
				}
				
				$form_public_field_array = getcache('form_public_field_array', 'model');
				if (!array_key_exists($_GET['field'], $form_public_field_array)) {
					showmessage(L('illegal_operation'), HTTP_REFERER);
				}
				extract($form_public_field_array[$_GET['field']]);
				extract($info);
				$setting = stripslashes($setting);
				$show_header = $show_validator = $show_dialog = '';
				pc_base::load_sys_class('form','',0);
				require MODEL_PATH.'fields.inc.php';
			}
			$setting = string2array($setting);
			ob_start();
			include MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'field_edit_form.inc.php';
			$form_data = ob_get_contents();
			ob_end_clean();
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			header("Cache-control: private");
			include $this->admin_tpl('formguide_field_edit');
		}
	}
	
	/**
	 * 禁用、开启字段
	 */
	public function disabled() {
		$fieldid = intval($_GET['fieldid']);
		$disabled = $_GET['disabled'] ? 0 : 1;
		$this->db->update(array('disabled'=>$disabled),array('fieldid'=>$fieldid,'siteid'=>$this->siteid));
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	/**
	 * 删除字段
	 */
	public function delete() {
		if (isset($_GET['formid']) && !empty($_GET['formid']) && isset($_GET['fieldid']) && !empty($_GET['fieldid'])) {
			$formid = intval($_GET['formid']);
			$fieldid = intval($_GET['fieldid']);
			$r = $this->model_db->get_one(array('modelid'=>$formid), 'tablename');
			$rs = $this->db->get_one(array('fieldid'=>$fieldid, 'siteid'=>$this->siteid), 'field');
			$this->db->delete(array('fieldid'=>$fieldid, 'siteid'=>$this->siteid));
			if ($r) {
				$field = $rs['field'];
				$tablename = $this->db->db_tablepre.'form_'.$r['tablename'];
				require MODEL_PATH.'delete.sql.php';
			}
		} else {
			if (!isset($_GET['field']) || empty($_GET['field'])) showmessage(L('illegal_operation'), HTTP_REFERER);
			$field = $_GET['field'];
			$form_public_field_array = getcache('form_public_field_array', 'model');
			if (array_key_exists($field, $form_public_field_array)) {
				unset($form_public_field_array[$field]);
			}
			setcache('form_public_field_array', $form_public_field_array, 'model');
		}
		showmessage(L('update_success'), '?m=formguide&c=formguide_field&a=init&formid='.$formid);
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			if (isset($_GET['formid']) && !empty($_GET['formid'])) {
				foreach($_POST['listorders'] as $id => $listorder) {
					$this->db->update(array('listorder'=>$listorder),array('fieldid'=>$id));
				}
			} else {
				$form_public_field_array = getcache('form_public_field_array', 'model');
				asort($_POST['listorders']);
				$new_form_field = array();
				foreach ($_POST['listorders'] as $id => $listorder) {
					$form_public_field_array[$id]['info']['listorder'] = $listorder;
					$new_form_field[$id] = $form_public_field_array[$id];
				}
				unset($form_public_field_array);
				setcache('form_public_field_array', $new_form_field, 'model');
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}
	
	/**
	 * 检查字段是否存在
	 */
	public function public_checkfield() {
		$field = strtolower($_GET['field']);
		$oldfield = strtolower($_GET['oldfield']);
		if($field==$oldfield) exit('1');
		$modelid = intval($_GET['modelid']);
		
		if (in_array($field, array('dataid', 'userid', 'username', 'datetime', 'ip'))) {
			exit('0');	
		}
		
		if($modelid) {
			$forminfo = $this->model_db->get_one(array('modelid'=>$modelid), 'tablename');
			$this->db->table_name = $this->db->db_tablepre.'form_'.$forminfo['tablename'];
			$fields = $this->db->get_fields();
		} else {
			$fields = getcache('form_public_field_array', 'model');
		}
		if(is_array($fields) && array_key_exists($field,$fields)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * 字段属性设置
	 */
	public function public_field_setting() {
		$fieldtype = $_GET['fieldtype'];
		require MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'config.inc.php';
		ob_start();
		include MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'field_add_form.inc.php';
		$data_setting = ob_get_contents();
		//$data_setting = iconv('gbk','utf-8',$data_setting);
		ob_end_clean();
		$settings = array('field_basic_table'=>$field_basic_table,'field_minlength'=>$field_minlength,'field_maxlength'=>$field_maxlength,'field_allow_search'=>$field_allow_search,'field_allow_fulltext'=>$field_allow_fulltext,'field_allow_isunique'=>$field_allow_isunique,'setting'=>$data_setting);
		echo json_encode($settings);
		return true;
	}
	
	/**
	 * 更新指定表单向导的字段缓存
	 * 
	 * @param $formid 表单向导id
	 * @param $disabled 字段状态
	 */
	public function cache_field($formid = 0, $disabled = 0) {
		$field_array = array();
		$fields = $this->db->select(array('modelid'=>$formid,'disabled'=>$disabled),'*',100,'listorder ASC');
		foreach($fields as $_value) {
			$setting = string2array($_value['setting']);
			$_value = array_merge($_value,$setting);
			$field_array[$_value['field']] = $_value;
		}
		setcache('formguide_field_'.$formid,$field_array,'model');
		return true;
	}
}
?>