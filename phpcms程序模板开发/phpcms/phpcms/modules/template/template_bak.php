<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class template_bak extends admin {
	private $db, $style, $dir, $filename, $filepath, $fileid;
	public function __construct() {
		parent::__construct();
		$this->style = isset($_GET['style']) && trim($_GET['style']) ? str_replace(array('..\\', '../', './', '.\\', '/', '\\'), '', trim($_GET['style'])) : showmessage(L('illegal_operation'));
		$this->dir = isset($_GET['dir']) && trim($_GET['dir']) ? trim(urldecode($_GET['dir'])) : showmessage(L('illegal_operation'));
		$this->dir = safe_replace($this->dir);
		$this->filename = isset($_GET['filename']) && trim($_GET['filename']) ? trim($_GET['filename']) : showmessage(L('illegal_operation'));
		if (empty($this->style) || empty($this->dir) || empty($this->filename)) {
			showmessage(L('illegal_operation'), HTTP_REFERER);
		}
		$this->filepath = PC_PATH.'templates'.DIRECTORY_SEPARATOR.$this->style.DIRECTORY_SEPARATOR.$this->dir.DIRECTORY_SEPARATOR.$this->filename;
		$this->fileid = $this->style.'_'.$this->dir.'_'.$this->filename;
		$this->tpl_edit = pc_base::load_config('system', 'tpl_edit');
		$this->db = pc_base::load_model('template_bak_model');
	}
	
	public function init() {
		if($this->tpl_edit == '0'){
			showmessage(L('tpl_edit'), HTTP_REFERER);
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$list = $this->db->listinfo(array('fileid'=>$this->fileid), 'creat_at desc', $page, 20);
		if (!$list) {
			showmessage(L('not_exist_versioning'), 'blank');
		}
		$pages = $this->db->pages;
		$show_header = true;
		pc_base::load_sys_class('format', '', 0);
		include $this->admin_tpl('template_bak_list');
	}
	
	public function restore() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('illegal_operation'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('id'=>$id))) {
			if (!is_writable($this->filepath)) {
				showmessage(L("file_does_not_writable"), HTTP_REFERER);
			}
			if (@file_put_contents($this->filepath, $data['template'])) {
				showmessage(L('operation_success'), HTTP_REFERER, '', 'history');
			} else {
				showmessage(L('operation_success'), HTTP_REFERER, '', 'history');
			}
			
		} else {
			showmessage(L('notfound'), HTTP_REFERER);
		}
	}
	
	public function del() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('illegal_operation'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('id'=>$id))) {
			$this->db->delete(array('id'=>$id));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('notfound'), HTTP_REFERER);
		}
	}
}
?>