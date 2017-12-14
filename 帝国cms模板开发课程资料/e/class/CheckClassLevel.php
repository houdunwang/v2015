<?php
if(!defined('empirecms'))
{
	exit();
}
//扣点
require_once($check_path."e/class/connect.php");
if(!defined('InEmpireCMS'))
{
	exit();
}
require_once(ECMS_PATH."e/class/db_sql.php");
$check_classid=(int)$check_classid;
$toreturnurl=eReturnSelfPage(0);	//返回页面地址
$gotourl=$ecms_config['member']['loginurl']?$ecms_config['member']['loginurl']:$public_r['newsurl']."e/member/login/";	//登陆地址
$loginuserid=(int)getcvar('mluserid');
$logingroupid=(int)getcvar('mlgroupid');
if(!$loginuserid)
{
	printerror2('本栏目需要会员级别以上才能查看','');
}
if(!strstr($check_groupid,','.$logingroupid.','))
{
	printerror2('您没有足够权限查看此栏目','');
}
?>