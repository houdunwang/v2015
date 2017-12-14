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
CheckLevel($logininid,$loginin,$classid,"tempvar");

//增加模板全局变量
function AddTempvar($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[myvar]||!$add[varvalue]||!$add[varname])
	{printerror("EmptyTempvar","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"tempvar");
	$add[myvar]=hRepPostStr($add[myvar],1);
	$add[varname]=hRepPostStr($add[varname],1);
	$classid=(int)$add[classid];
	$isclose=(int)$add[isclose];
	$add[myorder]=(int)$add[myorder];
	$add[varvalue]=RepPhpAspJspcode($add[varvalue]);
	$gid=(int)$add['gid'];
	$sql=$empire->query("insert into ".GetDoTemptb("enewstempvar",$gid)."(myvar,varname,varvalue,classid,isclose,myorder) values('$add[myvar]','$add[varname]','".eaddslashes2($add[varvalue])."',".$classid.",".$isclose.",$add[myorder]);");
	$lastid=$empire->lastid();
	//备份模板
	AddEBakTemp('tempvar',$gid,$lastid,$add[myvar],$add[varvalue],$add[myorder],0,$add[varname],0,0,'',0,$classid,$isclose,$userid,$username);
	if($sql)
	{
		//操作日志
	    insert_dolog("varid=".$lastid."<br>var=".$add[myvar]."&gid=$gid");
		printerror("AddTempvarSuccess","AddTempvar.php?enews=AddTempvar&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改模板变量
function EditTempvar($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[varid]=(int)$add['varid'];
	if(!$add[varid]||!$add[myvar]||!$add[varvalue]||!$add[varname])
	{printerror("EmptyTempvar","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"tempvar");
	$add[myvar]=hRepPostStr($add[myvar],1);
	$add[varname]=hRepPostStr($add[varname],1);
	$add[varvalue]=RepPhpAspJspcode($add[varvalue]);
	$classid=(int)$add[classid];
	$isclose=(int)$add[isclose];
	$add[myorder]=(int)$add[myorder];
	$gid=(int)$add['gid'];
	$sql=$empire->query("update ".GetDoTemptb("enewstempvar",$gid)." set myvar='$add[myvar]',varname='$add[varname]',varvalue='".eaddslashes2($add[varvalue])."',classid=$classid,isclose=$isclose,myorder=$add[myorder] where varid='$add[varid]'");
	//备份模板
	AddEBakTemp('tempvar',$gid,$add[varid],$add[myvar],$add[varvalue],$add[myorder],0,$add[varname],0,0,'',0,$classid,$isclose,$userid,$username);
	if($sql)
	{
		//操作日志
		insert_dolog("varid=".$add[varid]."<br>var=".$add[myvar]."&gid=$gid");
		printerror("EditTempvarSuccess","ListTempvar.php?classid=$add[cid]&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除模板变量
function DelTempvar($varid,$cid,$userid,$username){
	global $empire,$dbtbpre;
	$varid=(int)$varid;
	if(!$varid)
	{printerror("NotDelTempvarid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"tempvar");
	$gid=(int)$_GET['gid'];
	$r=$empire->fetch1("select myvar from ".GetDoTemptb("enewstempvar",$gid)." where varid='$varid'");
	$sql=$empire->query("delete from ".GetDoTemptb("enewstempvar",$gid)." where varid='$varid'");
	//删除备份记录
	DelEbakTempAll('tempvar',$gid,$varid);
	if($sql)
	{
		//操作日志
		insert_dolog("varid=".$varid."<br>var=".$r[myvar]."&gid=$gid");
		printerror("DelTempvarSuccess","ListTempvar.php?classid=$cid&gid=$gid".hReturnEcmsHashStrHref2(0));
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
	include("../../class/tempfun.php");
}
//增加模板变量
if($enews=="AddTempvar")
{
	$add=$_POST;
	AddTempvar($add,$logininid,$loginin);
}
//修改模板变量
elseif($enews=="EditTempvar")
{
	$add=$_POST;
	EditTempvar($add,$logininid,$loginin);
}
//删除模板变量
elseif($enews=="DelTempvar")
{
	$varid=$_GET['varid'];
	$cid=$_GET['cid'];
	DelTempvar($varid,$cid,$logininid,$loginin);
}

$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$search="&gid=$gid".$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select varid,myvar,varvalue,varname,isclose from ".GetDoTemptb("enewstempvar",$gid);
$totalquery="select count(*) as total from ".GetDoTemptb("enewstempvar",$gid);
//类别
$add="";
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid=$classid";
	$search.="&classid=$classid";
}
$query.=$add;
$totalquery.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by varid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//类别
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewstempvarclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$classid)
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理模板变量</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置: 
      <?=$urlgname?>
      <a href="ListTempvar.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>">管理模板变量</a></td>
    <td><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="增加模板变量" onclick="self.location.href='AddTempvar.php?enews=AddTempvar&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit5" value="管理模板变量分类" onclick="self.location.href='TempvarClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
      <td> 选择类别： 
        <select name="classid" id="classid" onchange=window.location='ListTempvar.php?<?=$ecms_hashur['ehref']?>&gid=<?=$gid?>&classid='+this.options[this.selectedIndex].value>
          <option value="0">显示所有类别</option>
		  <?=$cstr?>
        </select>
      </td>
    </tr>
  </table><br>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
	<td width="28%" height="25"> <div align="center">变量标识</div></td>
    <td width="33%" height="25"> <div align="center">模板变量名</div></td>
    <td width="15%"><div align="center">开启</div></td>
    <td width="18%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  //开启
  if($r[isclose])
  {
  $isclose="<font color=red>关闭</font>";
  }
  else
  {
  $isclose="开启";
  }
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[varid]?>
      </div></td>
	<td height="25"> <div align="center"> 
        <?=$r[varname]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <input name=text1 type=text value="[!--temp.<?=$r[myvar]?>--]" size="32">
      </div></td>
    <td><div align="center"><?=$isclose?></div></td>
    <td height="25"> <div align="center">[<a href="AddTempvar.php?enews=EditTempvar&varid=<?=$r[varid]?>&cid=<?=$classid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="ListTempvar.php?enews=DelTempvar&varid=<?=$r[varid]?>&cid=<?=$classid?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="5">&nbsp;&nbsp;&nbsp; 
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
