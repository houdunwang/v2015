<?php
require("../../class/connect.php");
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
$enews=$_GET['enews'];
if($id&&$classid)
{
	include("../../class/db_sql.php");
	include("../../data/dbcache/class.php");
	include("../../class/q_functions.php");
	$link=db_connect();
	$empire=new mysqlquery();
	$editor=1;
	if(empty($class_r[$classid][tbname])||InfoIsInTable($class_r[$classid][tbname]))
	{
		printerror("ErrorUrl","",1);
    }
	//下一条记录
	if($enews=="next")
	{
		$where="id>$id and classid='$classid' order by id";
    }
	//上一条记录pre
	else
	{
		$where="id<$id and classid='$classid' order by id desc";
    }
	$r=$empire->fetch1("select isurl,titleurl,classid,id from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$where." limit 1");
	if(empty($r[id]))
	{
		printerror("NotNextInfo","",1);
    }
	$titleurl=sys_ReturnBqTitleLink($r);
	db_close();
	$empire=null;
	Header("Location:$titleurl");
}
?>