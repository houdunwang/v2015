<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit('-1');
$password = isset($_GET['password']) && trim($_GET['password']) ? trim($_GET['password']) : exit('-1');
$url = isset($_GET['url']) && trim($_GET['url']) ? trim(urldecode($_GET['url'])) : exit('-1');
$name = isset($_GET['name']) && trim($_GET['name']) ? trim($_GET['name']) : exit('-1');
$authkey = isset($_GET['authkey']) && trim($_GET['authkey']) ? trim($_GET['authkey']) : exit('-1');
$apifilename = isset($_GET['apifilename']) && trim($_GET['apifilename']) ? trim($_GET['apifilename']) : exit('-1');
$charset = isset($_GET['charset']) && trim($_GET['charset']) ? trim($_GET['charset']) : exit('-1');
$type = isset($_GET['type']) && trim($_GET['type']) ? trim($_GET['type']) : 'other';
$synlogin = isset($_GET['synlogin']) && trim($_GET['synlogin']) ? trim($_GET['synlogin']) : '1';
if(file_exists(CACHE_PATH.'phpsso_install.lock')) {
	exit('-4');
} else {
	@file_put_contents(CACHE_PATH.'phpsso_install.lock', '1');
}

$db = pc_base::load_model('admin_model');
$memberinfo = $db->get_one(array('username'=>$username));
if(!empty($memberinfo)) {
	if(md5(md5($password).$memberinfo['encrypt']) == $memberinfo['password']) {
		$appdb = pc_base::load_model('applications_model');
		$appdata['authkey'] = $authkey;
		$appdata['apifilename'] = $apifilename;
		$appdata['charset'] = $charset;
		$appdata['type'] = $type;
		$appdata['synlogin'] = $synlogin;
		$appdata['url'] = $url;
		$appdata['name'] = $name;
	
		$appid = $appdb->insert($appdata, 1);
		
		if($appid > 0) {
			$applist = $appdb->listinfo('', '', 1, 100, 'appid');
			setcache('applist', $applist, 'admin');
			echo $appid;
			unset($_SESSION['_is_dos']);
			exit;
		} else {
			exit('-3');
		}
	} else {
		$try_num = $_SESSION['_is_dos'];
		if($try_num){
			if($try_num>15){
				showmessage('try_again', APP_PATH);
			}
			$try_num = $try_num + 1;
			$_SESSION['_is_dos'] = $try_num + 1; 
		}else{
			$_SESSION['_is_dos'] = 1;
		}
		exit('-2');
	}
} else {
	exit('-2');
}
?>