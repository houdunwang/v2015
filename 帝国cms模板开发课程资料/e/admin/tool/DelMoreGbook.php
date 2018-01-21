<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../class/com_functions.php");
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
CheckLevel($logininid,$loginin,$classid,"gbook");

//批量删除留言(条件)
function DelMoreGbook($add,$logininid,$loginin){
	global $empire,$dbtbpre;
    CheckLevel($logininid,$loginin,$classid,"gbook");//验证权限
	//变量处理
	$name=RepPostStr($add['name']);
	$ip=RepPostVar($add['ip']);
	$email=RepPostStr($add['email']);
	$mycall=RepPostStr($add['mycall']);
	$lytext=RepPostStr($add['lytext']);
	$startlyid=(int)$add['startlyid'];
	$endlyid=(int)$add['endlyid'];
	$startlytime=RepPostVar($add['startlytime']);
	$endlytime=RepPostVar($add['endlytime']);
	$checked=(int)$add['checked'];
	$ismember=(int)$add['ismember'];
	$bid=(int)$add['bid'];
	$havere=(int)$add['havere'];
	$where='';
	//留言分类
	if($bid)
	{
		$where.=" and bid='$bid'";
	}
	//是否会员
	if($ismember)
	{
		if($ismember==1)
		{
			$where.=" and userid=0";
		}
		else
		{
			$where.=" and userid>0";
		}
	}
	//留言ID
	if($endlyid)
	{
		$where.=' and lyid BETWEEN '.$startlyid.' and '.$endlyid;
	}
	//发布时间
	if($startlytime&&$endlytime)
	{
		$where.=" and lytime>='$startlytime' and lytime<='$endlytime'";
	}
	//是否审核
	if($checked)
	{
		$checkval=$checked==1?0:1;
		$where.=" and checked='$checkval'";
	}
	//是否回复
	if($havere)
	{
		if($havere==1)
		{
			$where.=" and retext<>''";
		}
		else
		{
			$where.=" and retext=''";
		}
	}
	//姓名
	if($name)
	{
		$where.=" and name like '%$name%'";
	}
	//发布IP
	if($ip)
	{
		$where.=" and ip like '%$ip%'";
	}
	//邮箱
	if($email)
	{
		$where.=" and email like '%$email%'";
	}
	//电话
	if($mycall)
	{
		$where.=" and `mycall` like '%$mycall%'";
	}
	//留言内容
	if($lytext)
	{
		$where.=" and lytext like '%$lytext%'";
	}
    if(!$where)
	{
		printerror("EmptyDelMoreGbook","history.go(-1)");
	}
	$where=substr($where,5);
	$sql=$empire->query("delete from {$dbtbpre}enewsgbook where ".$where);
	insert_dolog("");//操作日志
	printerror("DelGbookSuccess","DelMoreGbook.php".hReturnEcmsHashStrHref2(1));
}

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='DelMoreGbook')
{
	@set_time_limit(0);
	DelMoreGbook($_POST,$logininid,$loginin);
}

$gbclass=ReturnGbookClass(0,0);

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量删除留言</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href=gbook.php<?=$ecms_hashur['whehref']?>>管理留言</a>&nbsp;>&nbsp;批量删除留言</td>
  </tr>
</table>
<form name="form1" method="post" action="DelMoreGbook.php" onsubmit="return confirm('确认要删除?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">批量删除留言 <input name="enews" type="hidden" id="enews" value="DelMoreGbook"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属留言分类：</td>
      <td height="25"><select name="bid" id="bid">
          <option value="0">不限</option>
		  <?=$gbclass?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">留言IP包含：</td>
      <td height="25"><input name=ip type=text id="ip"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">姓名包含：</td>
      <td width="81%" height="25"><input name=name type=text id="name"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">邮箱包含：</td>
      <td height="25"><input name=email type=text id="email"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">电话包含：</td>
      <td height="25"><input name=mycall type=text id="mycall"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">留言内容包含：</td>
      <td height="25"><textarea name="lytext" cols="70" rows="5" id="lytext"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">留言ID 介于：</td>
      <td height="25"><input name="startlyid" type="text" id="startlyid">
        -- 
        <input name="endlyid" type="text" id="endlyid"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">留言时间 介于：</td>
      <td height="25"><input name="startlytime" type="text" id="startlytime" onclick="setday(this)">
        -- 
        <input name="endlytime" type="text" id="endlytime" onclick="setday(this)">
        <font color="#666666">(格式：2011-01-27)</font></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">是否会员发布：</td>
      <td height="25"><input name="ismember" type="radio" value="0" checked>
        不限 
        <input type="radio" name="ismember" value="1">
        游客发布 
        <input type="radio" name="ismember" value="2">
        会员发布</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" valign="top">是否有回复：</td>
      <td height="25"><input name="havere" type="radio" value="0" checked>
        不限 
        <input name="havere" type="radio" value="1">
        已回复留言 
        <input name="havere" type="radio" value="2">
        未回复留言</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">是否审核：</td>
      <td height="25"><input name="checked" type="radio" value="0" checked>
        不限 
        <input name="checked" type="radio" value="1">
        已审核留言
<input name="checked" type="radio" value="2">
        未审核留言</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="删除留言"> </td>
    </tr>
  </table>
</form>
</body>
</html>
