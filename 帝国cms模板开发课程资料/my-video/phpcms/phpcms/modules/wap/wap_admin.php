<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
class wap_admin extends admin {
	private $db,$type_db;
	function __construct() {
		parent::__construct();
		$this->sites = pc_base::load_app_class('sites','admin');
		$this->db = pc_base::load_model('wap_model');
		$this->type_db = pc_base::load_model('wap_type_model');
	}
	
	function init() {
		$infos = $this->db->select();
		$show_dialog = true;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=wap&c=wap_admin&a=add\', title:\''.L('add_site').'\', width:\'400\', height:\'550\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('wap_add_site'));		
		include $this->admin_tpl('m_list');
	}
	
	function edit() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$domain = trim($_POST['domain']);
			$setting = array2string($_POST['setting']);
			$this->db->update(array('sitename'=>$sitename,'logo'=>$logo,'domain'=>$domain,'setting'=>$setting), array('siteid'=>$siteid));
			$this->wap_site_cache();
			showmessage(L('operation_success'), '', '', 'edit');
		} else {
			$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitelist = $this->sites->get_list();			
			$info = $this->db->get_one(array('siteid'=>$siteid));
			if($info) {
				extract($info);	
				extract(string2array($setting));	
			}
			$show_header = true;
			include $this->admin_tpl('m_edit');			
		}
	}
	
	function add() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			if($this->db->get_one(array('siteid'=>$siteid))) {
				showmessage(L('wap_add_samesite_error'),HTTP_REFERER);
			}
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$domain = trim($_POST['domain']);
			$setting = array2string($_POST['setting']);
			$return_id = $this->db->insert(array('siteid'=>$siteid,'sitename'=>$sitename,'logo'=>$logo,'domain'=>$domain,'setting'=>$setting),'1');
			$this->wap_site_cache();
			showmessage(L('operation_success'), '', '', 'add');
		} else {
			$sitelists = array();
			$current_siteid = get_siteid();
			$sitelists = $this->sites->get_list();
			if($_SESSION['roleid'] == '1') {
				foreach($sitelists as $key=>$v) $sitelist[$key] = $v['name'];
			} else {
				$sitelist[$current_siteid] = $sitelists[$current_siteid]['name'];
			}			
			$show_header = true;
			include $this->admin_tpl('m_add');			
		}		
	}
	
	function delete() {
		$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		if($siteid == 1) showmessage(L('wap_permission_denied_del'),HTTP_REFERER);
		$this->db->delete(array('siteid'=>$siteid));
		$this->type_db->delete(array('siteid'=>$siteid));
		$this->wap_site_cache();
		showmessage(L('wap_del_succ'),HTTP_REFERER);
	}
	
	function public_status() {
		 $status = intval($_GET['status']) && intval($_GET['status'])== 1 ? '1' : '0';
		 $siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		 $this->db->update(array('status'=>$status), array('siteid'=>$siteid));
		 $this->wap_site_cache();
		 showmessage(L('wap_change_status'),HTTP_REFERER);
	}
	
	function type_manage() {
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';		
		$siteid = intval($_GET['siteid']);
		if($siteid==0) showmessage(L('parameter_error'),HTTP_REFERER);
		if($_POST['dosubmit']) {
			$info['typename'] = $_POST['info']['typename'] ? $_POST['info']['typename'] : showmessage(L('wap_empty_type'),HTTP_REFERER);
			$info['cat'] = $_POST['info']['cat'] ? $_POST['info']['cat'] : showmessage(L('wap_empty_bound_type'),HTTP_REFERER);
			$info['listorder'] = $_POST['listorder'];
			$info['siteid'] = $siteid;
			if($this->type_db->get_one(array('cat'=>$info['cat'],'siteid'=>$siteid))) {
				$this->type_cache($siteid);
				showmessage(L('wap_repeat_bound_error'),HTTP_REFERER);
			} else {
				$this->type_db->insert($info);
				showmessage(L('operation_success'),HTTP_REFERER);					
			}
	
		} else {
			$result = $this->type_db->select(array('siteid'=>$siteid),'*','','listorder ASC,typeid DESC');
			foreach($result as $r) {
				$r['add_new'] = $r['parentid']==0 ? '<a href="#" onclick="add_tr(this,\''.$r['typeid'].'\',\''.$r['siteid'].'\');">'.L('wap_add_subtype').'</a>' : '';
				$r['select_cat'] = form::select_category('',$r[cat],'name="cat['.$r['typeid'].']"',L('wap_type_bound'),0,0,0,$siteid);
				$array[$r['typeid']] = $r;
			}

			$str  = "<tr>
						<td align='center'><input type='checkbox' value='\$typeid' name='ids[]' class='inputcheckbox'></td>			
						<td align='center'><input name='listorders[\$typeid]' type='text' size='3' value='\$listorder' class='input-text'></td>
						<td align='center'>\$typeid</td>
						<td align='left'>\$spacer<input name='typename[\$typeid]' type='text' value='\$typename' class='input-text' size='10' >\$add_new</td>
						<td align='center'>\$select_cat</td>
					</tr>";
			$tree->init($array);
			$wap_type = $tree->get_tree(0, $str);	
			$show_validator = true;					
			include $this->admin_tpl('type_manage');
		}		
	}
	
	function type_edit() {
		$siteid = intval($_GET['siteid']);
		if($_POST['dosubmit']) {
			$typename = $_POST['typename'];			
			foreach ($typename as $typeid=>$in) {
				$this->type_db->update(array(
							  'typename'=>$_POST['typename'][$typeid],
							  'cat'=>$_POST['cat'][$typeid],
							  'listorder'=>$_POST['listorders'][$typeid],
							 ),array('typeid'=>$typeid));			
			}
			
			$addtype = $_POST['addtype'];
			$addcat = $_POST['addcat'];
			$addorder = $_POST['addorder'];

			if(is_array($addtype) && !empty($addtype)) {
				foreach ($addtype as $_k=>$_v) {
					foreach ($_v as $_s=>$infos) {
						$info['typename'] = $infos;
						$info['parentid'] = $_k;
						$info['siteid'] = $siteid;
						$info['cat'] = $addcat[$_k][$_s];
						$info['listorder'] = $addorder[$_k][$_s];
						if($this->type_db->get_one(array('cat'=>$info['cat'],'siteid'=>$siteid))) {
							showmessage($info['typename'].L('wap_repeat_bound'),HTTP_REFERER);
						} else {
							$this->type_db->insert($info);
						}											
					}
					unset($info);
				}
			}
			$this->type_cache($siteid);
			showmessage(L('operation_success'),HTTP_REFERER);	
		}
	}
	public function type_delete() {
		if($_POST['dosubmit']) {
			if(is_array($_POST['ids']) && !empty($_POST['ids'])) {
				foreach ($_POST['ids'] as $id) {
					if($this->type_db->get_one(array('parentid'=>$id))) {
						showmessage(L('wap_type_del_error'),HTTP_REFERER);
					} else {
						$this->type_db->delete(array('typeid'=>$id));
					}
				}
			}
			showmessage(L('operation_success'),HTTP_REFERER);			
		}
	}
	public function public_show_cat_ajx() {
		$parentid = intval($_GET['parentid']);
		$siteid = intval($_GET['siteid']);
		echo form::select_category('',0,'name="addcat['.$parentid.'][]"',L('wap_type_bound'),0,0,0,$siteid);
	}
	
	private function wap_site_cache() {
		$datas = $this->db->select();
		$array = array();
		foreach ($datas as $r) {
			$array[$r['siteid']] = $r;
		}
		setcache('wap_site', $array,'wap');		
	}
	
	private function type_cache($siteid) {
		$siteid = intval($siteid);
		$datas = $this->type_db->select('','*',10000,'listorder ASC');
		$array = array();
		foreach ($datas as $r) {
			$array[$r['typeid']] = $r;
		}
		setcache('wap_type', $array,'wap');		
	}
	
}
?>