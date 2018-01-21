<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 短信发送接口
 */
pc_base::load_app_class('smsapi', 'sms', 0); //引入smsapi类
$sms_report_db = pc_base::load_model('sms_report_model');
$mobile = $_GET['mobile'];
$siteid = $_REQUEST['siteid'] ? $_REQUEST['siteid'] : 1;
$sms_setting = getcache('sms','sms');
$sitelist = getcache('sitelist', 'commons');
$sitename = $sitelist[$siteid]['name'];
if(!preg_match('/^1([0-9]{9})/',$mobile)) exit('mobile phone error');
if(intval($sms_setting[$siteid]['sms_enable']) == 0) exit(1); //短信功能关闭

//检查一个小时内发短信次数是还超过3次
$posttime = SYS_TIME-3600;
$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num > 2) {
	exit(1);//一小时内发送短信数量超过限制 3 条
}

$sms_uid = $sms_setting[$siteid]['userid'];//短信接口用户ID
$sms_pid = $sms_setting[$siteid]['productid'];//产品ID
$sms_passwd = $sms_setting[$siteid]['sms_key'];//32位密码
$smsapi = new smsapi($sms_uid, $sms_pid, $sms_passwd); //初始化接口类

$id_code = random(6);//唯一吗，用于扩展验证
$send_txt = '尊敬的用户您好，您在'.$sitename.'的注册验证码为：'.$id_code.'，验证码有效期为5分钟。'; 
$content = safe_replace($send_txt);
$sent_time = intval($_POST['sendtype']) == 2 && !empty($_POST['sendtime'])  ? trim($_POST['sendtime']) : date('Y-m-d H:i:s',SYS_TIME);
$smsapi->send_sms($mobile, $content, $sent_time, CHARSET,$id_code); //发送短信
exit(1);
?>