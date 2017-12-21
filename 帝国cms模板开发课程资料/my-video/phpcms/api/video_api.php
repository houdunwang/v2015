<?php
/**
 * 视频通知接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

$video_setting = getcache('video','video');

//新增，跳转完善资料  -- 增加人：wgq
$pc_hash = htmlspecialchars($_GET['pc_hash']);
if(!empty($_GET['do_complete']) && !empty($_GET['uid']) && !empty($_GET['snid'])){
	//验证sndaid
	$sndaid = floor(floatval($_GET['snid']));
	if(empty($sndaid)){
		showmessage("请通正常路径访问网站！",APP_PATH);
	}
	showmessage("请完善注册信息资料！",APP_PATH.'index.php?m=video&c=video&a=complete_info&uid='.floor(floatval($_GET['uid'])).'&snid='.$sndaid.'&pc_hash='.$pc_hash);
}

if(!empty($_GET['skey']) && !empty($_GET['sn'])){
	header("Location: ".APP_PATH.'index.php?m=video&c=video&a=set_video_setting&skey='.$_GET['skey'].'&sn='.$_GET['sn'].'&pc_hash='.$pc_hash); 
}


if(empty($_POST['sn']) || $_POST['sn'] != $video_setting['sn']) {
	echo json_encode(array('msg'=>'Authentication Failed','code'=>'-1'));
	exit;
}
$xxtea = pc_base::load_app_class('xxtea', 'video');
$token = $_POST['token'];
$decode_token = $xxtea->decrypt($token,$video_setting['skey']);
if(empty($_POST['posttime']) || $decode_token != $_POST['posttime']) {
	echo json_encode(array('msg'=>'Authentication Failed','code'=>'-2'));
	exit;
}
$action = $_POST['action'];
if(isset($_GET['action'])) $action = 'ping';

if (!preg_match('/([^a-z_]+)/i',$action) && file_exists(PHPCMS_PATH.'api/video_api/'.$action.'.php')) {
	include PHPCMS_PATH.'api/video_api/'.$action.'.php';
} else {
	exit('Video action does not exist');
}
?>