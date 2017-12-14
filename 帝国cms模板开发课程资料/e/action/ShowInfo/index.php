<?php
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
require('../../class/t_functions.php');
require '../'.LoadLang('pub/fun.php');
require('../../data/dbcache/class.php');
require('../../data/dbcache/MemberLevel.php');
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
//内部表
if(!$classid||!$id||!$class_r[$classid]['tbname']||InfoIsInTable($class_r[$classid]['tbname'])||Moreport_ReturnMustDt())//moreport
{
	printerror('ErrorUrl','history.go(-1)',1);
}
$addgethtmlpath='../';
$titleurl=DoGetHtml($classid,$id);
db_close();
$empire=null;
Header("Location:$titleurl");
?>