<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
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
CheckLevel($logininid,$loginin,$classid,"task");

//返回秒组合
function ReturnTogMins($min){
	$count=count($min);
	if($count==0)
	{
		return ',';
	}
	$str=',';
	for($i=0;$i<$count;$i++)
	{
		$str.=$min[$i].',';
	}
	return $str;
}

//增加计划任务
function AddTask($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add['taskname'])||empty($add['filename']))
	{
		printerror('EmptyTaskname','');
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"task");
	if(strstr($add['filename'],'/')||strstr($add['filename'],"\\"))
	{
		printerror('ErrorTaskFilename','');
	}
	$userid=(int)$add['userid'];
	$isopen=(int)$add['isopen'];
	$add['dominute']=ReturnTogMins($add['min']);
	$sql=$empire->query("insert into {$dbtbpre}enewstask(taskname,userid,isopen,filename,lastdo,doweek,doday,dohour,dominute) values('$add[taskname]',$userid,$isopen,'$add[filename]',0,'$add[doweek]','$add[doday]','$add[dohour]','$add[dominute]');");
	if($sql)
	{
		$id=$empire->lastid();
		//操作日志
		insert_dolog("id=$id&taskname=$add[taskname]&filename=$add[filename]");
		printerror('AddTaskSuccess','AddTask.php?enews=AddTask'.hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror('DbError',"");
	}
}

//修改计划任务
function EditTask($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$add['id'];
	if(!$id||empty($add['taskname'])||empty($add['filename']))
	{
		printerror('EmptyTaskname','');
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"task");
	if(strstr($add['filename'],'/')||strstr($add['filename'],"\\"))
	{
		printerror('ErrorTaskFilename','');
	}
	$userid=(int)$add['userid'];
	$isopen=(int)$add['isopen'];
	$add['dominute']=ReturnTogMins($add['min']);
	$sql=$empire->query("update {$dbtbpre}enewstask set taskname='$add[taskname]',userid=$userid,isopen=$isopen,filename='$add[filename]',doweek='$add[doweek]',doday='$add[doday]',dohour='$add[dohour]',dominute='$add[dominute]' where id=$id");
	if($sql)
	{
		//操作日志
		insert_dolog("id=$id&taskname=$add[taskname]&filename=$add[filename]");
		printerror('EditTaskSuccess','ListTask.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError',"");
	}
}

//删除计划任务
function DelTask($add,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$add['id'];
	if(!$id)
	{
		printerror('EmptyDelTaskId','');
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"task");
	$r=$empire->fetch1("select taskname,filename from {$dbtbpre}enewstask where id=$id");
	$sql=$empire->query("delete from {$dbtbpre}enewstask where id=$id");
	if($sql)
	{
		//操作日志
		insert_dolog("id=$id&taskname=$r[taskname]&filename=$r[filename]");
		printerror('DelTaskSuccess','ListTask.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError',"");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}

if($enews=="AddTask")
{
	AddTask($_POST,$logininid,$loginin);
}
elseif($enews=="EditTask")
{
	EditTask($_POST,$logininid,$loginin);
}
elseif($enews=="DelTask")
{
	DelTask($_GET,$logininid,$loginin);
}
else
{}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=20;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select id,taskname,isopen,lastdo,doweek,doday,dohour,dominute from {$dbtbpre}enewstask";
$totalquery="select count(*) as total from {$dbtbpre}enewstask";
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理计划任务</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置：<a href='ListTask.php<?=$ecms_hashur['whehref']?>'>管理计划任务</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="增加计划任务" onclick="self.location.href='AddTask.php?enews=AddTask<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
		<input type="button" name="Submit" value="运行计划任务页面" onclick="window.open('../task.php<?=$ecms_hashur['whhref']?>');">
      </div></td>
  </tr>
</table>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="25%" height="25"> <div align="center">任务名称</div></td>
    <td width="15%" height="25"> 
      <div align="center">分钟</div></td>
    <td width="5%">
<div align="center">小时</div></td>
    <td width="5%">
<div align="center">星期</div></td>
    <td width="5%"><div align="center">日</div></td>
    <td width="17%"><div align="center">最后执行时间</div></td>
    <td width="5%"><div align="center">状态</div></td>
    <td width="17%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  	$r['doweek']=','.$r['doweek'].','!=',*,'&&$r['doweek']==0?7:$r['doweek'];
	$lastdo=$r['lastdo']?date("Y-m-d H:i",$r['lastdo']):'---';
	if(strlen($r['dominute'])>26)
	{
		$r['dominute']=substr($r['dominute'],0,23).'...';
	}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r['id']?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r['taskname']?>
      </div></td>
    <td height="25"><div align="center"><?=$r['dominute']?></div></td>
    <td><div align="center"><?=$r['dohour']?></div></td>
    <td><div align="center"><?=$r['doweek']?></div></td>
    <td><div align="center"><?=$r['doday']?></div></td>
    <td><div align="center"><?=$lastdo?></div></td>
    <td><div align="center"><?=$r['isopen']==1?'开启':'关闭'?></div></td>
    <td height="25"> <div align="center">[<a href="../task.php?ecms=TodoTask&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要执行?');">执行</a>] 
        [<a href="AddTask.php?enews=EditTask&id=<?=$r[id]?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="ListTask.php?enews=DelTask&id=<?=$r[id]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="9">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
