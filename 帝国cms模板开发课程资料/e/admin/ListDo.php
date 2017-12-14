<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"do");

//组合栏目
function AddDoTogClassid($classid){
	$count=count($classid);
	$class=',';
	for($i=0;$i<$count;$i++)
	{
		$class.=intval($classid[$i]).',';
	}
	return $class;
}

//增加刷新任务
function AddDo($add,$userid,$username){
	global $empire,$dbtbpre;
	$count=count($add[classid]);
	if(empty($add[doname])||($add[doing]&&!$count))
	{
		printerror("EmptyDoname","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"do");
	if($add[dotime]<5)
	{
		$add[dotime]=5;
	}
	$lasttime=time();
	//变量处理
	$add[dotime]=(int)$add[dotime];
	$add[isopen]=(int)$add[isopen];
	$add[doing]=(int)$add[doing];
	$classid=AddDoTogClassid($add[classid]);
	$sql=$empire->query("insert into {$dbtbpre}enewsdo(doname,dotime,isopen,doing,classid,lasttime) values('$add[doname]',$add[dotime],$add[isopen],$add[doing],'$classid',$lasttime);");
	$doid=$empire->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("doid=$doid&doname=$add[doname]");
		printerror("AddDoSuccess","AddDo.php?enews=AddDo".hReturnEcmsHashStrHref2(0));
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//修改刷新任务
function EditDo($add,$userid,$username){
	global $empire,$dbtbpre;
	$count=count($add[classid]);
	if(empty($add[doname])||($add[doing]&&!$count))
	{
		printerror("EmptyDoname","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"do");
	if($add[dotime]<5)
	{
		$add[dotime]=5;
	}
	//变量处理
	$add[dotime]=(int)$add[dotime];
	$add[isopen]=(int)$add[isopen];
	$add[doing]=(int)$add[doing];
	$classid=AddDoTogClassid($add[classid]);
	$sql=$empire->query("update {$dbtbpre}enewsdo set doname='$add[doname]',dotime=$add[dotime],isopen=$add[isopen],doing=$add[doing],classid='$classid' where doid='$add[doid]'");
	if($sql)
	{
		//操作日志
		insert_dolog("doid=$add[doid]&doname=$add[doname]");
		printerror("EditDoSuccess","ListDo.php".hReturnEcmsHashStrHref2(1));
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//删除刷新任务
function DelDo($doid,$userid,$username){
	global $empire,$dbtbpre;
	$doid=(int)$doid;
	if(empty($doid))
	{printerror("EmptyDoid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"do");
	$r=$empire->fetch1("select doname from {$dbtbpre}enewsdo where doid='$doid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsdo where doid='$doid'");
	if($sql)
	{
		//操作日志
		insert_dolog("doid=$doid&doname=$r[doname]");
		printerror("EditDoSuccess","ListDo.php".hReturnEcmsHashStrHref2(1));
    }
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加刷新任务
if($enews=="AddDo")
{
	$add=$_POST;
	AddDo($add,$logininid,$loginin);
}
//修改刷新任务
elseif($enews=="EditDo")
{
	$add=$_POST;
	EditDo($add,$logininid,$loginin);
}
//删除刷新任务
elseif($enews=="DelDo")
{
	$doid=$_GET['doid'];
	DelDo($doid,$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select * from {$dbtbpre}enewsdo";
$num=$empire->num($query);//取得总条数
$query=$query." order by doid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理刷新任务</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置：<a href="ListDo.php<?=$ecms_hashur['whehref']?>">管理定时刷新任务</a></td>
    <td> <div align="right" class="emenubutton">
        <input type="button" name="Submit" value="增加刷新任务" onclick="self.location.href='AddDo.php?enews=AddDo<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="46%" height="25"> <div align="center">任务名</div></td>
    <td width="8%"><div align="center">时间间隔</div></td>
    <td width="18%"><div align="center">最后执行时间</div></td>
    <td width="8%" height="25"> <div align="center">开启</div></td>
    <td width="14%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  if($r[isopen])
  {$isopen="开启";}
  else
  {$isopen="关闭";}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[doid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[doname]?>
      </div></td>
    <td><div align="center">
        <?=$r[dotime]?>
      </div></td>
    <td><div align="center"> 
        <?=date("Y-m-d H:i:s",$r[lasttime])?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$isopen?>
      </div></td>
    <td height="25"> <div align="center">[<a href="AddDo.php?enews=EditDo&doid=<?=$r[doid]?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="ListDo.php?enews=DelDo&doid=<?=$r[doid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25" colspan="6"><font color="#666666">说明：执行定时刷新任务需要开着后台或者<a href="DoTimeRepage.php<?=$ecms_hashur['whehref']?>" target="_blank"><strong>点击这里</strong></a>开着这个页面才会执行。</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
