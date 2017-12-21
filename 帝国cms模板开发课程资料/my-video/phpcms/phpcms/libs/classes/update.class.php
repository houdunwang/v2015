<?php 
class update {
	var $modules;
	var $update_url;
	var $http;

	function __construct() {
		$this->db = pc_base::load_model('admin_model');
		$this->update_url = 'http://update.v9.phpcms.cn/index.php';
		$this->http = pc_base::load_sys_class('http','',1);
		$this->uuid = $this->check_uuid();
	}

	function check(){
		$url = $this->url('check');
        if(!$this->http->get($url)) return false;
		return $this->http->get_data();
	}

	function url($action = 'check') {
        $modules = '';
        $site = getcache('sitelist','commons');
        $sitename = $site['1']['name'];
		$siturl = $site['1']['domain'];
        foreach ($site as $list) $sitelist .= $list['domain'].',';
		$pars = array(
			'action'=>$action,
			'phpcms_username'=>'',
			'sitename'=>$sitename,
			'siteurl'=>$siturl,
			'charset'=>CHARSET,
			'version'=>PC_VERSION,
			'release'=>PC_RELEASE,
			'os'=>PHP_OS,
			'php'=>phpversion(),
			'mysql'=>$this->db->version(),
			'browser'=>urlencode($_SERVER['HTTP_USER_AGENT']),
			'username'=>urlencode(param::get_cookie('admin_username')),
			'email'=> urlencode(param::get_cookie('admin_email')),
			'modules'=>ROUTE_M,
			'sitelist'=>urlencode($sitelist),
			'uuid'=>urlencode($this->uuid),
			);
		$data = http_build_query($pars);
		$verify = md5($this->uuid);		
		if($s = $this->module()) {
			$p = '&p='.$s;
		}
		return $this->update_url.'?'.$data.'&verify='.$verify.$p;
	}

	function notice() {
		return $this->url('notice');
	}

	function module($type = '') {
		$string = '';
		$db = pc_base::load_model('pay_payment_model');
		$result = $db->select('','pay_code');
		if(is_array($result) && count($result) > 0) {
			foreach($result as $v=>$r) {
				$string .= strtolower($r['pay_code']).'|';
			}
			return base64_encode($string);
		} else {
			return $string;
		}		
	}
	
	function check_uuid(){
		$site_db = pc_base::load_model('site_model');
		$info = $site_db->get_one(array('siteid'=>1),'uuid');
		if($info['uuid']) {
			return $info['uuid'];
		} else {;
			$uuid = $this->uuid($site_db);
			if($site_db->update(array('uuid'=>$uuid),array('siteid'=>1))) return $uuid;
		}
	}
	
	function uuid(&$db){
	   $r = $db->get_one('',"UUID() as uuid");
	   return $r['uuid'];
	}	
}
?>