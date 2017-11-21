<?php
define('IN_PHPSSO', true);

class phpsso {

	public $db, $settings, $applist, $appid, $data;
	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->db = pc_base::load_model('member_model');
		pc_base::load_app_func('global');
		
		/*获取系统配置*/
		$this->settings = getcache('settings', 'admin');
		$this->applist = getcache('applist', 'admin');

		if(isset($_GET) && is_array($_GET) && count($_GET) > 0) {
			foreach($_GET as $k=>$v) {
				if(!in_array($k, array('m','c','a'))) {
					$_POST[$k] = $v;
				}
			}
		}

		if(isset($_POST['appid'])) {
			$this->appid = intval($_POST['appid']);
		} else {
			exit('0');
		}

		if(isset($_POST['data'])) {
			parse_str(sys_auth($_POST['data'], 'DECODE', $this->applist[$this->appid]['authkey']), $this->data);
					
			if(empty($this->data) || !is_array($this->data)) {
				exit('0');
			}
			if(!get_magic_quotes_gpc()) {
				$this->data= new_addslashes($this->data);
			}
			if(isset($this->data['username']) && $this->data['username']!='' && is_username($this->data['username'])==false){
				exit('-5');
			}
			if(isset($this->data['email']) && $this->data['email']!='' && is_email($this->data['email'])==false){
				exit('-5');
			}
			if(isset($this->data['password']) && $this->data['password']!='' && (is_password($this->data['password'])==false || is_badword($this->data['password']))){
				exit('-5');
			}
			if(isset($this->data['newpassword']) && $this->data['newpassword']!='' && (is_password($this->data['newpassword'])==false || is_badword($this->data['newpassword']))){
				exit('-5');
			}
		} else {
			exit('0');
		}
		$postStr = file_get_contents("php://input");
		if($postStr) {
			$this->data['avatardata'] = $postStr;		
		}
	}

}