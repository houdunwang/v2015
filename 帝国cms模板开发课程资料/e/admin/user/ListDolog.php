<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/enews.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
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
CheckLevel($logininid,$loginin,$classid,"log");

//删除日志
function DelDoLog($logid,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"log");
	$logid=(int)$logid;
	if(!$logid)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsdolog where logid='$logid'");
	if($sql)
	{
		//操作日志
		insert_dolog("logid=".$logid);
		printerror("DelLogSuccess","ListDolog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量删除日志
function DelDoLog_all($logid,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"log");
	$count=count($logid);
	if(!$count)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$add.=" logid='".intval($logid[$i])."' or";
	}
	$add=substr($add,0,strlen($add)-3);
	$sql=$empire->query("delete from {$dbtbpre}enewsdolog where".$add);
	if($sql)
	{
		//操作日志
		insert_dolog("");
		printerror("DelLogSuccess","ListDolog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//日期删除日志
function DelDoLog_date($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"log");
	$start=RepPostVar($add['startday']);
	$end=RepPostVar($add['endday']);
	if(!$start||!$end)
	{
		printerror('EmptyDelLogTime','');
	}
	$startday=$start.' 00:00:00';
	$endday=$end.' 23:59:59';
	$sql=$empire->query("delete from {$dbtbpre}enewsdolog where logtime<='$endday' and logtime>='$startday'");
	if($sql)
	{
		//操作日志
		insert_dolog("time=".$start."~".$end);
		printerror("DelLogSuccess","ListDolog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//删除日志
if($enews=="DelDoLog")
{
	$logid=$_GET['logid'];
	DelDoLog($logid,$logininid,$loginin);
}
//批量删除日志
elseif($enews=="DelDoLog_all")
{
	$logid=$_POST['logid'];
	DelDoLog_all($logid,$logininid,$loginin);
}
elseif($enews=="DelDoLog_date")
{
	DelDoLog_date($_POST,$logininid,$loginin);
}

$line=20;//每页显示条数
$page_line=18;//每页显示链接数
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;//总偏移量
//搜索
$search='';
$search.=$ecms_hashur['ehref'];
$where='';
$and=' where ';
//信息ID
$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
if($classid&&$id)
{
	$pubid=ReturnInfoPubid($classid,$id);
	$where.=$and."pubid='$pubid'";
	$and=' and ';
	$search.="&classid=$classid&id=$id";
}
if($_GET['sear']==1)
{
	$search.="&sear=1";
	$startday=RepPostVar($_GET['startday']);
	$endday=RepPostVar($_GET['endday']);
	if($startday&&$endday)
	{
		$where.=$and."logtime<='".$endday." 23:59:59' and logtime>='".$startday." 00:00:00'";
		$and=' and ';
		$search.="&startday=$startday&endday=$endday";
	}
	$keyboard=RepPostVar($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$where.=$and."username like '%$keyboard%'";
		}
		elseif($show==2)
		{
			$where.=$and."logip like '%$keyboard%'";
		}
		else
		{
			$where.=$and."(username like '%$keyboard%' or logip like '%$keyboard%')";
		}
		$and=' and ';
		$search.="&keyboard=$keyboard&show=$show";
	}
}
$search2=$search;
//排序
$mydesc=(int)$_GET['mydesc'];
$desc=$mydesc?'asc':'desc';
$orderby=(int)$_GET['orderby'];
if($orderby==1)//登陆用户
{
	$order="username ".$desc.",logid desc";
	$usernamedesc=$mydesc?0:1;
}
elseif($orderby==2)//IP
{
	$order="logip ".$desc.",logid desc";
	$logipdesc=$mydesc?0:1;
}
elseif($orderby==3)//操作时间
{
	$order="logtime ".$desc.",logid desc";
	$logtimedesc=$mydesc?0:1;
}
else//ID
{
	$order="logid ".$desc;
	$logiddesc=$mydesc?0:1;
}
$search.="&orderby=$orderby&mydesc=$mydesc";
$query="select logid,logip,logtime,username,enews,doing,ipport from {$dbtbpre}enewsdolog".$where;
$totalquery="select count(*) as total from {$dbtbpre}enewsdolog".$where;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by ".$order." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<html>
<head>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css"> 
<title>管理登陆日志</title>
<script src="../ecmseditor/fieldfile/setday.js"></script>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置：日志管理 &gt; <a href="ListDolog.php<?=$ecms_hashur['whehref']?>">管理操作日志</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="管理登陆日志" onclick="self.location.href='ListLog.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" align=center cellpadding=0 cellspacing=0>
  <form name=searchlogform method=get action='ListDolog.php'>
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25"> <div align="center">时间从 
          <input name="startday" type="text" value="<?=$startday?>" size="12" onclick="setday(this)">
          到 
          <input name="endday" type="text" value="<?=$endday?>" size="12" onclick="setday(this)">
          ，关键字： 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>不限</option>
            <option value="1"<?=$show==1?' selected':''?>>用户名</option>
            <option value="2"<?=$show==2?' selected':''?>>登陆IP</option>
          </select>
          栏目ID：
          <input name="classid" type="text" id="classid" value="<?=$classid?>" size="10">
          信息ID：
          <input name="id" type="text" id="id" value="<?=$id?>" size="10">
          <input name=submit1 type=submit id="submit12" value=搜索>
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name="form2" method="post" action="ListDolog.php" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="8%"> 
        <div align="center"><a href="ListDolog.php?orderby=0&mydesc=<?=$logiddesc.$search2?>">ID</a></div></td>
      <td width="24%" height="25"> 
        <div align="center"><a href="ListDolog.php?orderby=1&mydesc=<?=$usernamedesc.$search2?>">操作者</a></div></td>
      <td width="23%" height="25"> 
        <div align="center"><a href="ListDolog.php?orderby=2&mydesc=<?=$logipdesc.$search2?>">IP</a></div></td>
      <td width="27%"> 
        <div align="center"><a href="ListDolog.php?orderby=3&mydesc=<?=$logtimedesc.$search2?>">操作时间</a></div></td>
      <td width="18%" height="25"> 
        <div align="center">删除</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  ?>
    <tr bgcolor="#DBEAF5" id=log<?=$r[logid]?>> 
      <td> 
        <div align="center"><?=$r[logid]?></div></td>
      <td height="25"> 
        <div align="center"> 
          <?=$r[username]?>
        </div></td>
      <td height="25"> 
        <div align="center"> 
          <?=$r[logip]?>:<?=$r[ipport]?>
        </div></td>
      <td> 
        <div align="center"> 
          <?=$r[logtime]?>
        </div></td>
      <td height="25"> 
        <div align="center">[<a href="ListDolog.php?enews=DelDoLog&logid=<?=$r[logid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除此日志?');">删除</a> 
          <input name="logid[]" type="checkbox" id="logid[]" value="<?=$r[logid]?>" onclick="if(this.checked){log<?=$r[logid]?>.style.backgroundColor='#cccccc';}else{log<?=$r[logid]?>.style.backgroundColor='#DBEAF5';}">
          ]</div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="5"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td width="9%">动作：</td>
            <td width="25%"><?=$enews_r[$r[enews]]?></td>
            <td width="10%">操作对像：</td>
            <td width="56%"><?=$r[doing]?></td>
          </tr>
        </table></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="5"> 
        <?=$returnpage?>&nbsp;&nbsp;
        <input type="submit" name="Submit" value="批量删除"> <input name="enews" type="hidden" id="phome" value="DelDoLog_all">&nbsp;
        <input type=checkbox name=chkall value=on onClick=CheckAll(this.form)>
        选中全部 </td>
    </tr>
  </table>
</form>
<form action="ListDolog.php" method="post" name="dellogform" id="dellogform" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td><div align="center">
          <input name="enews" type="hidden" id="enews" value="DelDoLog_date">
          删除从 
          <input name="startday" type="text" id="startday" onclick="setday(this)" value="<?=$startday?>" size="12">
          到 
          <input name="endday" type="text" id="endday" onclick="setday(this)" value="<?=$endday?>" size="12">
          之间的日志
<input type="submit" name="Submit2" value="提交">
          </div></td>
    </tr>
  </table>
</form>
<?
db_close();
$empire=null;
?>
</body>
</html>