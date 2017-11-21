<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 短信发送接口
 */

$sms_report_db = pc_base::load_model('sms_report_model');
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);

if(empty($_SESSION['code'])) exit('-100');
if(empty($_GET['session_code']) || preg_match('/^([a-z0-9])$/i',$_GET['session_code']) || $_SESSION['code']!=$_GET['session_code']) exit('-101');

if(isset($_GET['mobile']) && !empty($_GET['mobile'])) {
	$mobile = $_GET['mobile'];
} else {
	$mobile = $_SESSION['mobile'];
}
$_SESSION['code'] = '';
if(!isset($_SESSION['csms'])) {
	$_SESSION['csms'] = 0;
} elseif($_SESSION['csms'] > 3) {
	exit('-1');
}
$_SESSION['csms'] += 1;

$siteid = get_siteid() ? get_siteid() : 1 ;
$sms_setting = getcache('sms','sms');
if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) exit('mobile phone error');
$posttime = SYS_TIME-86400;
$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num > 3) {
	exit('-1');//当日发送短信数量超过限制 3 条
}
//同一IP 24小时允许请求的最大数
$allow_max_ip = 10;//正常注册相当于 10 个人
$ip = ip();
$where = "`ip`='$ip' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num >= $allow_max_ip) {
	exit('-3');//当日单IP 发送短信数量超过 $allow_max_ip
}
if(intval($sms_setting[$siteid]['sms_enable']) == 0) exit('-99'); //短信功能关闭


$sms_uid = $sms_setting[$siteid]['userid'];//短信接口用户ID
$sms_pid = $sms_setting[$siteid]['productid'];//产品ID
$sms_passwd = $sms_setting[$siteid]['sms_key'];//32位密码

$posttime = SYS_TIME-600;
$rs = $sms_report_db->get_one("`mobile`='$mobile' AND `posttime`>'$posttime'");
if($rs['id_code']) {
	$id_code = $rs['id_code'];
} else {
	$id_code = random(6);//唯一吗，用于扩展验证
}
//$send_txt = '尊敬的用户您好，您在'.$sitename.'的注册验证码为：'.$id_code.'，验证码有效期为5分钟。';
$send_txt = $id_code;

$send_userid = intval($_GET['send_userid']);//操作者id

pc_base::load_app_class('smsapi', 'sms', 0); //引入smsapi类

$smsapi = new smsapi($sms_uid, $sms_pid, $sms_passwd); //初始化接口类
//$smsapi->get_price(); //获取短信剩余条数和限制短信发送的ip地址
$mobile = explode(',',$mobile);

$tplid = 1;
$sent_time = intval($_POST['sendtype']) == 2 && !empty($_POST['sendtime'])  ? trim($_POST['sendtime']) : date('Y-m-d H:i:s',SYS_TIME);
$smsapi->send_sms($mobile, $send_txt, $sent_time, CHARSET,$id_code,$tplid); //发送短信
echo 0;
?>