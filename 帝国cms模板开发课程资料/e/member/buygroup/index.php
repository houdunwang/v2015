<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../class/user.php");
require("../../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
//是否登陆
$user=islogin();
$query="select * from {$dbtbpre}enewsbuygroup order by myorder,id";
$sql=$empire->query($query);
//支付平台
$paysql=$empire->query("select payid,paytype,payfee,paysay,payname from {$dbtbpre}enewspayapi where isclose=0 order by myorder,payid");
$pays='';
while($payr=$empire->fetch($paysql))
{
	$pays.="<option value='".$payr[payid]."'>".$payr[payname]."</option>";
}
//导入模板
require(ECMS_PATH.'e/template/member/buygroup.php');
db_close();
$empire=null;
?>