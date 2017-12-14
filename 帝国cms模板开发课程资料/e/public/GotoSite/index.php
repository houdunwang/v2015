<?php
require("../../class/connect.php");
$lid=(int)$_GET['lid'];
if($lid)
{
	include("../../class/db_sql.php");
	$link=db_connect();
	$empire=new mysqlquery();
	$editor=1;
	$r=$empire->fetch1("select lurl from {$dbtbpre}enewslink where lid='$lid'");
	if(empty($r[lurl]))
	{
		printerror("ErrorUrl","",1);
	}
	$sql=$empire->query("update {$dbtbpre}enewslink set onclick=onclick+1 where lid='$lid'");
	$url=$r[lurl];
	db_close();
	$empire=null;
	Header("Location:$url");
}
?>