<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
class content extends admin {
	private $db, $data_db, $type_db;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('special_content_model');
		$this->data_db = pc_base::load_model('special_c_data_model');
		$this->type_db = pc_base::load_model('type_model');
	}
	
	/**
	 * 添加信息
	 */
	public function add() {
		$_GET['specialid'] = intval($_GET['specialid']);
		if (!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		if ($_POST['dosubmit'] || $_POST['dosubmit_continue']) {
			$info = $this->check($_POST['info'], 'info', 'add', $_POST['data']['content']); //验证数据的合法性
			//处理外部链接情况
			if ($info['islink']) {
				$info['url'] = $_POST['linkurl'];
				$info['isdata'] = 0;
			} else {
				$info['isdata'] = 1;
			} 
			$info['specialid'] = $_GET['specialid'];
			//将基础数据添加到基础表，并返回ID
			$contentid = $this->db->insert($info, true);
			
			// 向数据统计表添加数据
			$count = pc_base::load_model('hits_model');
			$hitsid = 'special-c-'.$info['specialid'].'-'.$contentid;
			$count->insert(array('hitsid'=>$hitsid));
			//如果不是外部链接，将内容加到data表中
			$html = pc_base::load_app_class('html');
			if ($info['isdata']) {
				$data = $this->check($_POST['data'], 'data'); //验证数据的合法性
				$data['id'] = $contentid;
				$this->data_db->insert($data);
				$searchid = $this->search_api($contentid, $data, $info['title'], 'update', $info['inputtime']);
				$url = $html->_create_content($contentid);
				$this->db->update(array('url'=>$url[0], 'searchid'=>$searchid), array('id'=>$contentid, 'specialid'=>$_GET['specialid']));
			}
			$html->_index($_GET['specialid'], 20, 5);
			$html->_list($info['typeid'], 20, 5);
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				if ($info['thunb']) {
					$this->attachment_db->api_update($info['thumb'],'special-c-'.$contentid, 1);
				}
				$this->attachment_db->api_update(stripslashes($data['content']),'special-c-'.$contentid);
			}
			if ($_POST['dosubmit']) showmessage(L('content_add_success'), HTTP_REFERER, '', '', 'setTimeout("window.close()", 2000)');
			elseif ($_POST['dosubmit_continue']) showmessage(L('content_add_success'), HTTP_REFERER);
		} else {
			$rs = $this->type_db->select(array('parentid'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()), 'typeid, name');
			$types = array();
			foreach ($rs as $r) {
				$types[$r['typeid']] = $r['name'];
			}
			//获取站点模板信息
			pc_base::load_app_func('global', 'admin');
			$template_list = template_list(get_siteid(), 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$special_db = pc_base::load_model('special_model');
			$info = $special_db->get_one(array('id'=>$_GET['specialid']));
			@extract($info);
			include $this->admin_tpl('content_add');
		}
	}
	
	/**
	 * 信息修改
	 */
	public function edit() {
		$_GET['specialid'] = intval($_GET['specialid']);
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['specialid'] || !$_GET['id']) showmessage(L('illegal_action'), HTTP_REFERER);
		if (isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
			$info = $this->check($_POST['info'], 'info', 'edit', $_POST['data']['content']); //验证数据的合法性
			//处理外部链接更换情况
			$r = $this->db->get_one(array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			
			if ($r['islink']!=$info['islink']) { //当外部链接和原来差别时进行操作
				// 向数据统计表添加数据
				$count = pc_base::load_model('hits_model');
				$hitsid = 'special-c-'.$_GET['specialid'].'-'.$_GET['id'];
				$count->delete(array('hitsid'=>$hitsid));
				$this->data_db->delete(array('id'=>$_GET['id']));
				if ($info['islink']) {
					$info['url'] = $_POST['linkurl'];
					$info['isdata'] = 0;
				} else {
					$data = $this->check($_POST['data'], 'data');
					$data['id'] = $_GET['id'];
					$this->data_db->insert($data);
					$count->insert(array('hitsid'=>$hitsid));
				} 
			}
			//处理外部链接情况
			if ($info['islink']) {
				$info['url'] = $_POST['linkurl'];
				$info['isdata'] = 0;
			} else {
				$info['isdata'] = 1;
			} 
			$html = pc_base::load_app_class('html', 'special');
			if ($info['isdata']) {
				$data = $this->check($_POST['data'], 'data');
				$this->data_db->update($data, array('id'=>$_GET['id']));
				$url = $html->_create_content($_GET['id']);
				if ($url[0]) {
					$info['url'] = $url[0];
					$searchid = $this->search_api($_GET['id'], $data, $info['title'], 'update', $info['inputtime']);
					$this->db->update(array('url'=>$url[0], 'searchid'=>$searchid), array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
				}
			} else {
				$this->db->update(array('url'=>$info['url']), array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			}
			$this->db->update($info, array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				if ($info['thumb']) {
					$this->attachment_db->api_update($info['thumb'],'special-c-'.$_GET['id'], 1);
				}
				$this->attachment_db->api_update(stripslashes($data['content']),'special-c-'.$_GET['id']);
			}
			$html->_index($_GET['specialid'], 20, 5);
			$html->_list($info['typeid'], 20, 5);
			showmessage(L('content_edit_success'), HTTP_REFERER, '', '', 'setTimeout("window.close()", 2000)');
		} else {
			$info = $this->db->get_one(array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			if($info['isdata']) $data = $this->data_db->get_one(array('id'=>$_GET['id']));
			$rs = $this->type_db->select(array('parentid'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()), 'typeid, name');
			$types = array();
			foreach ($rs as $r) {
				$types[$r['typeid']] = $r['name'];
			}
			//获取站点模板信息
			pc_base::load_app_func('global', 'admin');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$special_db = pc_base::load_model('special_model');
			$s_info = $special_db->get_one(array('id'=>$_GET['specialid']));
			@extract($s_info);
			include $this->admin_tpl('content_edit');
		}
	}
	
	/**
	 * 检查表题是否重复
	 */
	public function public_check_title() {
		if ($_GET['data']=='' || (!$_GET['specialid'])) return '';
		if (pc_base::load_config('system', 'charset')=='gbk') {
			$title = safe_replace(iconv('UTF-8', 'GBK', $_GET['data']));
		} else $title = $_GET['data'];
		$specialid = intval($_GET['specialid']);
		$r = $this->db->get_one(array('title'=>$title, 'specialid'=>$specialid));
		if ($r) {
			exit('1');
		} else {
			exit('0');
		}
	}
	
	/**
	 * 信息列表
	 */
	public function init() {
		$_GET['specialid'] = intval($_GET['specialid']);
		if(!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		$types = $this->type_db->select(array('module'=>'special', 'parentid'=>$_GET['specialid']), 'name, typeid', '', '`listorder` ASC, `typeid` ASC', '', 'typeid');
		$page = max(intval($_GET['page']), 1);
		$datas = $this->db->listinfo(array('specialid'=>$_GET['specialid']), '`listorder` ASC , `id` DESC', $page);
		$pages = $this->db->pages;
		$big_menu = array(array('javascript:openwinx(\'?m=special&c=content&a=add&specialid='.$_GET['specialid'].'\',\'\');void(0);', L('add_content')), array('javascript:window.top.art.dialog({id:\'import\',iframe:\'?m=special&c=special&a=import&specialid='.$_GET['specialid'].'\', title:\''.L('import_content').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'import\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'import\'}).close()});void(0);', L('import_content')));
		include $this->admin_tpl('content_list');
	}
	
	/**
	 * 信息排序 信息调用时按排序从小到大排列
	 */
	public function listorder() {
		$_GET['specialid'] = intval($_GET['specialid']);
		if (!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		foreach ($_POST['listorders'] as $id => $v) {
			$this->db->update(array('listorder'=>$v), array('id'=>$id, 'specialid'=>$_GET['specialid']));
		}
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 删除信息
	 */
	public function delete() {
		if (!isset($_POST['id']) || empty($_POST['id']) || !$_GET['specialid']) {
			showmessage(L('illegal_action'), HTTP_REFERER);
		}
		$specialid = $_GET['specialid'];
		$special = pc_base::load_model('special_model');
		$info = $special->get_one(array('id'=>$specialid));
		$special_api = pc_base::load_app_class('special_api', 'special');
		if (is_array($_POST['id'])) {
			foreach ($_POST['id'] as $sid) {
				$sid = intval($sid);
				$special_api->_delete_content($sid, $info['siteid'], $info['ishtml']);
				if(pc_base::load_config('system','attachment_stat')) {
					$keyid = 'special-c-'.$sid;
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete($keyid);
				}
			}
		} elseif (is_numeric($_POST['id'])){
			$id = intval($_POST['id']);
			$special_api->_delete_content($id, $info['siteid'], $info['ishtml']);
			if(pc_base::load_config('system','attachment_stat')) {
				$keyid = 'special-c-'.$id;
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_delete($keyid);
			}
		}
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 添加到全站搜索
	 * @param intval $id 文章ID
	 * @param array $data 数组
	 * @param string $title 标题
	 * @param string $action 动作
	 */
	private function search_api($id = 0, $data = array(), $title, $action = 'update', $addtime) {
		$this->search_db = pc_base::load_model('search_model');
		$siteid = $this->get_siteid();
		$type_arr = getcache('type_module_'.$siteid,'search');
		$typeid = $type_arr['special'];
		if($action == 'update') {
			$fulltextcontent = $data['content'];
			return $this->search_db->update_search($typeid ,$id, $fulltextcontent,$title, $addtime);
		} elseif($action == 'delete') {
			$this->search_db->delete_search($typeid ,$id);
		}
	}
	
	/**
	 * 表单验证
	 * @param array $data 表单数据
	 * @param string $type 按数据表数据判断
	 * @param string $action 在添加时会加上默认数据
	 * @return array 数据检验后返回的数组
	 */
	private function check($data = array(), $type = 'info', $action = 'add', $content = '') {
		if ($type == 'info') {
			if (!$data['title']) showmessage(L('title_no_empty'), HTTP_REFERER);
			if (!$data['typeid']) showmessage(L('no_select_type'), HTTP_REFERER);
			$data['inputtime'] = $data['inputtime'] ? strtotime($data['inputtime']) : SYS_TIME;
			$data['islink'] = $data['islink'] ? intval($data['islink']) : 0;
			$data['style'] = '';
			if ($data['style_color']) {
				$data['style'] .= 'color:#00FF99;';
			} 
			if ($data['style_font_weight']) {
				$data['style'] .= 'font-weight:bold;';
			}
			
			//截取简介
			if ($_POST['add_introduce'] && $data['description']=='' && !empty($content)) {
				$content = stripslashes($content);
				$introcude_length = intval($_POST['introcude_length']);
				$data['description'] = str_cut(str_replace(array("\r\n","\t"), '', strip_tags($content)),$introcude_length);
			}
			
			//自动提取缩略图
			if (isset($_POST['auto_thumb']) && $data['thumb'] == '' && !empty($content)) {
					$content = stripslashes($content);
					$auto_thumb_no = intval($_POST['auto_thumb_no']) - 1;
					if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
						$data['thumb'] = $matches[3][$auto_thumb_no];
					}
			}
			unset($data['style_color'], $data['style_font_weight']);
			if ($action == 'add') {
				$data['updatetime'] = SYS_TIME;
				$data['username'] = param::get_cookie('admin_username');
				$data['userid'] = $_SESSION['userid'];
			}
		} elseif ($type == 'data') {
			if (!$data['content']) showmessage(L('content_no_empty'), HTTP_REFERER);
		}
		return $data;
	}
}