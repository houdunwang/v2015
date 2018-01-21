<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class tag extends admin {
	private $db, $dbsource;
	public function __construct() {
		$this->db = pc_base::load_model('tag_model');
		$this->dbsource = pc_base::load_model('dbsource_model');
		parent::__construct();
	}
	
	/**
	 * 标签向导列表
	 */
	public function init() {
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=tag&c=tag&a=add\', title:\''.L('add_tag').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_tag'));
		$page = isset($_POST['page']) && intval($_POST['page']) ? intval($_POST['page']) : 1;
		$list = $this->db->listinfo('','id desc', $page, 20);
		$pages = $this->db->pages;
		include $this->admin_tpl('tag_list');
	}

	/**
	 * 添加标签向导
	 */
	public function add() {
		pc_base::load_app_func('global', 'dbsource');
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'));
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
			$num = isset($_POST['num']) && intval($_POST['num']) ? intval($_POST['num']) : 0;
			$type = isset($_POST['type']) && intval($_POST['type']) ? intval($_POST['type']) : 0;
			$ac = isset($_GET['ac']) && !empty($_GET['ac']) ? trim($_GET['ac']) : '';
			//检查名称是否已经存在
			if ($this->db->get_one(array('name'=>$name)))  {
				showmessage(L('name').L('exists'));
			}
			$siteid = $this->get_siteid();
			if ($type == '1') { //自定义SQL
				$sql = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'));
				$data['sql'] = $sql;
				$tag = '{pc:get sql="'.$sql.'" ';
				if ($cache) {
					$tag .= 'cache="'.$cache.'" ';
				}
				if ($_POST['page']) {
					$tag .= 'page="'.$_POST['page'].'" ';
				}
				if ($_POST['dbsource']) {
					$data['dbsource'] = $_POST['dbsource'];
					$tag .= 'dbsource= "'.$_POST['dbsource'].'" ';
				}
				if ($_POST['return']) {
					$tag .= 'return="'.$_POST['return'].'"';
				}
				$tag .= '}';
			} elseif ($type == 0) { //模型配置
				$module = isset($_POST['module']) && trim($_POST['module']) ? trim($_POST['module']) : showmessage(L('please_select_model'));
				$action = isset($_POST['action']) && trim($_POST['action']) ? trim($_POST['action']) : showmessage(L('please_select_action'));
				$html = pc_tag_class($module);
				$data = array();
				$tag = '{pc:'.$module.' action="'.$action.'" ';
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
						$tag .= $key.'="'.$$key.'" ';
						$data[$key] = $$key;
					}
				}
				if ($_POST['page']) {
					$tag .= 'page="'.$_POST['page'].'" ';
				}
				if ($num) {
					$tag .= ' num="'.$num.'" ';
				}
				if ($_POST['return']) {
					$tag .= ' return="'.$_POST['return'].'" ';
				}
				if ($cache) {
					$tag .= ' cache="'.$cache.'" ';
				}
				$tag .= '}';
			} else { //碎片
				$data = isset($_POST['block']) && trim($_POST['block']) ? trim($_POST['block']) : showmessage(L('block_name_not_empty'));
				$tag = '{pc:block pos="'.$data.'"}';
			}
			$tag .= "\n".'{loop $data $n $r}'."\n".'<li><a href="{$r[\'url\']}" title="{$r[\'title\']}">{$r[\'title\']}</a></li>'."\n".'{/loop}'."\n".'{/pc}';
			$tag = new_addslashes($tag);
			$data = is_array($data) ? array2string($data) : $data;
			$this->db->insert(array('siteid'=>$siteid, 'tag'=>$tag, 'name'=>$name, 'type'=>$type, 'module'=>$module, 'action'=>$action, 'data'=>$data, 'page'=>$_POST['page'], 'return'=>$_POST['return'], 'cache'=>$cache, 'num'=>$num));
			if ($ac=='js') {
				include $this->admin_tpl('tag_show');
			} else {
				showmessage('', '', '', 'add');
			}
		} else {
			pc_base::load_sys_class('form','',0);
			$modules = array_merge(array(''=>L('please_select')),pc_base::load_config('modules'));
			$show_header = $show_validator = true;
			$type = isset($_GET['type']) && intval($_GET['type']) ? intval($_GET['type']) : 0;
			$siteid = $this->get_siteid();
			$dbsource_data = $dbsource = array();
			$dbsource[] = L('please_select');
			$dbsource_data = $this->dbsource->select(array('siteid'=>$siteid), 'name');
			foreach ($dbsource_data as $dbs) {
				$dbsource[$dbs['name']] = $dbs['name'];
			}
			$ac = isset($_GET['ac']) && !empty($_GET['ac']) ? trim($_GET['ac']) : '';
			$module = isset($_GET['module']) && trim($_GET['module']) ? trim($_GET['module']) : '';
			$action = isset($_GET['action']) && trim($_GET['action']) ? trim($_GET['action']) : '';
			if ($module) $html = pc_tag_class($module);
			pc_base::load_app_func('global','template');
			include $this->admin_tpl('tag_add');
		}
	}

	/**
	 * 修改标签向导
	 */
	public function edit() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :  showmessage(L('illegal_parameters'), HTTP_REFERER);
		if (!$edit_data = $this->db->get_one(array('id'=>$id))) {
			showmessage(L('notfound'));
		}
		pc_base::load_app_func('global', 'dbsource');
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'));
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
			$num = isset($_POST['num']) && intval($_POST['num']) ? intval($_POST['num']) : 0;
			$type = isset($_POST['type']) && intval($_POST['type']) ? intval($_POST['type']) : 0;
			//检查名称是否已经存在
			if ($edit_data['name'] != $name) {
				if ($this->db->get_one(array('name'=>$name), 'id'))  {
					showmessage(L('name').L('exists'));
				}
			}
			$siteid = $this->get_siteid();
			if ($type == '1') { //自定义SQL
				$sql = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'));
				$data['sql'] = $sql;
				$tag = '{pc:get sql="'.$sql.'" ';
				if ($cache) {
					$tag .= 'cache="'.$cache.'" ';
				}
				if ($_POST['page']) {
					$tag .= 'page="'.$_POST['page'].'" ';
				}
				if ($_POST['dbsource']) {
					$data['dbsource'] = $_POST['dbsource'];
					$tag .= 'dbsource= "'.$_POST['dbsource'].'" ';
				}
				if ($_POST['return']) {
					$tag .= 'return="'.$_POST['return'].'"';
				}
				$tag .= '}';
			} elseif ($type == 0) { //模型配置
				$module = isset($_POST['module']) && trim($_POST['module']) ? trim($_POST['module']) : showmessage(L('please_select_model'));
				$action = isset($_POST['action']) && trim($_POST['action']) ? trim($_POST['action']) : showmessage(L('please_select_action'));
				$html = pc_tag_class($module);
				$data = array();
				$tag = '{pc:'.$module.' action="'.$action.'" ';
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
						$tag .= $key.'="'.$$key.'" ';
						$data[$key] = $$key;
					}
				}
				if ($_POST['page']) {
					$tag .= 'page="'.$_POST['page'].'" ';
				}
				if ($num) {
					$tag .= ' num="'.$num.'" ';
				}
				if ($_POST['return']) {
					$tag .= ' return="'.$_POST['return'].'" ';
				}
				if ($cache) {
					$tag .= ' cache="'.$cache.'" ';
				}
				$tag .= '}';
			} else { //碎片
				$data = isset($_POST['block']) && trim($_POST['block']) ? trim($_POST['block']) : showmessage(L('block_name_not_empty'));
				$tag = '{pc:block pos="'.$data.'"}';
			}
			$tag .= "\n".'{loop $data $n $r}'."\n".'<li><a href="{$r[\'url\']}" title="{$r[\'title\']}">{$r[\'title\']}</a></li>'."\n".'{/loop}'."\n".'{/pc}';
			$tag = new_addslashes($tag);
			$data = is_array($data) ? array2string($data) : $data;
			$this->db->update(array('siteid'=>$siteid, 'tag'=>$tag, 'name'=>$name, 'type'=>$type, 'module'=>$module, 'action'=>$action, 'data'=>$data, 'page'=>$_POST['page'], 'return'=>$_POST['return'], 'cache'=>$cache, 'num'=>$num), array('id'=>$id));
			showmessage('', '', '', 'edit');
		} else {
			pc_base::load_sys_class('form','',0);
			$modules = array_merge(array(''=>L('please_select')),pc_base::load_config('modules'));
			$show_header = $show_validator = true;
			$type = isset($_GET['type']) && intval($_GET['type']) ? intval($_GET['type']) : $edit_data['type'];
			$siteid = $this->get_siteid();
			$dbsource_data = $dbsource = array();
			$dbsource[] = L('please_select');
			$dbsource_data = $this->dbsource->select(array('siteid'=>$siteid), 'name');
			foreach ($dbsource_data as $dbs) {
				$dbsource[$dbs['name']] = $dbs['name'];
			}
			$module = isset($_GET['module']) && trim($_GET['module']) ? trim($_GET['module']) : $edit_data['module'];
			$action = isset($_GET['action']) && trim($_GET['action']) ? trim($_GET['action']) : $edit_data['action'];
			if ($edit_data['type'] == 0 || $edit_data['type'] == 1) $form_data = string2array($edit_data['data']);
			if ($module) $html = pc_tag_class($module);
			pc_base::load_app_func('global','template');
			include $this->admin_tpl('tag_edit');
		}
	}
	
	/**
	 * 标签向导列表
	 */
	public function lists() {
		$page = isset($_POST['page']) && intval($_POST['page']) ? intval($_POST['page']) : 1;
		$list = $this->db->listinfo('','id desc', $page, 20);
		$pages = $this->db->pages;
		include $this->admin_tpl('tag_lists');
	}

	/**
	 * 删除标签向导
	 */
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

	/**
	 * 检验是否重名
	 */
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
?>