<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class applications extends admin {
	
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('applications_model');
		parent::__construct();
	}
	
	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = 20;
		$offset = ($page - 1) * $pagesize;
		$total = $this->db->count();
		$pages = pages($total, $page, $pagesize);
		$list = $this->db->select('', '*', $offset.','.$pagesize);
		include $this->admin_tpl('applications_list');
	}
	
	public function add() {
		header("Cache-control: private"); 
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('application_name').L('can_not_be_empty'));
			$url = isset($_POST['url']) && trim($_POST['url']) ? trim($_POST['url']) : showmessage(L('application_url').L('can_not_be_empty'));
			$authkey = isset($_POST['authkey']) && trim($_POST['authkey']) ? trim($_POST['authkey']) : showmessage(L('authkey').L('can_not_be_empty'));
			$type = isset($_POST['type']) && trim($_POST['type']) ? trim($_POST['type']) : showmessage(L('type').L('can_not_be_empty'));
			$ip = isset($_POST['ip']) && trim($_POST['ip']) ? trim($_POST['ip']) : '';
			$apifilename = isset($_POST['apifilename']) && trim($_POST['apifilename']) ? trim($_POST['apifilename']) : showmessage(L('application_apifilename').L('can_not_be_empty'));
			$charset = isset($_POST['charset']) && trim($_POST['charset']) ? trim($_POST['charset']) : showmessage(L('application_charset').L('can_not_be_empty'));
			$synlogin = isset($_POST['synlogin']) && intval($_POST['synlogin']) ? intval($_POST['synlogin']) : 0;
			if ($this->db->get_one(array('name'=>$name))) {
				showmessage(L('application_name').L('exist'));
			}
			if ($this->db->get_one(array('url'=>$url))) {
				showmessage(L('application_url').L('exist'));
			}
			if ($this->db->insert(array('name'=>$name,'url'=>$url, 'authkey'=>$authkey, 'type'=>$type, 'ip'=>$ip, 'apifilename'=>$apifilename, 'charset'=>$charset, 'synlogin'=>$synlogin))) {
				/*写入应用列表缓存*/
				$applist = $this->db->listinfo('', '', 1, 100, 'appid');
				setcache('applist', $applist);
				
				showmessage(L('operation_success'), '?m=admin&c=applications&a=init');
			} else {
				showmessage(L('operation_failure'));
			}
		}
		include $this->admin_tpl('applications_add');
	}
	
	public function del() {
		$appid = isset($_GET['appid']) && intval($_GET['appid']) ? intval($_GET['appid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($r = $this->db->get_one(array('appid'=>$appid))) {
			if ($this->db->delete(array('appid'=>$appid))) {
				/*写入应用列表缓存*/
				$applist = $this->db->listinfo('', '', 1, 100, 'appid');
				setcache('applist', $applist);
				
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}		
		} else {
			showmessage(L('application_not_exist'), HTTP_REFERER);
		}
	}
	
	public function edit() {
		header("Cache-control: private");
		$appid = isset($_GET['appid']) && intval($_GET['appid']) ? intval($_GET['appid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('appid'=>$appid))) {
			if (isset($_POST['dosubmit'])) {
				$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('application_name').L('can_not_be_empty'));
				$url = isset($_POST['url']) && trim($_POST['url']) ? trim($_POST['url']) : showmessage(L('application_url').L('can_not_be_empty'));
				$authkey = isset($_POST['authkey']) && trim($_POST['authkey']) ? trim($_POST['authkey']) : showmessage(L('authkey').L('can_not_be_empty'));
				$type = isset($_POST['type']) && trim($_POST['type']) ? trim($_POST['type']) : showmessage(L('type').L('can_not_be_empty'));
				$ip = isset($_POST['ip']) && trim($_POST['ip']) ? trim($_POST['ip']) : '';
				$apifilename = isset($_POST['apifilename']) && trim($_POST['apifilename']) ? trim($_POST['apifilename']) : showmessage(L('application_apifilename').L('can_not_be_empty'));
				$charset = isset($_POST['charset']) && trim($_POST['charset']) ? trim($_POST['charset']) : showmessage(L('application_charset').L('can_not_be_empty'));
				$synlogin = isset($_POST['synlogin']) && intval($_POST['synlogin']) ? intval($_POST['synlogin']) : 0;
				if ($data['name'] != $name && $this->db->get_one(array('name'=>$name))) {
					showmessage(L('application_name').L('exist'));
				}
				if ($data['url'] != $url && $this->db->get_one(array('url'=>$url))) {
					showmessage(L('application_url').L('exist'));
				}
				if ($this->db->update(array('name'=>$name,'url'=>$url, 'authkey'=>$authkey, 'type'=>$type, 'ip'=>$ip, 'apifilename'=>$apifilename, 'charset'=>$charset, 'synlogin'=>$synlogin), array('appid'=>$appid))) {
					/*写入应用列表缓存*/
					$applist = $this->db->listinfo('', '', 1, 100, 'appid');
					setcache('applist', $applist);
					
					showmessage(L('operation_success'), '?m=admin&c=applications&a=init');
				} else {
					showmessage(L('operation_failure'));
				}
			}
			include $this->admin_tpl('applications_edit');
		} else {
			showmessage(L('application_not_exist'));
		}
	}
	
	public function ajax_name() {
		$name = isset($_GET['name']) && trim($_GET['name']) ?  (pc_base::load_config('system','charset')=='gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
		if ($id) {
			$r = $this->db->get_one(array('appid'=>$id), 'name');
			if ($r['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array("name"=>$name), 'appid')) {
			echo 0;
		} else {
			echo 1;
		}
	}
	
	public function ajax_url() {
		$url = isset($_GET['url']) && trim($_GET['url']) ?  trim($_GET['url']) : exit('0');
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
		if ($id) {
			$r = $this->db->get_one(array('appid'=>$id), 'url');
			if ($r['url'] == $url) {
				exit('1');
			}
		}
		if ($this->db->get_one(array("url"=>$url), 'appid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	public function check_status() {
		$appid = isset($_GET['appid']) && intval($_GET['appid']) ? intval($_GET['appid']) : exit('0');
		$applist = getcache('applist');
		if(empty($applist)) {
			/*写入应用列表缓存*/
			$applist = $this->db->listinfo('', '', 1, 100, 'appid');
			setcache('applist', $applist);
		}

		if (!empty($applist)) {
			$param = sys_auth('action=check_status', 'ENCODE', $applist[$appid]['authkey']);
			//如果填写ip则通信地址为ip地址，此时绑定了多个虚拟主机有可能出现错误
			$appurl = !empty($applist[$appid]['ip']) ? 'http://'.$applist[$appid]['ip'].'/api/' : $applist[$appid]['url'];
			$url = $appurl.$applist[$appid]['apifilename'];
			if (strpos($url, '?')) {
				$url .= '&';
			} else {
				$url .= "?";
			}

			if ($data = @file_get_contents($url.'code='.urlencode($param))) {
				exit($data);
			} else {
				exit('0');
			}
		} else {
			exit('0');
		}
	}
}