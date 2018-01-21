<?php
require("../../class/connect.php");
$adid=(int)$_GET['adid'];
if(!$adid)
{
	echo"<script>alert('error');history.go(-1);</script>";
    exit();
}
require("../../class/db_sql.php");
$link=db_connect();
$empire=new mysqlquery();
$r=$empire->fetch1("select url,adid from {$dbtbpre}enewsad where adid='$adid'");
if(empty($r[adid]))
{
	echo"<script>alert('error');history.go(-1);</script>";
	exit();
}
$url=$r[url];
$empire->query("update {$dbtbpre}enewsad set onclick=onclick+1 where adid='$adid'");
db_close();
$empire=null;
Header("Location:$url");
?>
