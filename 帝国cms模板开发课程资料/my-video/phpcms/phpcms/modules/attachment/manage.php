<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_class('admin','admin',0);

class manage extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		pc_base::load_app_func('global');
		$this->upload_url = pc_base::load_config('system','upload_url');
		$this->upload_path = pc_base::load_config('system','upload_path');		
		$this->imgext = array('jpg','gif','png','bmp','jpeg');
		$this->db= pc_base::load_model('attachment_model');
		$this->attachment = pc_base::load_sys_class('attachment');
		$this->admin_username = param::get_cookie('admin_username');
		$this->siteid = $this->get_siteid();
	}	
	/**
	 * 附件列表
	 */
	public function init() {
		$where = '';
		if($_GET['dosubmit']){
				if(is_array($_GET['info'])&&!empty($_GET['info']))extract($_GET['info']);
				if($filename) $where = "AND `filename` LIKE '%$filename%' ";
				if($start_uploadtime && $end_uploadtime) {
					$start = strtotime($start_uploadtime);
					$end = strtotime($end_uploadtime);
					if($start > $end) showmessage(L('range_not_correct'),HTTP_REFERER);
					$where .= "AND `uploadtime` >= '$start' AND  `uploadtime` <= '$end' ";				
				}
				if($fileext) $where .= "AND `fileext`='$fileext' ";
				$status =  trim($_GET['status']);
				if($status!='' && ($status==1 ||$status==0)) $where .= "AND `status`='$status' ";
				$module =  trim($_GET['module']);
				if(isset($module) && $module!='') $where .= "AND `module`='$module' ";		
		}
		$where .="AND `siteid`='".$this->siteid."'";
		if($where) $where = substr($where, 3);
		pc_base::load_sys_class('form');
		$category = getcache('category_content_'.$this->siteid,'commons');
		$modules = getcache('modules','commons');
		$page = $_GET['page'] ? $_GET['page'] : '1';
		$infos = $this->db->listinfo($where, 'uploadtime DESC', $page, $pagesize = 20);
		$pages = $this->db->pages;
		include $this->admin_tpl('attachment_list');
	}
	
	/**
	 * 目录浏览模式添加图片
	 */
	public function dir() {
		if(!$this->admin_username) return false;
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', trim($_GET['dir'])) : '';
		$filepath = $this->upload_path.$dir;
		$list = glob($filepath.'/'.'*');
		if(!empty($list)) rsort($list);
		$local = str_replace(array(PC_PATH, PHPCMS_PATH ,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('','',DIRECTORY_SEPARATOR), $filepath);
		//$show_header = true;
		include $this->admin_tpl('attachment_dir');
	}	
	
	public function pulic_dirmode_del() {
		$filename = urldecode($_GET['filename']);
		$tmpdir = $dir = urldecode($_GET['dir']);
		$tmpdir = str_replace('\\','/',$tmpdir);
		$tmpdirs = explode('/',$tmpdir);
		$tmpdir = PHPCMS_PATH.$tmpdirs[0].'/';
		if($tmpdir!=$this->upload_path) {
			showmessage(L('illegal_operation'));
		}
		$file = PHPCMS_PATH.$dir.DIRECTORY_SEPARATOR.$filename;
		$file = str_replace(array('/','\\'), DIRECTORY_SEPARATOR, $file);
		$file = str_replace('..', '', $file);

		if(@unlink($file)) {
			echo '1';
		} else {
			echo '0';
		}
	}
	
	/**
	 * 删除附件
	 */
	public function delete() {
		$aid = $_GET['aid'];
		$attachment_index = pc_base::load_model('attachment_index_model');
		if($this->attachment->delete(array('aid'=>$aid))) {
			$attachment_index->delete(array('aid'=>$aid));
			exit('1');
		} else {
			exit('0');
		}
	}
	
	/**
	 * 批量删除附件
	 */
	public function public_delete_all() {
		$del_arr = array();
		$del_arr = $_POST['aid'];
		$attachment_index = pc_base::load_model('attachment_index_model');
		if(is_array($del_arr)){
			foreach($del_arr as $v){
				$aid = intval($v);
				$this->attachment->delete(array('aid'=>$aid));
				$attachment_index->delete(array('aid'=>$aid));
			}
			showmessage(L('delete').L('success'), HTTP_REFERER);
		}
	}
	
	public function pullic_showthumbs() {
		$aid = intval($_GET['aid']);
		$info = $this->db->get_one(array('aid'=>$aid));
		if($info) {
			$infos = glob(dirname($this->upload_path.$info['filepath']).'/thumb_*'.basename($info['filepath']));
			foreach ($infos as $n=>$thumb) {
				$thumbs[$n]['thumb_url'] = str_replace($this->upload_path, $this->upload_url, $thumb);
				$thumbinfo = explode('_', basename($thumb));
				$thumbs[$n]['thumb_filepath'] = $thumb;
				$thumbs[$n]['width'] = $thumbinfo[1];
				$thumbs[$n]['height'] = $thumbinfo[2];
			}
		}
		$show_header = 1; 
		include $this->admin_tpl('attachment_thumb');
	}
	
	public function pullic_delthumbs() {
		$filepath = urldecode($_GET['filepath']);
		$ext = fileext($filepath);
		if(!in_array(strtoupper($ext),array('JPG','GIF','BMP','PNG','JPEG')))  exit('0');
		$reslut = @unlink($filepath);
		if($reslut) exit('1');
		 exit('0');
	}
}
?>