<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class index extends admin {
	private $db, $siteid, $site, $point;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('release_point_model');
		$this->siteid = $this->get_siteid();
		$site = pc_base::load_app_class('sites', 'admin');
		$this->site = $site->get_by_id($this->siteid);
		$this->point = explode(',', $this->site['release_point']);
		pc_base::load_app_func('global');
		del_queue();
	}
	
	public function init() {
		if (empty($this->point[0])) {
			showmessage(L("the_site_not_release").'<script type="text/javascript">window.top.$(\'#display_center_id\').css(\'display\',\'none\');</script>');
		}
		$ids = isset($_GET['ids']) && trim($_GET['ids']) ? trim($_GET['ids']) : 0;
		$statuses = isset($_GET['statuses']) && intval($_GET['statuses']) ? intval($_GET['statuses']) : 0;
		if(isset($_GET['iniframe']))$show_header = true;
		include $this->admin_tpl('release_list');
	}
	
	public function public_sync() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : 0;
		$ids = isset($_GET['ids']) && trim($_GET['ids']) ? trim($_GET['ids']) : 0;
		$total = isset($_GET['total']) && intval($_GET['total']) ? intval($_GET['total']) : 0;
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$statuses = isset($_GET['statuses']) && intval($_GET['statuses']) ? intval($_GET['statuses']) : 0;
		$pagesize = 5;
		$queue = pc_base::load_model('queue_model');
		set_time_limit(600);
		if (!empty($ids)) {
			$ids = explode(',', $ids);
			if (empty($total)) {
				$total = count($ids);
			}
			$sql = "siteid = '".$this->get_siteid()."' AND status".($id+1)." = $statuses AND id in ('".implode('\',\'', $ids)."')";
			$data = $queue->select($sql, 'id, type, path');
		}else {
			if (empty($total)) {
				$total = $queue->count(array("siteid"=>$this->get_siteid(), "status".($id+1)=>$statuses));
			}
			$totalpage = ceil($total/$pagesize);
			$data = $queue->select(array("siteid"=>$this->get_siteid(), "status".($id+1)=>$statuses), 'id, type, path', $pagesize);
		}
		$release_point = $this->db->get_one(array('id'=>$this->point[$id]));
		$ftps = pc_base::load_sys_class('ftps');
		if(is_array($data) && !empty($data)) if ($ftps->connect($release_point['host'], $release_point['username'], $release_point['password'], $release_point['port'], $release_point['pasv'], $release_point['ssl'])) {
			if ($release_point['path']) {
				$ftps->chdir($release_point['path']);
			}
			foreach ($data as $v) {
				$status = -1;
				switch ($v['type']) {
					case 'del':
						if ($ftps->f_delete($release_point['path'].$v['path'])) {
							$status = 1;
						}
						break;
					case 'add':
					case 'edit':
						if ($ftps->put($release_point['path'].$v['path'], PHPCMS_PATH.$v['path'])) {
							$status = 1;
						}
						break;
				}
				$queue->update(array('status'.($id+1)=>$status, 'times'=>SYS_TIME), array('id'=>$v['id']));
			}
		} else {
			exit('<script type="text/javascript">alert("'.L("release_point_connect_failure",array('name'=>$release_point['name'])).'");</script>');
		}
		
		include $this->admin_tpl('release_sync');
	}
	
	public function failed() {
		if (empty($this->point[0])) {
			showmessage(L("the_site_not_release").'<script type="text/javascript">window.top.$(\'#display_center_id\').css(\'display\',\'none\');</script>');
		}
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		
		$sql = '';
		$i = 1;
		foreach ($this->point as $v) {
			$sql .= $sql ? " or status".$i." = '-1'" :" status".$i." = '-1'";
			$i++;
		}
		$sql .= ' AND siteid = \''.$this->get_siteid().'\'';
		$queue = pc_base::load_model('queue_model');
		$list = $queue->listinfo($sql, 'id desc', $page, 20);
		pc_base::load_sys_class('format', '', 0);
		include $this->admin_tpl('release_failed_list');
	}
	
	public function del() {
		$ids = isset($_POST['ids']) ? $_POST['ids'] : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (is_array($ids))$ids = implode('\',\'', $ids);
		$queue = pc_base::load_model('queue_model');
		$queue->delete("id in ('$ids')");
		showmessage(L('operation_success'), HTTP_REFERER);
	}
}