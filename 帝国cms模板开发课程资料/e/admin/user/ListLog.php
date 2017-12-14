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
CheckLevel($logininid,$loginin,$classid,"log");

//删除日志
function DelLog($loginid,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"log");
	$loginid=(int)$loginid;
	if(!$loginid)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewslog where loginid='$loginid'");
	if($sql)
	{
		//操作日志
		insert_dolog("loginid=".$loginid);
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量删除日志
function DelLog_all($loginid,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"log");
	$count=count($loginid);
	if(!$count)
	{
		printerror("NotDelLogid","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$add.=" loginid='".intval($loginid[$i])."' or";
	}
	$add=substr($add,0,strlen($add)-3);
	$sql=$empire->query("delete from {$dbtbpre}enewslog where".$add);
	if($sql)
	{
		//操作日志
		insert_dolog("");
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//日期删除日志
function DelLog_date($add,$userid,$username){
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
	$sql=$empire->query("delete from {$dbtbpre}enewslog where logintime<='$endday' and logintime>='$startday'");
	if($sql)
	{
		//操作日志
		insert_dolog("time=".$start."~".$end);
		printerror("DelLogSuccess","ListLog.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//补零
function ToAddDateZero($n){
	if($n<10)
	{
		$n='0'.$n;
	}
	return $n;
}

//返回日期
function ReturnLogSelectDate($y,$m,$d){
	//年
	if(empty($y))
	{
		$y=date("Y");
	}
	for($i=2003;$i<=$thisyear+1;$i++)
	{
		$selected='';
		if($i==$y)
		{
			$selected=' selected';
		}
		$r['year'].="<option value='".$i."'".$selected.">".$i."</option>";
	}
	//月
	if(empty($m))
	{
		$m=date("m");
	}
	for($i=1;$i<=12;$i++)
	{
		$selected='';
		$mi=ToAddDateZero($i);
		if($mi==$m)
		{
			$selected=' selected';
		}
		$r['month'].="<option value='".$mi."'".$selected.">".$mi."</option>";
	}
	//日
	if(empty($d))
	{
		$d=date("d");
	}
	for($i=1;$i<=31;$i++)
	{
		$selected='';
		$di=ToAddDateZero($i);
		if($di==$d)
		{
			$selected=' selected';
		}
		$r['day'].="<option value='".$di."'".$selected.">".$di."</option>";
	}
	return $r;
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//删除日志
if($enews=="DelLog")
{
	$loginid=$_GET['loginid'];
	DelLog($loginid,$logininid,$loginin);
}
//批量删除日志
elseif($enews=="DelLog_all")
{
	$loginid=$_POST['loginid'];
	DelLog_all($loginid,$logininid,$loginin);
}
elseif($enews=="DelLog_date")
{
	DelLog_date($_POST,$logininid,$loginin);
}

$line=20;//每页显示条数
$page_line=18;//每页显示链接数
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;//总偏移量
$query="select loginid,username,loginip,logintime,status,password,loginauth,ipport from {$dbtbpre}enewslog";
$totalquery="select count(*) as total from {$dbtbpre}enewslog";
//搜索
$search='';
$search.=$ecms_hashur['ehref'];
$where='';
if($_GET['sear']==1)
{
	$search.="&sear=1";
	$a='';
	$and='';
	//状态
	$status=(int)$_GET['status'];
	if($status)
	{
		if($status==1)
		{
			$a.="status=1";
		}
		else
		{
			$a.="status=0";
		}
		$search.="&status=$status";
	}
	//时间
	$startday=RepPostVar($_GET['startday']);
	$endday=RepPostVar($_GET['endday']);
	if($startday&&$endday)
	{
		$and=$a?' and ':'';
		$search.="&startday=$startday&endday=$endday";
		$a.=$and."logintime<='".$endday." 23:59:59' and logintime>='".$startday." 00:00:00'";
	}
	//搜索
	$keyboard=RepPostVar($_GET['keyboard']);
	if($keyboard)
	{
		$and=$a?' and ':'';
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$a.=$and."username like '%$keyboard%'";
		}
		elseif($show==2)
		{
			$a.=$and."loginip like '%$keyboard%'";
		}
		else
		{
			$a.=$and."(username like '%$keyboard%' or loginip like '%$keyboard%')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
	if($a)
	{
		$where.=" where ".$a;
	}
	$query.=$where;
	$totalquery.=$where;
}
$search2=$search;
//排序
$mydesc=(int)$_GET['mydesc'];
$desc=$mydesc?'asc':'desc';
$orderby=(int)$_GET['orderby'];
if($orderby==1)//登陆用户
{
	$order="username ".$desc.",loginid desc";
	$usernamedesc=$mydesc?0:1;
}
elseif($orderby==2)//状态
{
	$order="status ".$desc.",loginid desc";
	$statusdesc=$mydesc?0:1;
}
elseif($orderby==3)//登陆IP
{
	$order="loginip ".$desc.",loginid desc";
	$loginipdesc=$mydesc?0:1;
}
elseif($orderby==4)//登陆时间
{
	$order="logintime ".$desc.",loginid desc";
	$logintimedesc=$mydesc?0:1;
}
else//ID
{
	$order="loginid ".$desc;
	$loginiddesc=$mydesc?0:1;
}
$search.="&orderby=$orderby&mydesc=$mydesc";
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
    <td>位置：日志管理 &gt; <a href="ListLog.php<?=$ecms_hashur['whehref']?>">管理登陆日志</a></td>
    <td width="50%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="管理操作日志" onclick="self.location.href='ListDolog.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" align=center cellpadding=0 cellspacing=0>
  <form name=searchlogform method=get action='ListLog.php'>
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
          <select name="status" id="status">
            <option value="0"<?=$status==0?' selected':''?>>所有状态</option>
            <option value="1"<?=$status==1?' selected':''?>>登陆成功日志</option>
            <option value="2"<?=$status==2?' selected':''?>>登陆失败日志</option>
          </select>
          <input name=submit1 type=submit id="submit12" value=搜索>
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name="form2" method="post" action="ListLog.php" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td width="7%"><div align="center"><a href="ListLog.php?orderby=0&mydesc=<?=$loginiddesc.$search2?>">ID</a></div></td>
      <td width="28%" height="25"><div align="center"><a href="ListLog.php?orderby=1&mydesc=<?=$usernamedesc.$search2?>">登陆用户</a></div></td>
      <td width="20%"><div align="center"><a href="ListLog.php?orderby=2&mydesc=<?=$statusdesc.$search2?>">状态</a></div></td>
      <td width="17%" height="25"><div align="center"><a href="ListLog.php?orderby=3&mydesc=<?=$loginipdesc.$search2?>">登陆IP</a></div></td>
      <td width="17%"><div align="center"><a href="ListLog.php?orderby=4&mydesc=<?=$logintimedesc.$search2?>">登陆时间</a></div></td>
      <td width="11%" height="25"><div align="center">删除</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	if($r['status'])
	{
		$status='登陆成功';
	}
	else
	{
		$status=$r['loginauth']?'<font color="red">认证码错</font>':'<font color="red">密码错</font>';
	}
  ?>
    <tr bgcolor="#FFFFFF" id=log<?=$r[loginid]?>>
      <td><div align="center"><?=$r[loginid]?></div></td>
      <td height="25"><div align="center"> 
          <?=$r[username]?>
        </div></td>
      <td><div align="center">
          <?=$status?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[loginip]?>:<?=$r[ipport]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[logintime]?>
        </div></td>
      <td height="25"><div align="center">[<a href="ListLog.php?enews=DelLog&loginid=<?=$r[loginid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除此日志?');">删除</a> 
          <input name="loginid[]" type="checkbox" id="loginid[]" value="<?=$r[loginid]?>" onclick="if(this.checked){log<?=$r[loginid]?>.style.backgroundColor='#DBEAF5';}else{log<?=$r[loginid]?>.style.backgroundColor='#ffffff';}">
          ]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6"> 
        <?=$returnpage?>
        &nbsp;&nbsp; <input type="submit" name="Submit" value="批量删除"> <input name="enews" type="hidden" id="phome" value="DelLog_all"> 
        &nbsp; <input type=checkbox name=chkall value=on onClick=CheckAll(this.form)>
        选中全部 </td>
    </tr>
  </table>
</form>
<form action="ListLog.php" method="post" name="dellogform" id="dellogform" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td><div align="center">
          <input name="enews" type="hidden" id="enews" value="DelLog_date">
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