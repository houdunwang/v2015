<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class keylink extends admin {
	function __construct() {
		$this->db = pc_base::load_model('keylink_model');
		parent::__construct();
	}
	
	function init () {
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$infos = $this->db->listinfo('','keylinkid DESC',$page ,'20');
		$pages = $this->db->pages;	
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=keylink&a=add\', title:\''.L('add_keylink').'\', width:\'450\', height:\'130\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_keylink'));
		include $this->admin_tpl('keylink_list');
	}
	
	/**
	 * 验证数据有效性
	 */
	public function public_name() {
			$word = isset($_GET['word']) && trim($_GET['word']) ? (CHARSET == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['word'])) : trim($_GET['word'])) : exit('0');
			//修改检测
			$keylinkid = isset($_GET['keylinkid']) && intval($_GET['keylinkid']) ? intval($_GET['keylinkid']) : '';
	 		$data = array();
			if ($keylinkid) {
				$data = $this->db->get_one(array('keylinkid'=>$keylinkid), 'word');
				if (!empty($data) && $data['word'] == $word) {
					exit('1');
				}
			}
			//添加检测
			if ($this->db->get_one(array('word'=>$word), 'keylinkid')) {
				exit('0');
				} else {
				exit('1');
			}
		}
		
	/**
	 * 关联词添加
	 */
	function add() {
		if(isset($_POST['dosubmit'])){
				if(empty($_POST['info']['word']) || empty($_POST['info']['url']))return false;
				$this->db->insert($_POST['info']);
				$this->public_cache_file();//更新缓存 
				showmessage(L('operation_success'),'?m=admin&c=keylink&a=add','', 'add');
			}else{
				$show_validator = $show_scroll = $show_header = true;
				include $this->admin_tpl('keylink_add');
		 }	 
	} 
	
	/**
	 * 关联词修改
	 */
	function edit() {
		if(isset($_POST['dosubmit'])){
			$keylinkid = intval($_GET['keylinkid']);
			if(empty($_POST['info']['word']) || empty($_POST['info']['url']))return false;
 			$this->db->update($_POST['info'],array('keylinkid'=>$keylinkid));
			$this->public_cache_file();//更新缓存
			showmessage(L('operation_success'),'?m=admin&c=keylink&a=edit','', 'edit');
		}else{
			$show_validator = $show_scroll = $show_header = true;
			$info = $this->db->get_one(array('keylinkid'=>$_GET['keylinkid']));
			if(!$info) showmessage(L('specified_word_not_exist'));
 			extract($info);
			include $this->admin_tpl('keylink_edit');
		}	 
	}
	/**
	 * 关联词删除
	 */
	function delete() {
 		if(is_array($_POST['keylinkid'])){
			foreach($_POST['keylinkid'] as $keylinkid_arr) {
				$this->db->delete(array('keylinkid'=>$keylinkid_arr));
			}
			$this->public_cache_file();//更新缓存
			showmessage(L('operation_success'),'?m=admin&c=keylink');	
		} else {
			$keylinkid = intval($_GET['keylinkid']);
			if($keylinkid < 1) return false;
			$result = $this->db->delete(array('keylinkid'=>$keylinkid));
			$this->public_cache_file();//更新缓存
			if($result){
				showmessage(L('operation_success'),'?m=admin&c=keylink');
			}else {
				showmessage(L("operation_failure"),'?m=admin&c=keylink');
			}
		}
	}
	/**
	 * 生成缓存
	 */
	public function public_cache_file() {
		$infos = $this->db->select('','word,url','','keylinkid ASC');
		$datas = $rs = array();
		foreach($infos as $r) {
			$rs[0] = $r['word'];
			$rs[1] = $r['url'];
			$datas[] = $rs;
		}
		setcache('keylink', $datas, 'commons');
		return true;
 	}
}
?>