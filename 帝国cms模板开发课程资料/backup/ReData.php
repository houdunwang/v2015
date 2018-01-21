<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
$link=db_connect();
$empire=new mysqlquery();
$mypath=$_GET['mypath'];
$mydbname=$_GET['mydbname'];
$selectdbname=$phome_db_dbname;
if($mydbname)
{
	$selectdbname=$mydbname;
}
$db='';
if($canlistdb)
{
	$db.="<option value='".$selectdbname."' selected>".$selectdbname."</option>";
}
else
{
	$sql=$empire->query("SHOW DATABASES");
	while($r=$empire->fetch($sql))
	{
		if($ebak_set_hidedbs&&stristr(','.$ebak_set_hidedbs.',',','.$r[0].','))
		{
			continue;
		}
		if($r[0]==$selectdbname)
		{$select=" selected";}
		else
		{$select="";}
		$db.="<option value='".$r[0]."'".$select.">".$r[0]."</option>";
	}
}
require LoadAdminTemp('eReData.php');
db_close();
$empire=null;
?>