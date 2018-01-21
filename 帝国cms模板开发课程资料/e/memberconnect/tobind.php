<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../member/class/user.php");
eCheckCloseMods('member');//关闭模块
eCheckCloseMods('mconnect');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
eCheckCloseMemberConnect();//验证开启的接口
session_start();
require('memberconnectfun.php');

$apptype=RepPostVar($_SESSION['apptype']);
$openid=RepPostVar($_SESSION['openid']);
if(!trim($apptype)||!trim($openid))
{
	printerror2('来自的链接不存在','../../../');
}
$appr=MemberConnect_CheckApptype($apptype);//验证登录方式
MemberConnect_CheckBindKey($apptype,$openid);

//导入模板
require(ECMS_PATH.'e/template/memberconnect/tobind.php');
db_close();
$empire=null;
?>