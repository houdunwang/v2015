<?php
/**
 * 管理员后台会员组操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class member_group extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('member_group_model');
	}

	/**
	 * 会员组首页
	 */
	function init() {

		include $this->admin_tpl('member_init');
	}
	
	/**
	 * 会员组列表
	 */
	function manage() {
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$member_group_list = $this->db->listinfo('', 'sort ASC', $page, 15);
		$this->member_db = pc_base::load_model('member_model');
		//TODO 此处循环中执行sql，会严重影响效率，稍后考虑在memebr_group表中加入会员数字段和统计会员总数功能解决。
		foreach ($member_group_list as $k=>$v) {
			$membernum = $this->member_db->count(array('groupid'=>$v['groupid']));
			$member_group_list[$k]['membernum'] = $membernum;
		}
		$pages = $this->db->pages;
		
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member_group&a=add\', title:\''.L('member_group_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('member_group_add'));
		include $this->admin_tpl('member_group_list');
	}
			
	/**
	 * 添加会员组
	 */
	function add() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			if(!$this->_checkname($_POST['info']['name'])){
				showmessage('会员组名称已经存在');
			}
			$info = $_POST['info'];
			$info['allowpost'] = $info['allowpost'] ? 1 : 0;
			$info['allowupgrade'] = $info['allowupgrade'] ? 1 : 0;
			$info['allowpostverify'] = $info['allowpostverify'] ? 1 : 0;
			$info['allowsendmessage'] = $info['allowsendmessage'] ? 1 : 0;
			$info['allowattachment'] = $info['allowattachment'] ? 1 : 0;
			$info['allowsearch'] = $info['allowsearch'] ? 1 : 0;
			$info['allowvisit'] = $info['allowvisit'] ? 1 : 0;
			
			$this->db->insert($info);
			if($this->db->insert_id()){
				$this->_updatecache();
				showmessage(L('operation_success'),'?m=member&c=member_group&a=manage', '', 'add');
			}
		} else {
			$show_header = $show_scroll = true;
			include $this->admin_tpl('member_group_add');
		}
		
	}
	
	/**
	 * 修改会员组
	 */
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];

			$info['allowpost'] = isset($info['allowpost']) ? 1 : 0;
			$info['allowupgrade'] = isset($info['allowupgrade']) ? 1 : 0;
			$info['allowpostverify'] = isset($info['allowpostverify']) ? 1 : 0;
			$info['allowsendmessage'] = isset($info['allowsendmessage']) ? 1 : 0;
			$info['allowattachment'] = isset($info['allowattachment']) ? 1 : 0;
			$info['allowsearch'] = isset($info['allowsearch']) ? 1 : 0;
			$info['allowvisit'] = isset($info['allowvisit']) ? 1 : 0;
			
			$this->db->update($info, array('groupid'=>$info['groupid']));
			
			$this->_updatecache();
			showmessage(L('operation_success'), '?m=member&c=member_group&a=manage', '', 'edit');
		} else {					
			$show_header = $show_scroll = true;
			$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			$groupinfo = $this->db->get_one(array('groupid'=>$groupid));
			include $this->admin_tpl('member_group_edit');		
		}
	}
	
	/**
	 * 排序会员组
	 */
	function sort() {		
		if(isset($_POST['sort'])) {
			foreach($_POST['sort'] as $k=>$v) {
				$this->db->update(array('sort'=>$v), array('groupid'=>$k));
			}
			
			$this->_updatecache();
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	/**
	 * 删除会员组
	 */
	function delete() {	
		$groupidarr = isset($_POST['groupid']) ? $_POST['groupid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$where = to_sqls($groupidarr, '', 'groupid');
		if ($this->db->delete($where)) {
			$this->_updatecache();
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * 检查用户名是否合法
	 * @param string $name
	 */
	private function _checkname($name = NULL) {
		if(empty($name)) return false;
		if ($this->db->get_one(array('name'=>$name),'groupid')){
			return false;
		}
		return true;
	}
	
	/**
	 * 更新会员组列表缓存
	 */
	private function _updatecache() {
		$grouplist = $this->db->listinfo('', '', 1, 1000, 'groupid');
		setcache('grouplist', $grouplist);
	}
	
	public function public_checkname_ajax() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? trim($_GET['name']) : exit(0);
		$name = iconv('utf-8', CHARSET, $name);
		
		if ($this->db->get_one(array('name'=>$name),'groupid')){
			exit('0');
		} else {
			exit('1');
		}
	}

}
?>