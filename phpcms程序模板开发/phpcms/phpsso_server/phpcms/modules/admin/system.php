<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class system extends admin {

	private $db;
	/**
	 * 析构函数
	 */
	public function __construct() {	
		parent::__construct(1);
		$this->db = pc_base::load_model('settings_model');
	}
	
	/**
	 * 首页
	 */
	public function init() {
		if (isset($_POST['dosubmit'])) {
			$denyusername = isset($_POST['denyusername']) ? new_stripslashes(trim($_POST['denyusername'])) : '';
			$denyemail = isset($_POST['denyemail']) ? new_stripslashes(trim($_POST['denyemail'])) : '';
			
			$denyemaildata = array2string(explode("\r\n", $denyemail));
			$denyusernamedata = array2string(explode("\r\n", $denyusername));

			$this->db->insert(array('name'=>'denyemail', 'data'=>$denyemaildata), 1, 1);
			$this->db->insert(array('name'=>'denyusername', 'data'=>$denyusernamedata), 1, 1);

			/*写入缓存*/
			setcache('settings', array('denyemail'=>explode("\r\n", $denyemail), 'denyusername'=>explode("\r\n", $denyusername)));
			showmessage(L('operation_success'), HTTP_REFERER);
		}
		
		$where = to_sqls(array('denyemail', 'denyusername'), '', 'name');
		$settingarr = $this->db->listinfo($where);
		foreach ($settingarr as $v) {
			$setting[$v['name']] = string2array($v['data']);
		}

		include $this->admin_tpl('system');
	}
	
	public function uc() {
		if (isset($_POST['dosubmit'])) {
			$data = isset($_POST['data']) ? $_POST['data'] : '';
			$data['ucuse'] = isset($_POST['ucuse']) && intval($_POST['ucuse']) ? intval($_POST['ucuse']) : 0;
			$filepath = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.'system.php';
			$config = include $filepath;
			$uc_config = '<?php '."\ndefine('UC_CONNECT', 'mysql');\n";
			foreach ($data as $k => $v) {
				$old[] = "'$k'=>'".(isset($config[$k]) ? $config[$k] : $v)."',";
				$new[] = "'$k'=>'$v',";
				$uc_config .= "define('".strtoupper($k)."', '$v');\n";
			}
			$html = file_get_contents($filepath);
			$html = str_replace($old, $new, $html);
			$uc_config_filepath = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.'uc_config.php';
			@file_put_contents($uc_config_filepath, $uc_config);
			@file_put_contents($filepath, $html);
			$this->db->insert(array('name'=>'ucenter', 'data'=>array2string($data)), 1,1);
			showmessage(L('operation_success'), HTTP_REFERER);
		}
		$data = array();
		$r = $this->db->get_one(array('name'=>'ucenter'));
		if ($r) {
			$data = string2array($r['data']);
		}
		include $this->admin_tpl('system_uc');
	}
	
	public function myqsl_test() {
		$host = isset($_GET['host']) && trim($_GET['host']) ? trim($_GET['host']) : exit('0');
		$password = isset($_GET['password']) && trim($_GET['password']) ? trim($_GET['password']) : exit('0');
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit('0');
		if(function_exists('mysql_connect')){
			if (@mysql_connect($host, $username, $password)) {
				exit('1');
			} else {
				exit('0');
			}
		}else{
			$hostdb = explode(":",$host);
			$port = isset($hostdb[1]) ? $hostdb[1] : 3306;
			if (@mysqli_connect($hostdb[0], $username, $password, null, $port)){
				exit('1');
			} else {
				exit('0');
			}
		}
	}

	public function sp4() {
		if (isset($_POST['dosubmit'])) {
			$data = isset($_POST['data']) ? $_POST['data'] : '';
			$data['sp4use'] = isset($_POST['sp4use']) && intval($_POST['sp4use']) ? intval($_POST['sp4use']) : 0;
			$data['sp4_password_key'] = isset($_POST['sp4_password_key']) && $_POST[sp4_password_key] ? $_POST['sp4_password_key'] : '';
			
			$this->db->insert(array('name'=>'sp4', 'data'=>array2string($data)), 1, 1);
			setcache('settings_sp4', $data);
			showmessage(L('operation_success'), HTTP_REFERER);
		}
		$data = array();
		$data = getcache('settings_sp4');

		include $this->admin_tpl('system_sp4');
	}
}
?>