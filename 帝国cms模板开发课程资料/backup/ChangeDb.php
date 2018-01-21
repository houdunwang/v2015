<?php
require('class/connect.php');
require('class/functions.php');
require LoadLang('f.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$link=db_connect();
$empire=new mysqlquery();
//Ä¬ÈÏÊý¾Ý¿â
if(!empty($phome_db_dbname))
{
	echo $fun_r['GotoDefaultDb']."<script>self.location.href='ChangeTable.php?mydbname=".$phome_db_dbname."'</script>";
	exit();
}
$sql=$empire->query("SHOW DATABASES");
require LoadAdminTemp('eChangeDb.php');
db_close();
$empire=null;
?>