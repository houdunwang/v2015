<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
class position extends admin {
	private $db, $db_data, $db_content;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('position_model');
		$this->db_data = pc_base::load_model('position_data_model');
		$this->db_content = pc_base::load_model('content_model');			
		$this->sites = pc_base::load_app_class('sites');
	}
	
	public function init() {
			$infos = array();
			$where = '';
			$current_siteid = self::get_siteid();
			$category = getcache('category_content_'.$current_siteid,'commons');
			$model = getcache('model','commons');
			$where = "`siteid`='$current_siteid' OR `siteid`='0'";
			$page = $_GET['page'] ? $_GET['page'] : '1';
			$infos = $this->db->listinfo($where, $order = 'listorder DESC,posid DESC', $page, $pagesize = 20);
			$pages = $this->db->pages;
			$show_dialog = true;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=position&a=add\', title:\''.L('posid_add').'\', width:\'500\', height:\'360\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('posid_add'));
 			include $this->admin_tpl('position_list');
	}
	
	/**
	 * 推荐位添加
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			if(!is_array($_POST['info']) || empty($_POST['info']['name'])){
				showmessage(L('operation_failure'));
			}
			$_POST['info']['siteid'] = intval($_POST['info']['modelid']) ? get_siteid() : 0;
			$_POST['info']['listorder'] = intval($_POST['info']['listorder']);
			$_POST['info']['maxnum'] = intval($_POST['info']['maxnum']);
			$_POST['info']['thumb'] = $_POST['info']['thumb'];
			$insert_id = $this->db->insert($_POST['info'],true);
			$this->_set_cache();
			if($insert_id){
				showmessage(L('operation_success'), '', '', 'add');
			}
		} else {
			pc_base::load_sys_class('form');
			$this->sitemodel_db = pc_base::load_model('sitemodel_model');
			$sitemodel = $sitemodel = array();
			$sitemodel = getcache('model','commons');
			foreach($sitemodel as $value){
				if($value['siteid'] == get_siteid())$modelinfo[$value['modelid']]=$value['name'];
			}			
			$show_header = $show_validator = true;
			include $this->admin_tpl('position_add');
		}
		
	}
	
	/**
	 * 推荐位编辑
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$_POST['posid'] = intval($_POST['posid']);
			if(!is_array($_POST['info']) || empty($_POST['info']['name'])){
				showmessage(L('operation_failure'));
			}
			$_POST['info']['siteid'] = intval($_POST['info']['modelid']) ? get_siteid() : 0;
			$_POST['info']['listorder'] = intval($_POST['info']['listorder']);
			$_POST['info']['maxnum'] = intval($_POST['info']['maxnum']);			
			$_POST['info']['thumb'] = $_POST['info']['thumb'];			
			$this->db->update($_POST['info'],array('posid'=>$_POST['posid']));
			$this->_set_cache();
			showmessage(L('operation_success'), '', '', 'edit');
		} else {
			$info = $this->db->get_one(array('posid'=>intval($_GET['posid'])));
			extract($info);
			pc_base::load_sys_class('form');
			$this->sitemodel_db = pc_base::load_model('sitemodel_model');
			$sitemodel = $sitemodel = array();
			$sitemodel = getcache('model','commons');
			foreach($sitemodel as $value){
				if($value['siteid'] == get_siteid())$modelinfo[$value['modelid']]=$value['name'];
			}
			$show_validator = $show_header = $show_scroll = true;
			include $this->admin_tpl('position_edit');
		}

	}
	
	/**
	 * 推荐位删除
	 */
	public function delete() {
		$posid = intval($_GET['posid']);
		$this->db->delete(array('posid'=>$posid));
		$this->_set_cache();
		showmessage(L('posid_del_success'),'?m=admin&c=position');
	}
	
	/**
	 * 推荐位排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $posid => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('posid'=>$posid));
			}
			$this->_set_cache();
			showmessage(L('operation_success'),'?m=admin&c=position');
		} else {
			showmessage(L('operation_failure'),'?m=admin&c=position');
		}
	}
	
	/**
	 * 推荐位文章统计
	 * @param $posid 推荐位ID
	 */
	public function content_count($posid) {
		$posid = intval($posid);
		$where = array('posid'=>$posid);
		$infos = $this->db_data->get_one($where, $data = 'count(*) as count');
		return $infos['count'];
	}
	
	/**
	 * 推荐位文章列表
	 */
	public function public_item() {	
		if(isset($_POST['dosubmit'])) {
			$items = count($_POST['items']) > 0  ? $_POST['items'] : showmessage(L('posid_select_to_remove'),HTTP_REFERER);
			if(is_array($items)) {
				$sql = array();
				foreach ($items as $item) {
					$_v = explode('-', $item);
					$sql['id'] = $_v[0];
					$sql['modelid']= $_v[1];
					$sql['posid'] = intval($_POST['posid']);
					$this->db_data->delete($sql);
					$this->content_pos($sql['id'],$sql['modelid']);		
				}
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$posid = intval($_GET['posid']);
			$MODEL = getcache('model','commons');
			$siteid = $this->get_siteid();
			$CATEGORY = getcache('category_content_'.$siteid,'commons');
			$page = $_GET['page'] ? $_GET['page'] : '1';
			$pos_arr = $this->db_data->listinfo(array('posid'=>$posid,'siteid'=>$siteid),'listorder DESC', $page, $pagesize = 20);
			$pages = $this->db_data->pages;
			$infos = array();
			foreach ($pos_arr as $_k => $_v) {
				$r = string2array($_v['data']);
				$r['catname'] = $CATEGORY[$_v['catid']]['catname'];
				$r['modelid'] = $_v['modelid'];
				$r['posid'] = $_v['posid'];
				$r['id'] = $_v['id'];
				$r['listorder'] = $_v['listorder'];
				$r['catid'] = $_v['catid'];
				$r['url'] = go($_v['catid'], $_v['id']);
				$key = $r['modelid'].'-'.$r['id'];
				$infos[$key] = $r;
				
			}
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=position&a=add\', title:\''.L('posid_add').'\', width:\'500\', height:\'300\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('posid_add'));			
			include $this->admin_tpl('position_items');			
		}
	}
	/**
	 * 推荐位文章管理
	 */
	public function public_item_manage() {
		if(isset($_POST['dosubmit'])) {
			$posid = intval($_POST['posid']);
			$modelid = intval($_POST['modelid']);	
			$id= intval($_POST['id']);
			$pos_arr = $this->db_data->get_one(array('id'=>$id,'posid'=>$posid,'modelid'=>$modelid));
			$array = string2array($pos_arr['data']);
			$array['inputtime'] = strtotime($_POST['info']['inputtime']);
			$array['title'] = trim($_POST['info']['title']);
			$array['thumb'] = trim($_POST['info']['thumb']);
			$array['description'] = trim($_POST['info']['description']);
			$thumb = $_POST['info']['thumb'] ? 1 : 0;
			$array = array('data'=>array2string($array),'synedit'=>intval($_POST['synedit']),'thumb'=>$thumb);
			$this->db_data->update($array,array('id'=>$id,'posid'=>$posid,'modelid'=>$modelid));
			showmessage(L('operation_success'),'','','edit');
		} else {
			$posid = intval($_GET['posid']);
			$modelid = intval($_GET['modelid']);	
			$id = intval($_GET['id']);		
			if($posid == 0 || $modelid == 0) showmessage(L('linkage_parameter_error'), HTTP_REFERER);
			$pos_arr = $this->db_data->get_one(array('id'=>$id,'posid'=>$posid,'modelid'=>$modelid));
			extract(string2array($pos_arr['data']));
			$synedit = $pos_arr['synedit'];
			$show_validator = true;
			$show_header = true;		
			include $this->admin_tpl('position_item_manage');			
		}
	
	}
	/**
	 * 推荐位文章排序
	 */
	public function public_item_listorder() {
		if(isset($_POST['posid'])) {
			foreach($_POST['listorders'] as $_k => $listorder) {
				$pos = array();
				$pos = explode('-', $_k);
				$this->db_data->update(array('listorder'=>$listorder),array('id'=>$pos[1],'catid'=>$pos[0],'posid'=>$_POST['posid']));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
			
		} else {
			showmessage(L('operation_failure'),HTTP_REFERER);
		}
	}
	/**
	 * 推荐位添加栏目加载
	 */
	public function public_category_load() {
		$modelid = intval($_GET['modelid']);
		pc_base::load_sys_class('form');
		$category = form::select_category('','','name="info[catid]"',L('please_select_parent_category'),$modelid);
		echo $category;
	}
	
	private function _set_cache() {
		$infos = $this->db->select('','*',1000,'listorder DESC');
		$positions = array();
		foreach ($infos as $info){
			$positions[$info['posid']] = $info;
		}
		setcache('position', $positions,'commons');
		return $infos;
	}
	
	private function content_pos($id,$modelid) {
		$id = intval($id);
		$modelid = intval($modelid);
		$MODEL = getcache('model','commons');
		$this->db_content->table_name = $this->db_content->db_tablepre.$MODEL[$modelid]['tablename'];		
		$posids = $this->db_data->get_one(array('id'=>$id,'modelid'=>$modelid)) ? 1 : 0;
		return $this->db_content->update(array('posids'=>$posids),array('id'=>$id));
	}	
	public function preview(){
		$thumb = $_GET['thumb'];
		include $this->admin_tpl('position_priview');	
	}
}
?>