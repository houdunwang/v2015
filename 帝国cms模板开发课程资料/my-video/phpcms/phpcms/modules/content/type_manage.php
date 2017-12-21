<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class type_manage extends admin {
	private $db,$category_db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('type_model');
		$this->siteid = $this->get_siteid();
		$this->model = getcache('model','commons');
		$this->category_db = pc_base::load_model('category_model');
	}
	
	public function init () {
		$datas = array();
		$result_datas = $this->db->listinfo(array('siteid'=>$this->siteid,'module'=>'content'),'listorder ASC,typeid DESC',$_GET['page']);
		$pages = $this->db->pages;
		foreach($result_datas as $r) {
			$r['modelname'] = $this->model[$r['modelid']]['name'];
			$datas[] = $r;
		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=content&c=type_manage&a=add\', title:\''.L('add_type').'\', width:\'780\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_type'));
		$this->cache();
		include $this->admin_tpl('type_list');
	}
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['module'] = 'content';
			if(empty($_POST['info']['name'])) showmessage(L("input").L('type_name'));
			$names = explode("\n", trim($_POST['info']['name']));
			$ids = $_POST['ids'];

			foreach ($names as $name) {
				$_POST['info']['name'] = $name;
				$typeid = $this->db->insert($_POST['info'],true);
				if(!empty($ids)) {
					foreach ($ids as $catid) {
						$r = $this->category_db->get_one(array('catid'=>$catid),'usable_type');
						if($r['usable_type']) {
							$usable_type = $r['usable_type'].$typeid.',';
						} else {
							$usable_type = ','.$typeid.',';
						}
						$this->category_db->update(array('usable_type'=>$usable_type),array('catid'=>$catid,'siteid'=>$this->siteid));
					}
				}
			}
			$this->cache();//更新类别缓存，按站点
			showmessage(L('add_success'), '', '', 'add');
		} else {
			$show_header = $show_validator = '';
			$categorys = $this->public_getsite_categorys();
			include $this->admin_tpl('type_add');
		}
	}
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$typeid = intval($_POST['typeid']);
			$this->db->update($_POST['info'],array('typeid'=>$typeid));
			$ids = $_POST['ids'];
			if(!empty($ids)) {
				foreach ($ids as $catid) {
					$r = $this->category_db->get_one(array('catid'=>$catid),'usable_type');
					if($r['usable_type']) {
						$usable_type = array();
						$usable_type_arr = explode(',', $r['usable_type']);
						foreach ($usable_type_arr as $_usable_type_arr) {
							if($_usable_type_arr && $_usable_type_arr!=$typeid) $usable_type[] = $_usable_type_arr;
						}
						$usable_type = ','.implode(',', $usable_type).',';
						$usable_type = $usable_type.$typeid.',';
					} else {
						$usable_type = ','.$typeid.',';
					}
					$this->category_db->update(array('usable_type'=>$usable_type),array('catid'=>$catid,'siteid'=>$this->siteid));
				}
			}
			//删除取消的
			$catids_string = $_POST['catids_string'];
			if($catids_string) {	
				$catids_string = explode(',', $catids_string);
				foreach ($catids_string as $catid) {
					$r = $this->category_db->get_one(array('catid'=>$catid),'usable_type');
					$usable_type = array();
					$usable_type_arr = explode(',', $r['usable_type']);
					foreach ($usable_type_arr as $_usable_type_arr) {
						if(!$_usable_type_arr || (!in_array($catid, $ids) && $typeid==$_usable_type_arr)) continue;
						$usable_type[] = $_usable_type_arr;
					}
					if(!empty($usable_type)) {
						$usable_type = ','.implode(',', $usable_type).',';
					} else {
						$usable_type = '';
					}
					$this->category_db->update(array('usable_type'=>$usable_type),array('catid'=>$catid,'siteid'=>$this->siteid));
				}
			}
			$this->category_cache();
			$this->cache();//更新类别缓存，按站点
			showmessage(L('update_success'), '', '', 'edit');
		} else {
			$show_header = $show_validator = '';
			$typeid = intval($_GET['typeid']);
			$r = $this->db->get_one(array('typeid'=>$typeid));
			extract($r);
			$categorys = $this->public_getsite_categorys($typeid);
			$catids_string = empty($this->catids_string) ? 0 : $this->catids_string = implode(',', $this->catids_string);
			include $this->admin_tpl('type_edit');
		}
	}
	public function delete() {
		$typeid = intval($_GET['typeid']);

		$categorys = $this->public_getsite_categorys($typeid);
		foreach ($this->catids_string as $catid) {
			$r = $this->category_db->get_one(array('catid'=>$catid),'usable_type');
			$usable_type = array();
			$usable_type_arr = explode(',', $r['usable_type']);
			foreach ($usable_type_arr as $_usable_type_arr) {
				if(!$_usable_type_arr || $typeid==$_usable_type_arr) continue;
				$usable_type[] = $_usable_type_arr;
			}
			if(!empty($usable_type)) {
				$usable_type = ','.implode(',', $usable_type).',';
			} else {
				$usable_type = '';
			}
			$this->category_db->update(array('usable_type'=>$usable_type),array('catid'=>$catid,'siteid'=>$this->siteid));
		}
		$this->db->delete(array('typeid'=>$_GET['typeid']));
		$this->cache();//更新类别缓存，按站点
		exit('1');
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('typeid'=>$id));
			}
			$this->cache();//更新类别缓存，按站点
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}
	
	public function cache() {
		$datas = array();
		$result_datas = $this->db->select(array('siteid'=>$this->siteid,'module'=>'content'),'*',1000,'listorder ASC,typeid ASC');
		foreach($result_datas as $_key=>$_value) {
			$datas[$_value['typeid']] = $_value;
		}
		setcache('type_content_'.$this->siteid,$datas,'commons');
		$this->category_cache();
		return true;
	}
	/**
	 * 选择可用栏目
	 */
	public function public_getsite_categorys($typeid = 0) {
		$siteid = $this->siteid;
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		$this->catids_string = array();
		foreach($this->categorys as $r) {
			if($r['siteid']!=$siteid || $r['type']!=0) continue;
			if($r['child']) {
				$r['checkbox'] = '';
				$r['style'] = 'color:#8A8A8A;';
			} else {
				$checked = '';
				if($typeid && $r['usable_type']) {
					$usable_type = explode(',', $r['usable_type']);
					if(in_array($typeid, $usable_type)) {
						$checked = 'checked';
						$this->catids_string[] = $r['catid'];
					}
				}
				$r['checkbox'] = "<input type='checkbox' name='ids[]' value='{$r[catid]}' {$checked}>";
				$r['style'] = '';
			}
			$categorys[$r['catid']] = $r;
		}
		$str  = "<tr>
					<td align='center'>\$checkbox</td>
					<td style='\$style'>\$spacer\$catname</td>
				</tr>";
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		return $categorys;
	}
	/**
	 * 更新栏目缓存
	 */
	private function category_cache() {
		$categorys = array();
		$this->categorys = $this->category_db->select(array('siteid'=>$this->siteid, 'module'=>'content'),'*',10000,'listorder ASC');
		foreach($this->categorys as $r) {
			unset($r['module']);
			$setting = string2array($r['setting']);
			$r['create_to_html_root'] = $setting['create_to_html_root'];
			$r['ishtml'] = $setting['ishtml'];
			$r['content_ishtml'] = $setting['content_ishtml'];
			$r['category_ruleid'] = $setting['category_ruleid'];
			$r['show_ruleid'] = $setting['show_ruleid'];
			$r['workflowid'] = $setting['workflowid'];
			$r['isdomain'] = '0';
			if(strpos($r['url'], 'http://') === false) {
				$r['url'] = siteurl($r['siteid']).$r['url'];
			} elseif ($r['ishtml']) {
				$r['isdomain'] = '1';
			}
			$categorys[$r['catid']] = $r;
		}
		setcache('category_content_'.$this->siteid,$categorys,'commons');
		return true;
	}
}
?>