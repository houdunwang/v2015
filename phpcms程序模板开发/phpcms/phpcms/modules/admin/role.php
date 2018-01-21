<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
class role extends admin {
	private $db, $priv_db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('admin_role_model');
		$this->priv_db = pc_base::load_model('admin_role_priv_model');
		$this->op = pc_base::load_app_class('role_op');
	}
	
	/**
	 * 角色管理列表
	 */
	public function init() {
		$infos = $this->db->select($where = '', $data = '*', $limit = '', $order = 'listorder DESC, roleid DESC', $group = '');
		
		include $this->admin_tpl('role_list');
	}
	
	/**
	 * 添加角色
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			if(!is_array($_POST['info']) || empty($_POST['info']['rolename'])){
				showmessage(L('operation_failure'));
			}
			if($this->op->checkname($_POST['info']['rolename'])){
				showmessage(L('role_duplicate'));
			}
			$insert_id = $this->db->insert($_POST['info'],true);
			$this->_cache();
			if($insert_id){
				showmessage(L('operation_success'),'?m=admin&c=role&a=init');
			}
		} else {
			include $this->admin_tpl('role_add');
		}
		
	}
	
	/**
	 * 编辑角色
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$_POST['roleid'] = intval($_POST['roleid']);
			if(!is_array($_POST['info']) || empty($_POST['info']['rolename'])){
				showmessage(L('operation_failure'));
			}
			$this->db->update($_POST['info'],array('roleid'=>$_POST['roleid']));
			$this->_cache();
			showmessage(L('operation_success'),'?m=admin&c=role');
		} else {					
			$info = $this->db->get_one(array('roleid'=>$_GET['roleid']));
			extract($info);		
			include $this->admin_tpl('role_edit');		
		}
	}
	
	/**
	 * 删除角色
	 */
	public function delete() {
		$roleid = intval($_GET['roleid']);
		if($roleid == '1') showmessage(L('this_object_not_del'), HTTP_REFERER);
		$this->db->delete(array('roleid'=>$roleid));
		$this->priv_db->delete(array('roleid'=>$roleid));
		$this->_cache();
		showmessage(L('role_del_success'));
	}
	/**
	 * 更新角色排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $roleid => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('roleid'=>$roleid));
			}
			showmessage(L('operation_success'));
		} else {
			showmessage(L('operation_failure'));
		}
	}
	
	/**
	 * 角色权限设置
	 */
	public function role_priv() {
		$this->menu_db = pc_base::load_model('menu_model');
		$siteid = $siteid ? $siteid : self::get_siteid(); 
		if(isset($_POST['dosubmit'])){
			if (is_array($_POST['menuid']) && count($_POST['menuid']) > 0) {
			
				$this->priv_db->delete(array('roleid'=>$_POST['roleid'],'siteid'=>$_POST['siteid']));
				$menuinfo = $this->menu_db->select('','`id`,`m`,`c`,`a`,`data`');
				foreach ($menuinfo as $_v) $menu_info[$_v[id]] = $_v;
				foreach($_POST['menuid'] as $menuid){
					$info = array();
					$info = $this->op->get_menuinfo(intval($menuid),$menu_info);
					$info['roleid'] = $_POST['roleid'];
					$info['siteid'] = $_POST['siteid'];
					$this->priv_db->insert($info);
				}
			} else {
				$this->priv_db->delete(array('roleid'=>$_POST['roleid'],'siteid'=>$_POST['siteid']));
			}
			$this->_cache();	
			showmessage(L('operation_success'), HTTP_REFERER);

		} else {
			$siteid = intval($_GET['siteid']);
			$roleid = intval($_GET['roleid']);
			if ($siteid) {
				$menu = pc_base::load_sys_class('tree');
				$menu->icon = array('│ ','├─ ','└─ ');
				$menu->nbsp = '&nbsp;&nbsp;&nbsp;';
				$result = $this->menu_db->select();
				$priv_data = $this->priv_db->select(); //获取权限表数据
				$modules = 'admin,system';
				foreach ($result as $n=>$t) {
					$result[$n]['cname'] = L($t['name'],'',$modules);
					$result[$n]['checked'] = ($this->op->is_checked($t,$_GET['roleid'],$siteid, $priv_data))? ' checked' : '';
					$result[$n]['level'] = $this->op->get_level($t['id'],$result);
					$result[$n]['parentid_node'] = ($t['parentid'])? ' class="child-of-node-'.$t['parentid'].'"' : '';
				}
				$str  = "<tr id='node-\$id' \$parentid_node>
							<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$cname</td>
						</tr>";
			
				$menu->init($result);
				$categorys = $menu->get_tree(0, $str);
			}
			$show_header = true;
			$show_scroll = true;
			include $this->admin_tpl('role_priv');
		}
	}
	
	public function priv_setting() {
		$sites = pc_base::load_app_class('sites', 'admin');
		$sites_list = $sites->get_list();
		$roleid = intval($_GET['roleid']);
		include $this->admin_tpl('role_priv_setting');
		
	}

	/**
	 * 更新角色状态
	 */
	public function change_status(){
		$roleid = intval($_GET['roleid']);
		$disabled = intval($_GET['disabled']);
		$this->db->update(array('disabled'=>$disabled),array('roleid'=>$roleid));
		$this->_cache();
		showmessage(L('operation_success'),'?m=admin&c=role');
	}
	/**
	 * 成员管理
	 */
	public function member_manage() {
		$this->admin_db = pc_base::load_model('admin_model');
		$roleid = intval($_GET['roleid']);
		$roles = getcache('role','commons');
		$infos = $this->admin_db->select(array('roleid'=>$roleid));
		include $this->admin_tpl('admin_list');
	}
		
	/**
	 * 设置栏目权限
	 */
	public function setting_cat_priv() {
		$roleid = isset($_GET['roleid']) && intval($_GET['roleid']) ? intval($_GET['roleid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$op = isset($_GET['op']) && intval($_GET['op']) ? intval($_GET['op']) : '';
		switch ($op) {
			case 1:
			$siteid = isset($_GET['siteid']) && intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			pc_base::load_app_class('role_cat', '', 0);
			$category = role_cat::get_category($siteid);
			//获取角色当前权限设置
			$priv = role_cat::get_roleid($roleid, $siteid);
			//加载tree
			$tree = pc_base::load_sys_class('tree');
			$categorys = array();
			foreach ($category as $k=>$v) {
				if ($v['type'] == 1) {
					$v['disabled'] = 'disabled';
					$v['init_check'] = '';
					$v['add_check'] = '';
					$v['delete_check'] = '';
					$v['listorder_check'] = '';
					$v['push_check'] = '';
					$v['move_check'] = '';
				} else {
					$v['disabled'] = '';
					
					$v['add_check'] = isset($priv[$v['catid']]['add']) ? 'checked' : '';
					$v['delete_check'] = isset($priv[$v['catid']]['delete']) ? 'checked' : '';
					$v['listorder_check'] = isset($priv[$v['catid']]['listorder']) ? 'checked' : '';
					$v['push_check'] = isset($priv[$v['catid']]['push']) ? 'checked' : '';
					$v['move_check'] = isset($priv[$v['catid']]['remove']) ? 'checked' : '';
					$v['edit_check'] = isset($priv[$v['catid']]['edit']) ? 'checked' : '';
				}
				$v['init_check'] = isset($priv[$v['catid']]['init']) ? 'checked' : '';
				$category[$k] = $v;
			}
			$show_header = true;
			$str = "<tr>
					<td align='center'><input type='checkbox'  value='1' onclick='select_all(\$catid, this)' ></td>
				  <td>\$spacer\$catname</td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$init_check  value='init' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$add_check value='add' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$edit_check value='edit' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$delete_check  value='delete' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$listorder_check value='listorder' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$push_check value='push' ></td>
				  <td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$move_check value='remove' ></td>
			  </tr>";
			
			$tree->init($category);
			$categorys = $tree->get_tree(0, $str);
			include $this->admin_tpl('role_cat_priv_list');
		break;
		
		case 2:
			$siteid = isset($_GET['siteid']) && intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			pc_base::load_app_class('role_cat', '', 0);
			role_cat::updata_priv($roleid, $siteid, $_POST['priv']);
			showmessage(L('operation_success'),'?m=admin&c=role&a=init', '', 'edit');
			break;
		
		default:
			$sites = pc_base::load_app_class('sites', 'admin');
			$sites_list = $sites->get_list();
			include $this->admin_tpl('role_cat_priv');
		break;
		}
	}	
	/**
	 * 角色缓存
	 */
	private function _cache() {

		$infos = $this->db->select(array('disabled'=>'0'), $data = '`roleid`,`rolename`', '', 'roleid ASC');
		$role = array();
		foreach ($infos as $info){
			$role[$info['roleid']] = $info['rolename'];
		}
		$this->_cache_siteid($role);
		setcache('role', $role,'commons');
		return $infos;
	}
	
	/**
	 * 缓存站点数据
	 */
	private function _cache_siteid($role) {
		$sitelist = array();
		foreach($role as $n=>$r) {
			$sitelists = $this->priv_db->select(array('roleid'=>$n),'siteid', '', 'siteid');
			foreach($sitelists as $site) {
				foreach($site as $v){
					$sitelist[$n][] = intval($v);
				}
			}
		}
		if(is_array($sitelist)) {
			$sitelist = @array_map("array_unique", $sitelist);
			setcache('role_siteid', $sitelist,'commons');
		}								
		return $sitelist;
	}
	
}
?>