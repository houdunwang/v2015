<?php
require('../../class/connect.php');
require('../../class/db_sql.php');

if($public_r['onclicktype']==2)
{
	exit();
}

$link=db_connect();
$empire=new mysqlquery();
require('../../class/onclickfun.php');
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
$ztid=(int)$_GET['ztid'];
$enews=$_GET['enews'];
if($enews=='donews')//信息点击
{
	InfoOnclick($classid,$id);
}
elseif($enews=='doclass')//栏目点击
{
	ClassOnclick($classid);
}
elseif($enews=='dozt')//专题点击
{
	ZtOnclick($ztid);
}
db_close();
$empire=null;
?>