<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin','admin',0);
class sitemodel extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('sitemodel_model');
		$this->siteid = $this->get_siteid();
		if(!$this->siteid) $this->siteid = 1;
	}
	
	public function init() {
		$categorys = getcache('category_content_'.$this->siteid,'commons');
		
		$datas = $this->db->listinfo(array('siteid'=>$this->siteid,'type'=>0),'',$_GET['page'],30);
		//模型文章数array('模型id'=>数量);
		$items = array();
		foreach ($datas as $k=>$r) {
			foreach ($categorys as $catid=>$cat) {
				if(intval($cat['modelid']) == intval($r['modelid'])) {
					$items[$r['modelid']] += intval($cat['items']);
				} else {
					$items[$r['modelid']] += 0;
				}
			}
			$datas[$k]['items'] = $items[$r['modelid']];
		}

		$pages = $this->db->pages;
		$this->public_cache();
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=content&c=sitemodel&a=add\', title:\''.L('add_model').'\', width:\'580\', height:\'420\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_model'));
		include $this->admin_tpl('sitemodel_manage');
	}
	
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['category_template'] = $_POST['setting']['category_template'];
			$_POST['info']['list_template'] = $_POST['setting']['list_template'];
			$_POST['info']['show_template'] = $_POST['setting']['show_template'];
			if (isset($_POST['other']) && $_POST['other']) {
				$_POST['info']['admin_list_template'] = $_POST['setting']['admin_list_template'];
				$_POST['info']['member_add_template'] = $_POST['setting']['member_add_template'];
				$_POST['info']['member_list_template'] = $_POST['setting']['member_list_template'];
			} else {
				unset($_POST['setting']['admin_list_template'], $_POST['setting']['member_add_template'], $_POST['setting']['member_list_template']);
			}
			$modelid = $this->db->insert($_POST['info'],1);
			$model_sql = file_get_contents(MODEL_PATH.'model.sql');
			$tablepre = $this->db->db_tablepre;
			$tablename = $_POST['info']['tablename'];
			$model_sql = str_replace('$basic_table', $tablepre.$tablename, $model_sql);
			$model_sql = str_replace('$table_data',$tablepre.$tablename.'_data', $model_sql);
			$model_sql = str_replace('$table_model_field',$tablepre.'model_field', $model_sql);
			$model_sql = str_replace('$modelid',$modelid,$model_sql);
			$model_sql = str_replace('$siteid',$this->siteid,$model_sql);
			
			$this->db->sql_execute($model_sql);
			$this->cache_field($modelid);
			//调用全站搜索类别接口
			$this->type_db = pc_base::load_model('type_model');
			$this->type_db->insert(array('name'=>$_POST['info']['name'],'module'=>'search','modelid'=>$modelid,'siteid'=>$this->siteid));
			$cache_api = pc_base::load_app_class('cache_api','admin');
			$cache_api->cache('type');
			$cache_api->search_type();
			showmessage(L('add_success'), '', '', 'add');
		} else {
			pc_base::load_sys_class('form','',0);
			$show_header = $show_validator = '';
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$admin_list_template = $this->admin_list_template('content_list', 'name="setting[admin_list_template]"');
			include $this->admin_tpl('sitemodel_add');
		}
	}
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			
			$modelid = intval($_POST['modelid']);
			$_POST['info']['category_template'] = $_POST['setting']['category_template'];
			$_POST['info']['list_template'] = $_POST['setting']['list_template'];
			$_POST['info']['show_template'] = $_POST['setting']['show_template'];
			if (isset($_POST['other']) && $_POST['other']) {
				$_POST['info']['admin_list_template'] = $_POST['setting']['admin_list_template'];
				$_POST['info']['member_add_template'] = $_POST['setting']['member_add_template'];
				$_POST['info']['member_list_template'] = $_POST['setting']['member_list_template'];
			} else {
				unset($_POST['setting']['admin_list_template'], $_POST['setting']['member_add_template'], $_POST['setting']['member_list_template']);
			}
			
			$this->db->update($_POST['info'],array('modelid'=>$modelid,'siteid'=>$this->siteid));
			showmessage(L('update_success'), '', '', 'edit');
		} else {
			pc_base::load_sys_class('form','',0);
			$show_header = $show_validator = '';
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$modelid = intval($_GET['modelid']);
			$r = $this->db->get_one(array('modelid'=>$modelid));
			extract($r);
			$admin_list_template_f = $this->admin_list_template($admin_list_template, 'name="setting[admin_list_template]"');
			include $this->admin_tpl('sitemodel_edit');
		}
	}
	public function delete() {
		$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
		$modelid = intval($_GET['modelid']);
		$model_cache = getcache('model','commons');
		$model_table = $model_cache[$modelid]['tablename'];
		$this->sitemodel_field_db->delete(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		$this->db->drop_table($model_table);
		$this->db->drop_table($model_table.'_data');
		
		$this->db->delete(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		//删除全站搜索接口数据
		$this->type_db = pc_base::load_model('type_model');
		$this->type_db->delete(array('module'=>'search','modelid'=>$modelid,'siteid'=>$this->siteid));
		$cache_api = pc_base::load_app_class('cache_api','admin');
		$cache_api->cache('type');
		$cache_api->search_type();
		exit('1');
	}
	public function disabled() {
		$modelid = intval($_GET['modelid']);
		$r = $this->db->get_one(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		
		$status = $r['disabled'] == '1' ? '0' : '1';
		$this->db->update(array('disabled'=>$status),array('modelid'=>$modelid,'siteid'=>$this->siteid));
		showmessage(L('update_success'), HTTP_REFERER);
	}
	/**
	 * 更新模型缓存
	 */
	public function public_cache() {
		require MODEL_PATH.'fields.inc.php';
		//更新内容模型类：表单生成、入库、更新、输出
		$classtypes = array('form','input','update','output');
		foreach($classtypes as $classtype) {
			$cache_data = file_get_contents(MODEL_PATH.'content_'.$classtype.'.class.php');
			$cache_data = str_replace('}?>','',$cache_data);
			foreach($fields as $field=>$fieldvalue) {
				if(file_exists(MODEL_PATH.$field.DIRECTORY_SEPARATOR.$classtype.'.inc.php')) {
					$cache_data .= file_get_contents(MODEL_PATH.$field.DIRECTORY_SEPARATOR.$classtype.'.inc.php');
				}
			}
			$cache_data .= "\r\n } \r\n?>";
			file_put_contents(CACHE_MODEL_PATH.'content_'.$classtype.'.class.php',$cache_data);
			@chmod(CACHE_MODEL_PATH.'content_'.$classtype.'.class.php',0777);
		}
		//更新模型数据缓存
		$model_array = array();
		$datas = $this->db->select(array('type'=>0));
		foreach ($datas as $r) {
			if(!$r['disabled']) $model_array[$r['modelid']] = $r;
		}
		setcache('model', $model_array, 'commons');
		return true;
	}
	/**
	 * 导出模型
	 */
	function export() {
		$modelid = isset($_GET['modelid']) ? $_GET['modelid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$modelarr = getcache('model', 'commons');
		//定义系统字段排除
		//$system_field = array('id','title','style','catid','url','listorder','status','userid','username','inputtime','updatetime','pages','readpoint','template','groupids_view','posids','content','keywords','description','thumb','typeid','relation','islink','allow_comment');
		$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
		$modelinfo = $this->sitemodel_field_db->select(array('modelid'=>$modelid));
		foreach($modelinfo as $k=>$v) {
			//if(in_array($v['field'],$system_field)) continue;
			$modelinfoarr[$k] = $v;
			$modelinfoarr[$k]['setting'] = string2array($v['setting']);
		}
		$res = var_export($modelinfoarr, TRUE);
		header('Content-Disposition: attachment; filename="'.$modelarr[$modelid]['tablename'].'.model"');
		echo $res;exit;
	}
	/**
	 * 导入模型
	 */
	function import(){
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$info['name'] = $_POST['info']['modelname'];
			//主表表名
			$basic_table = $info['tablename'] = $_POST['info']['tablename'];
			//从表表名
			$table_data = $basic_table.'_data';
			$info['description'] = $_POST['info']['description'];
			$info['type'] = 0;
			$info['siteid'] = $this->siteid;
			
			$info['default_style'] = $_POST['default_style'];
			$info['category_template'] = $_POST['setting']['category_template'];
			$info['list_template'] = $_POST['setting']['list_template'];
			$info['show_template'] = $_POST['setting']['show_template'];
			
			if(!empty($_FILES['model_import']['tmp_name'])) {
				$model_import = @file_get_contents($_FILES['model_import']['tmp_name']);
				if(!empty($model_import)) {
					$model_import_data = string2array($model_import);				
				}
			}
			$is_exists = $this->db->table_exists($basic_table);
			if($is_exists) showmessage(L('operation_failure'),'?m=content&c=sitemodel&a=init');
			$modelid = $this->db->insert($info, 1);
			if($modelid){
				$tablepre = $this->db->db_tablepre;
				//建立数据表
				$model_sql = file_get_contents(MODEL_PATH.'model.sql');
				$model_sql = str_replace('$basic_table', $tablepre.$basic_table, $model_sql);
				$model_sql = str_replace('$table_data',$tablepre.$table_data, $model_sql);
				$model_sql = str_replace('$table_model_field',$tablepre.'model_field', $model_sql);
				$model_sql = str_replace('$modelid',$modelid,$model_sql);
				$model_sql = str_replace('$siteid',$this->siteid,$model_sql);
				$this->db->sql_execute($model_sql);
				
				if(!empty($model_import_data)) {
					$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
					$system_field = array('title','style','catid','url','listorder','status','userid','username','inputtime','updatetime','pages','readpoint','template','groupids_view','posids','content','keywords','description','thumb','typeid','relation','islink','allow_comment');
					foreach($model_import_data as $v) {
						$field = $v['field'];
						if(in_array($field,$system_field)) {
							$v['siteid'] = $this->siteid;
							unset($v['fieldid'],$v['modelid'],$v['field']);
							$v = new_addslashes($v);
							$v['setting'] = array2string($v['setting']);
							
							$this->sitemodel_field_db->update($v,array('modelid'=>$modelid,'field'=>$field));
						} else {
							$tablename = $v['issystem'] ? $tablepre.$basic_table : $tablepre.$table_data;
							//重组模型表字段属性
							
							$minlength = $v['minlength'] ? $v['minlength'] : 0;
							$maxlength = $v['maxlength'] ? $v['maxlength'] : 0;
							$field_type = $v['formtype'];
							require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';	
							if(isset($v['setting']['fieldtype'])) {
								$field_type = $v['setting']['fieldtype'];
							}
							require MODEL_PATH.'add.sql.php';
							$v['tips'] = addslashes($v['tips']);
							$v['formattribute'] = addslashes($v['formattribute']);
							
							$v['setting'] = array2string($v['setting']);
							$v['modelid'] = $modelid;
							$v['siteid'] = $this->siteid;
							unset($v['fieldid']);
							
							$this->sitemodel_field_db->insert($v);
						}
					}
				}
				$this->public_cache();
				showmessage(L('operation_success'),'?m=content&c=sitemodel&a=init');
			}
		} else {
			pc_base::load_sys_class('form','',0);
			$show_validator = '';
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=content&c=sitemodel&a=add\', title:\''.L('add_model').'\', width:\'580\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_model'));
			include $this->admin_tpl('sitemodel_import');
		}
	}
	/**
	 * 检查表是否存在
	 */
	public function public_check_tablename() {
		$r = $this->db->table_exists(strip_tags($_GET['tablename']));
		if(!$r) echo '1';
	}
	/**
	 * 更新指定模型字段缓存
	 * 
	 * @param $modelid 模型id
	 */
	public function cache_field($modelid = 0) {
		$this->field_db = pc_base::load_model('sitemodel_field_model');
		$field_array = array();
		$fields = $this->field_db->select(array('modelid'=>$modelid,'disabled'=>$disabled),'*',100,'listorder ASC');
		foreach($fields as $_value) {
			$setting = string2array($_value['setting']);
			$_value = array_merge($_value,$setting);
			$field_array[$_value['field']] = $_value;
		}
		setcache('model_field_'.$modelid,$field_array,'model');
		return true;
	}
}
?>