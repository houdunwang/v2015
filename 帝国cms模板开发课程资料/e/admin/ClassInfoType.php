<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
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
//验证权限
CheckLevel($logininid,$loginin,$classid,"class");

//设置栏目标题分类
function SetClassInfoType($add,$logininid,$loginin){
	global $empire,$dbtbpre;
    CheckLevel($logininid,$loginin,$classid,"class");//验证权限
	$classid=(int)$add['classid'];
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$cr=$empire->fetch1("select classid,modid,classname,islast from {$dbtbpre}enewsclass where classid='$classid'");
	if(!$cr['classid']||!$cr['islast']||!$cr['modid'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$noclassinfo=(int)$add['noclassinfo'];
	if($noclassinfo==1)
	{
		$ttids='-';
	}
	else
	{
		$typeid=$add['typeid'];
		$count=count($typeid);
		$ttids='';
		if($count)
		{
			$dh='';
			for($i=0;$i<$count;$i++)
			{
				$tid=(int)$typeid[$i];
				if(empty($tid))
				{
					continue;
				}
				$ttids.=$dh.$tid;
				$dh=',';
			}
			if($ttids)
			{
				$ttids=','.$ttids.',';
			}
		}
	}
	$sql=$empire->query("update {$dbtbpre}enewsclassadd set ttids='$ttids' where classid='$classid'");
	if($sql)
	{
		insert_dolog("classid=$classid&classname=$cr[classname]");//操作日志
		printerror("SetClassInfoTypeSuccess","ClassInfoType.php?classid=$classid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='SetClassInfoType')
{
	SetClassInfoType($_POST,$logininid,$loginin);
}

$classid=(int)$_GET['classid'];
if(!$classid)
{
	printerror("ErrorUrl","history.go(-1)");
}
$cr=$empire->fetch1("select classid,bclassid,modid,classname,islast from {$dbtbpre}enewsclass where classid='$classid'");
if(!$cr['classid']||!$cr['islast']||!$cr['modid'])
{
	printerror("ErrorUrl","history.go(-1)");
}
$caddr=$empire->fetch1("select ttids from {$dbtbpre}enewsclassadd where classid='$classid'");
$url=$cr['classname'].' &gt; 设置标题分类';
if($cr['bclassid'])
{
	$bcr=$empire->fetch1("select classid,classname from {$dbtbpre}enewsclass where classid='$cr[bclassid]'");
	$url=$bcr['classname'].' &gt; '.$url;
}
$sql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype where mid='$cr[modid]' order by myorder,typeid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>设置栏目标题分类</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  	for (var i=0;i<form.elements.length;i++)
    {
    	var e = form.elements[i];
    	if (e.name=='chkall'||e.name=='noclassinfo')
		{
	   	}
		else
		{
			e.checked = form.chkall.checked;
		}
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?>
      </td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ClassInfoType.php" onsubmit="return confirm('确认设置?');">
  <?=$ecms_hashur['form']?>
    <input type="hidden" name="enews" value="SetClassInfoType">
    <input type="hidden" name="classid" value="<?=$classid?>">
    <tr class="header"> 
      <td width="10%"><div align="center">选择 </div></td>
      <td width="59%" height="25"><div align="center">分类名称</div></td>
    </tr>
    <?php
  while($r=$empire->fetch($sql))
  {
  	$checked='';
	if(strstr($caddr['ttids'],','.$r['typeid'].','))
	{
		$checked=' checked';
	}
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <input name="typeid[]" type="checkbox" id="typeid[]" value="<?=$r['typeid']?>"<?=$checked?>>
        </div></td>
      <td height="25">
        <?=$r['tname']?>
        ( 
        <?=$r['typeid']?>
        )</td>
    </tr>
    <?php
  }
  db_close();
  $empire=null;
  ?>
    <tr bgcolor="#FFFFFF">
      <td><div align="center">
          <input name="noclassinfo" type="checkbox" id="noclassinfo" value="1"<?=$caddr['ttids']=='-'?' checked':''?>>
        </div></td>
      <td height="25"><strong>本栏目不使用标题分类</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25"><input type="submit" name="Submit" value="提 交"> &nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </form>
</table>
</body>
</html>
