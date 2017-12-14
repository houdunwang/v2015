<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
include("../class/db_sql.php");
include("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
$ecms=RepPostStr($_GET['ecms'],1);
$classid=RepPostStr($_GET['classid'],1);
$fcjsfile='../data/fc/cmsclass.js';
$do_class=GetFcfiletext($fcjsfile);
$do_class=str_replace("<option value='$classid'","<option value='$classid' selected",$do_class);
//增加信息页导航
if($ecms==1)
{
	//$show="增加信息：<select name=\\\"select\\\" onchange=\\\"if(this.options[this.selectedIndex].value!=0){self.location.href='AddNews.php?".$ecms_hashur['ehref']."&bclassid=&classid='+this.options[this.selectedIndex].value+'&enews=AddNews';}\\\"><option value='0'>选择增加信息的栏目</option>".$do_class."</select>";
	//echo"<script>parent.document.getElementById(\"showclassnav\").innerHTML=\"".$show."\";</script>";

	$show="<select name='copyclassid[]' id='copyclassid[]' size='12' style='width:320' multiple>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"copyinfoshowclassnav\").innerHTML=\"".$show."\";</script>";
}
//所有信息列表
elseif($ecms==2)
{
	$show="<select name='addclassid' id='addclassid'><option value='0'>选择增加信息的栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"showaddclassnav\").innerHTML=\"".$show."\";";

	$show="<select name='classid' id='classid'><option value='0'>所有栏目</option>".$do_class."</select>";
	echo"parent.document.getElementById(\"searchclassnav\").innerHTML=\"".$show."\";";

	$show="<select name='to_classid' id='to_classid'><option value='0'>选择要移动/复制的目标栏目</option>".$do_class."</select>";
	echo"parent.document.getElementById(\"moveclassnav\").innerHTML=\"".$show."\";</script>";
}
//信息列表
elseif($ecms==3)
{
	$show="<select name='to_classid' id='to_classid'><option value='0'>选择要移动/复制的目标栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"moveclassnav\").innerHTML=\"".$show."\";</script>";
}
//插入附件
elseif($ecms==4)
{
	$show="<select name='searchclassid' id='searchclassid'><option value='all'>所有栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"fileclassnav\").innerHTML=\"".$show."\";</script>";
}
//管理附件
elseif($ecms==5)
{
	$show="<select name='classid' id='classid'><option value='0'>所有栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"listfileclassnav\").innerHTML=\"".$show."\";</script>";
}
//管理评论
elseif($ecms==6)
{
	$show="<select name='classid' id='classid'><option value='0'>所有栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"listplclassnav\").innerHTML=\"".$show."\";</script>";
}
//选择关联字段
elseif($ecms==7)
{
	$show="<select name='addclassid' id='addclassid'><option value='0'>选择增加信息的栏目</option>".$do_class."</select>";
	echo"<script>parent.document.getElementById(\"showaddclassnav\").innerHTML=\"".$show."\";</script>";
}
db_close();
$empire=null;
?>