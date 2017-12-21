<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 短信验证接口
 */
 if($_GET['action']=='id_code') {
 	$sms_report_db = pc_base::load_model('sms_report_model');
	$mobile_verify = $_GET['mobile_verify'];
 	if(!$mobile_verify || preg_match("/[^a-z0-9]+/i",$mobile_verify)) exit();
	$mobile = $_GET['mobile'];
	if($mobile){
 		if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
		$posttime = SYS_TIME-600;
		$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
		$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
		if($r && $r['id_code']==$mobile_verify) {
			if($_GET['jscheck']!=1) {//验证通过后，将验证码置为空，防止重复利用！
				$sms_report_db->update(array('id_code'=>''),$where);
			}
			exit('1');
		} else {
			exit('0');
		}
	}else{
		/*用户自发短信验证判断，不再传递mobile值，只判断10分钟内这个验证码是否存在，存在即认为此码对应的手机号为你所有*/
		$posttime = SYS_TIME-600;
		$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
		$r = $sms_report_db->get_one($where,'id_code','id DESC');
		if(is_array($r)){
 			exit('1');
		}else{
			exit('0');
		}
  	}
}	