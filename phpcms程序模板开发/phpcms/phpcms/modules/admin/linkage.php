<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
set_time_limit(0);
class linkage extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('linkage_model');
		$this->sites = pc_base::load_app_class('sites');
		pc_base::load_sys_class('form', '', 0);
		$this->childnode = array();
	}
	
	/**
	 * 联动菜单列表
	 */
	public function init() {
		$where = array('keyid'=>0);
		$infos = $this->db->select($where);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=linkage&a=add\', title:\''.L('linkage_add').'\', width:\'500\', height:\'220\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('linkage_add'));
		include $this->admin_tpl('linkage_list');
	}
	
	/**
	 * 添加联动菜单
	 */
	function add() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$info['name'] = isset($_POST['info']['name']) && trim($_POST['info']['name']) ? trim($_POST['info']['name']) : showmessage(L('linkage_not_empty'));
			$info['description'] = trim($_POST['info']['description']);
			$info['style'] = trim(intval($_POST['info']['style']));
			$info['siteid'] = trim(intval($_POST['info']['siteid']));
			$this->db->insert($info);
			$insert_id = $this->db->insert_id();
			if($insert_id){
				showmessage(L('operation_success'), '', '', 'add');
			}
		} else {
			$show_header = true;
			$show_validator = true;
			$sitelist = $this->sites->get_list();
			foreach($sitelist as $siteid=>$v) {
				$sitelist[$siteid] = $v['name'];
			}
			include $this->admin_tpl('linkage_add');
		}

	}
	/**
	 * 编辑联动菜单
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$linkageid = intval($_POST['linkageid']);
			$info['name'] = isset($_POST['info']['name']) && trim($_POST['info']['name']) ? trim($_POST['info']['name']) : showmessage(L('linkage_not_empty'));
			$info['description'] = trim($_POST['info']['description']);
			$info['style'] = trim(intval($_POST['info']['style']));
			$info['siteid'] = trim(intval($_POST['info']['siteid']));
			$info['setting'] = array2string(array('level'=>intval($_POST['info']['level'])));
			if($_POST['info']['keyid']) $info['keyid'] = trim($_POST['info']['keyid']);
			if($_POST['info']['parentid']) $info['parentid'] = trim($_POST['info']['parentid']);
			$this->db->update($info,array('linkageid'=>$linkageid));
			$id = $info['keyid'] ? $info['keyid'] : $linkageid;
			showmessage(L('operation_success'), '', '', 'edit');			
		} else {
			$linkageid = intval($_GET['linkageid']);
			$info = $this->db->get_one(array('linkageid'=>$linkageid));
			extract($info);	
			$setting = string2array($setting);
			$sitelist = $this->sites->get_list();
			foreach($sitelist as $id=>$v) {
				$sitelist[$id] = $v['name'];
			}
			$show_header = true;
			$show_validator = true;
			include $this->admin_tpl('linkage_edit');
		}
		
	}
	/**
	 * 删除菜单
	 */
	public function delete() {
		$linkageid = intval($_GET['linkageid']);
		$keyid = intval($_GET['keyid']);
		$this->_get_childnode($linkageid);
		if(is_array($this->childnode)){
			foreach($this->childnode as $linkageid_tmp) {
				$this->db->delete(array('linkageid' => $linkageid_tmp));
			}
		}
		$this->db->delete(array('keyid' => $linkageid));
		$id = $keyid ? $keyid : $linkageid;
		if(!$keyid)$this->_dlecache($linkageid);
		showmessage(L('operation_success'));	
	}
	
	public function public_cache() {
		$linkageid = intval($_GET['linkageid']);
		$this->_cache($linkageid);
		showmessage(L('operation_success'));
	}
	/**
	 * 菜单排序
	 */
	public function public_listorder() {
		if(!is_array($_POST['listorders'])) return FALSE;
		foreach($_POST['listorders'] as $linkageid=>$value)
		{
			$value = intval($value);
			$this->db->update(array('listorder'=>$value),array('linkageid'=>$linkageid));
		}
		$id = intval($_POST['keyid']);
		showmessage(L('operation_success'),'?m=admin&c=linkage&a=init');
	}

	/**
	 * 管理联动菜单子菜单
	 */
	public function public_manage_submenu() {
		$keyid = isset($_GET['keyid']) && trim($_GET['keyid']) ? trim($_GET['keyid']) : showmessage(L('linkage_parameter_error'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$sum = $this->db->count(array('keyid'=>$keyid));
		$sql_parentid = $_GET['parentid'] ? trim($_GET['parentid']) : 0;
		$where = $sum > 40 ? array('keyid'=>$keyid,'parentid'=>$sql_parentid) : array('keyid'=>$keyid);
		$result = $this->db->select($where,'*','','listorder ,linkageid');

		foreach($result as $areaid => $area){
			$areas[$area['linkageid']] = array('id'=>$area['linkageid'],'parentid'=>$area['parentid'],'name'=>$area['name'],'listorder'=>$area['listorder'],'style'=>$area['style'],'mod'=>$mod,'file'=>$file,'keyid'=>$keyid,'description'=>$area['description']);
			$areas[$area['linkageid']]['str_manage'] = ($sum > 40 && $this->_is_last_node($area['keyid'],$area['linkageid'])) ? '<a href="?m=admin&c=linkage&a=public_manage_submenu&keyid='.$area['keyid'].'&parentid='.$area['linkageid'].'">'.L('linkage_manage_submenu').'</a> | ' : '';
			$areas[$area['linkageid']]['str_manage'] .= '<a href="javascript:void(0);" onclick="add(\''.$keyid.'\',\''.new_addslashes($area['name']).'\',\''.$area['linkageid'].'\')">'.L('linkage_add_submenu').'</a> | <a href="javascript:void(0);" onclick="edit(\''.$area['linkageid'].'\',\''.$area['name'].'\',\''.$area['parentid'].'\')">'.L('edit').'</a> | <a href="javascript:confirmurl(\'?m=admin&c=linkage&a=delete&linkageid='.$area['linkageid'].'&keyid='.$area['keyid'].'\', \''.L('linkage_is_del').'\')">'.L('delete').'</a> ';
		}
		
		$str  = "<tr>
					<td align='center' width='80'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
					<td align='center' width='100'>\$id</td>
					<td>\$spacer\$name</td>
					<td >\$description</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$tree->init($areas);
		$submenu = $tree->get_tree($sql_parentid, $str);
		$big_menu =array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=linkage&a=public_sub_add&keyid='.$keyid.'\', title:\''.L('linkage_add').'\', width:\'500\', height:\'430\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('linkage_add'));		
		include $this->admin_tpl('linkage_submenu');
	}
	
	/**
	 * 子菜单添加
	 */
	public function public_sub_add() {		
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$info['keyid'] = isset($_POST['keyid']) && trim($_POST['keyid']) ? trim(intval($_POST['keyid'])) : showmessage(L('linkage_parameter_error'));
			$name = isset($_POST['info']['name']) && trim($_POST['info']['name']) ? trim($_POST['info']['name']) : showmessage(L('linkage_parameter_error'));
			$info['description'] = trim($_POST['info']['description']);
			$info['style'] = trim($_POST['info']['style']);
			$info['parentid'] = trim($_POST['info']['parentid']);
			$names = explode("\n", trim($name));
			foreach($names as $name) {
				$name = trim($name);
				if(!$name) continue;
				$info['name'] = $name;
				$this->db->insert($info);
			}		
			if($this->db->insert_id()){
				showmessage(L('operation_success'), '', '', 'add');
			}
		} else {
			$keyid = $_GET['keyid'];
			$linkageid = $_GET['linkageid'];
			$list = form::select_linkage($keyid,'0','info[parentid]', 'parentid', L('cat_empty'), $linkageid);
			$show_validator = true;
			include $this->admin_tpl('linkage_sub_add');			
		}
	}
	public function ajax_getlist() {

		$keyid = intval($_GET['keyid']);
		$datas = getcache($keyid,'linkage');
		$infos = $datas['data'];
		$where_id = isset($_GET['parentid']) ? $_GET['parentid'] : intval($infos[$_GET['linkageid']]['parentid']);
		$parent_menu_name = ($where_id==0) ? $datas['title'] :$infos[$where_id]['name'];
		foreach($infos AS $k=>$v) {
			if($v['parentid'] == $where_id) {
				$s[]=iconv('gb2312','utf-8',$v['linkageid'].','.$v['name'].','.$v['parentid'].','.$parent_menu_name);
			}
		}
		if(count($s)>0) {
			$jsonstr = json_encode($s);
			echo $_GET['callback'].'(',$jsonstr,')';
			exit;			
		} else {
			echo $_GET['callback'].'()';exit;			
		}
	}
	/**
	 * 生成联动菜单缓存
	 * @param init $linkageid
	 */
	private function _cache($linkageid) {
		$linkageid = intval($linkageid);
		$info = array();
		$r = $this->db->get_one(array('linkageid'=>$linkageid),'name,siteid,style,keyid,setting');
		$info['title'] = $r['name'];
		$info['style'] = $r['style'];
		$info['setting'] = string2array($r['setting']);
		$info['siteid'] = $r['siteid'];
		$info['data'] = $this->submenulist($linkageid);
		setcache($linkageid, $info,'linkage');
		return $info;
	}
	
	/**
	 * 删除联动菜单缓存文件
	 * @param init $linkageid
	 */
	private function _dlecache($linkageid) {
		return delcache($linkageid,'linkage');
	}
	
	/**
	 * 子菜单列表
	 * @param unknown_type $keyid
	 */
	private function submenulist($keyid=0) {
		$keyid = intval($keyid);
		$datas = array();
		$where = ($keyid > 0) ? array('keyid'=>$keyid) : '';
		$result = $this->db->select($where,'*','','listorder ,linkageid');	
		if(is_array($result)) {
			foreach($result as $r) {
				$arrchildid = $r['arrchildid'] = $this->get_arrchildid($r['linkageid'],$result);				
				$child = $r['child'] =  is_numeric($arrchildid) ? 0 : 1;
				$this->db->update(array('child'=>$child,'arrchildid'=>$arrchildid),array('linkageid'=>$r['linkageid']));			
				$datas[$r['linkageid']] = $r;
			}
		}
		return $datas;
	}
	
	/**
	 * 获取所属站点
	 * @param unknown_type $keyid
	 */
	private function _get_belong_siteid($keyid) {
		$keyid = intval($keyid);
		$info = $this->db->get_one(array('linkageid'=>$keyid));
		return $info ? $info['siteid'] : false;
	}

	
	/**
	 * 获取联动菜单子节点
	 * @param int $linkageid
	 */
	private function _get_childnode($linkageid) {
		$where = array('parentid'=>$linkageid);
		$this->childnode[] = intval($linkageid);
		$result = $this->db->select($where);
		if($result) {
			foreach($result as $r) {
				$this->_get_childnode($r['linkageid']);
			}
		}
	}
	
	private function _is_last_node($keyid,$linkageid) {
		$result = $this->db->count(array('keyid'=>$keyid,'parentid'=>$linkageid));
		return $result ? true : false;
	}	
	/**
	 * 返回菜单ID
	 */
	public function public_get_list() {
		$where = array('keyid'=>0);
		$infos = $this->db->select($where);
		include $this->admin_tpl('linkage_get_list');
	}
	
	/**
	 * 获取子菜单ID列表
	 * @param $linkageid 联动菜单id
	 * @param $linkageinfo
	 */
	private function get_arrchildid($linkageid,$linkageinfo) {
		$arrchildid = $linkageid;
		if(is_array($linkageinfo)) {
			foreach($linkageinfo as $linkage) {
				if($linkage['parentid'] && $linkage['linkageid'] != $linkageid && $linkage['parentid']== $linkageid) 	{
					$arrchildid .= ','.$this->get_arrchildid($linkage['linkageid'],$linkageinfo);
	
				}
			}
		}
		return $arrchildid;
	}		
}
?>