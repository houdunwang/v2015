<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class readpoint {
	public $userid,$username;
	function __construct() {
		$this->userid = param::get_cookie('_userid');
		if(!$this->userid) {
			header("Location: index.php?m=member&c=index&a=login&forward=".urlencode(get_url()));
			exit;
		}
		$this->username = param::get_cookie('_username');
	}

	public function init() {
		$allow_visitor = new_html_special_chars($_GET['allow_visitor']);
		$auth = sys_auth($allow_visitor,'DECODE');
		if(strpos($auth,'|')===false) showmessage(L('illegal_operation'));
		$auth_str = explode('|', $auth);
		$flag = $auth_str[0];
		if(!preg_match('/^([0-9]+)|([0-9]+)/', $flag)) showmessage(L('illegal_operation'));
		$readpoint = intval($auth_str[1]);
		$paytype = intval($auth_str[2]);
		$http_referer = urldecode($_GET['http_referer']);
		
		if(!$readpoint) showmessage(L('illegal_operation'));
		pc_base::load_app_class('spend','pay',0);
		
		$flag_arr = explode('_', $flag);
		$catid = $flag_arr[0];
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		if(isset($CATEGORYS[$catid])) {
			$setting = string2array($CATEGORYS[$catid]['setting']);
			$repeatchargedays = intval($setting['repeatchargedays']);
			if($repeatchargedays) {
				$fromtime = SYS_TIME - 86400 * $repeatchargedays;
				$r = spend::spend_time($this->userid,$fromtime,$flag);
				if($r) showmessage(L('have_pay'),$http_referer,1000);
			}
		}
		if($paytype) {
			if(spend::amount($readpoint, L('msg_readpoint'), $this->userid, $this->username, '', '', $flag)==false) {
				$msg = spend::get_msg();
				$http_referer = APP_PATH.'index.php?m=pay&c=deposit&a=pay';
			} else {
				$msg = L('readpoint_pay',array('readpoint'=>$readpoint));
			}
		} else {
			if(spend::point($readpoint, L('msg_readpoint'), $this->userid, $this->username, '', '', $flag)==false) {
				$msg = spend::get_msg();
				$http_referer = APP_PATH.'index.php?m=pay&c=deposit&a=pay';
			} else {
				$msg = L('readpoint_pay_point',array('readpoint'=>$readpoint));
			}
		}
		showmessage($msg,$http_referer,3000);
	}
}
?>