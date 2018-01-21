<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class dbsource_admin extends admin {
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('dbsource_model');
		parent::__construct();
		pc_base::load_app_func('global');
	}
	
	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$list = $this->db->listinfo(array('siteid'=>$this->get_siteid()), '', $page, 20);
		$pages = $this->db->pages;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=dbsource&c=dbsource_admin&a=add\', title:\''.L('added_external_data_source').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('added_external_data_source'));
		include $this->admin_tpl('dbsource_list');
	}
	
	public function add() {
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('dbsource_name').L('empty'));
			$host = isset($_POST['host']) && trim($_POST['host']) ? trim($_POST['host']) : showmessage(L('server_address').L('empty'));
			$port = isset($_POST['port']) && intval($_POST['port']) ? intval($_POST['port']) : showmessage(L('server_port').L('empty'));
			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('username').L('empty'));
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password').L('empty'));
			$dbname = isset($_POST['dbname']) && trim($_POST['dbname']) ? trim($_POST['dbname']) : showmessage(L('database').L('empty'));
			$dbtablepre = isset($_POST['dbtablepre']) && trim($_POST['dbtablepre']) ? trim($_POST['dbtablepre']) : '';
			$charset = isset($_POST['charset']) && in_array(trim($_POST['charset']), array('gbk','utf8', 'gb2312', 'latin1')) ? trim($_POST['charset']) : showmessage(L('charset').L('illegal_parameters'));
			$siteid = $this->get_siteid();
			if (!preg_match('/^\\w+$/i', $name)) {
				showmessage(L('data_source_of_the_letters_and_figures'));
			}
			//检察数据源名是否已经存在
			if ($this->db->get_one(array('siteid'=>$siteid, 'name'=>$name), 'id')) {
				showmessage(L('dbsource_name').L('exists'));
			}
			
			if ($this->db->insert(array('siteid'=>$siteid, 'name'=>$name,'host'=>$host,'port'=>$port,'username'=>$username,'password'=>$password,'dbname'=>$dbname,'dbtablepre'=>$dbtablepre,'charset'=>$charset))) {
				dbsource_cache();
				showmessage('', '', '', 'add');
			} else {
				showmessage(L('operation_failure'));
			}
			
		} else {
			pc_base::load_sys_class('form', '', 0);
			$show_header = $show_validator = true;
			include $this->admin_tpl('dbsource_add');
		}
	}
	
	public function edit() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : showmessage('ID'.L('empty'));
		$data = $this->db->get_one(array('id'=>$id));
		if (!$data) {
			showmessage(L('notfound'));
		}
		if (isset($_POST['dosubmit'])) {
			$host = isset($_POST['host']) && trim($_POST['host']) ? trim($_POST['host']) : showmessage(L('server_address').L('empty'));
			$port = isset($_POST['port']) && intval($_POST['port']) ? intval($_POST['port']) : showmessage(L('server_port').L('empty'));
			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('username').L('empty'));
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password').L('empty'));
			$dbname = isset($_POST['dbname']) && trim($_POST['dbname']) ? trim($_POST['dbname']) : showmessage(L('database').L('empty'));
			$dbtablepre = isset($_POST['dbtablepre']) && trim($_POST['dbtablepre']) ? trim($_POST['dbtablepre']) : '';
			$charset = isset($_POST['charset']) && in_array(trim($_POST['charset']), array('gbk','utf8', 'gb2312', 'latin1')) ? trim($_POST['charset']) : showmessage(L('charset').L('illegal_parameters'));
			$siteid = $this->get_siteid();
			$sql = array('siteid'=>$siteid, 'host'=>$host,'port'=>$port,'username'=>$username,'password'=>$password,'dbname'=>$dbname, 'dbtablepre'=>$dbtablepre, 'charset'=>$charset);
			
			if ($this->db->update($sql, array('id'=>$id))) {
				dbsource_cache();
				showmessage('', '', '', 'edit');
			} else {
				showmessage(L('operation_failure'));
			}
			
		} else {
			
			pc_base::load_sys_class('form', '', 0);
			$show_header = $show_validator = true;
			include $this->admin_tpl('dbsource_edit');
		}
	}
	
	public function del() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
		if ($this->db->get_one(array('id'=>$id))) {
			if ($this->db->delete(array('id'=>$id))) {
				dbsource_cache();
				showmessage(L('operation_success'), '?m=dbsource&c=dbsource_admin&a=init');
			} else {
				showmessage(L('operation_failure'),  '?m=dbsource&c=dbsource_admin&a=init');
			}
		} else {
			showmessage(L('notfound'),   '?m=dbsource&c=dbsource_admin&a=init');
		}
	}
	
	public function public_name() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
 		$data = array();
		if ($id) {
			$data = $this->db->get_one(array('id'=>$id), 'name');
			if (!empty($data) && $data['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$name), 'id')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	public function public_test_mysql_connect() {
		$host = isset($_GET['host']) && trim($_GET['host']) ? trim($_GET['host']) : exit('0');
		$password = isset($_GET['password']) && trim($_GET['password']) ? trim($_GET['password']) : exit('0');
		$port = isset($_GET['port']) && intval($_GET['port']) ? intval($_GET['port']) : exit('0');
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit('0');
		if(function_exists('mysql_connect')){
			if (@mysql_connect($host.':'.$port, $username, $password)) {
				exit('1');
			} else {
				exit('0');
			}
		}else{
			if (@mysqli_connect($host, $username, $password, null, $port)){
				exit('1');
			} else {
				exit('0');
			}
		}
	}
}