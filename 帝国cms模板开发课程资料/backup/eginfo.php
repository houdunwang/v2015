<?php
require('class/connect.php');
require('class/functions.php');
$lur=islogin();
$loginin=$lur['username'];
$rnd=$lur['rnd'];
include('class/eginfofun.php');
$phome=$_GET['phome'];
$testcjst=0;
if($phome=='TestCj')//╡Бйт╡и╪╞
{
	$testcjst=EGInfo_TestCj();
}
elseif($phome=='ShowPHPInfo')
{
	@phpinfo();
	exit();
}
else
{}

include LoadAdminTemp('eeginfo.php');
?>