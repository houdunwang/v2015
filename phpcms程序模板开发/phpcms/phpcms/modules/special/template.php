<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('global', 'special');

class template extends admin {
	private $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('special_model');
	}
	
	/**
	 * 编辑专题首页模板
	 */
	public function init() {
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		$specialid = isset($_GET['specialid']) && intval($_GET['specialid']) ? intval($_GET['specialid']) : showmessage(L('illegal_action'), HTTP_REFERER);;
		if (!$specialid) showmessage(L('illegal_action'), HTTP_REFERER);
		
		$info = $this->db->get_one(array('id'=>$specialid, 'disabled'=>'0', 'siteid'=>$this->get_siteid()));
		if (!$info['id']) showmessage(L('illegal_parameters'), HTTP_REFERER);
		$id = $specialid;
		if($info['css']) $css_param = unserialize($info['css']);
		if(!$info['ispage']) {
			$type_db = pc_base::load_model('type_model');
			$types = $type_db->select(array('module'=>'special', 'parentid'=>$id), '*', '', '`listorder` ASC, `typeid` ASC');
		}
		extract($info);
		$css = get_css($css_param);
		$template = $info['index_template'] ? $info['index_template'] : 'index';
		pc_base::load_app_func('global', 'template');
		ob_start();
		include template('special', $template);
		$html = ob_get_contents();
		ob_clean();
		$html = visualization($html, 'default', 'test', 'block.html');
		include $this->admin_tpl('template_edit');
	}
	
	/**
	 * css编辑预览
	 */
	public function preview() {
		define('HTML', true);
		if (!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		$info = $this->db->get_one(array('id'=>$_GET['specialid'], 'disabled'=>'0', 'siteid'=>$this->get_siteid()));
		if (!$info['id']) showmessage(L('illegal_parameters'), HTTP_REFERER);
		$css = get_css($_POST['info']);
		$template = $info['index_template'] ? $info['index_template'] : 'index';
		include template('special', $template);
	}
	
	/**
	 * css添加
	 */
	public function add() {
		if (!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		$info = $this->db->get_one(array('id'=>$_GET['specialid'], 'disabled'=>'0', 'siteid'=>$this->get_siteid()));
		if (!$info['id']) showmessage(L('illegal_parameters'), HTTP_REFERER);
		$data = serialize($_POST['info']);
		$this->db->update(array('css'=>$data), array('id'=>$info['id']));
		showmessage(L('operation_success'), HTTP_REFERER);
	}
}
?>