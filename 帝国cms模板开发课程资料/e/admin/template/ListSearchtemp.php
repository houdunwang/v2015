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
CheckLevel($logininid,$loginin,$classid,"template");

//增加搜索模板
function AddMSearchtemp($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[tempname]||!$add[temptext]||!$add[listvar]||!$add[modid])
	{printerror("EmptySearchTempname","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"template");
    $classid=(int)$add['classid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
    $add[temptext]=RepPhpAspJspcode($add[temptext]);
	$add[listvar]=RepPhpAspJspcode($add[listvar]);
	if($add['autorownum'])
	{
		$add[rownum]=substr_count($add[temptext],'<!--list.var');
	}
	//变量处理
	$add[subnews]=(int)$add[subnews];
	$add[rownum]=(int)$add[rownum];
	$add[modid]=(int)$add[modid];
	$add[subtitle]=(int)$add[subtitle];
	$docode=(int)$add[docode];
	$gid=(int)$add['gid'];
	$sql=$empire->query("insert into ".GetDoTemptb("enewssearchtemp",$gid)."(tempname,temptext,subnews,isdefault,listvar,rownum,modid,showdate,subtitle,classid,docode) values('$add[tempname]','".eaddslashes2($add[temptext])."',$add[subnews],0,'".eaddslashes2($add[listvar])."',$add[rownum],$add[modid],'$add[showdate]',$add[subtitle],$classid,'$docode');");
	$tempid=$empire->lastid();
	//备份模板
	AddEBakTemp('searchtemp',$gid,$tempid,$add[tempname],$add[temptext],$add[subnews],0,$add[listvar],$add[rownum],$add[modid],$add[showdate],$add[subtitle],$classid,$docode,$userid,$username);
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=".$tempid."<br>tempname=".$add[tempname]."&gid=$gid");
		printerror("AddMSearchTempSuccess","AddSearchtemp.php?enews=AddMSearchtemp&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改搜索模板
function EditMSearchtemp($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[tempid]=(int)$add[tempid];
	if(!$add[tempname]||!$add[temptext]||!$add[listvar]||!$add[modid]||!$add[tempid])
	{printerror("EmptySearchTempname","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"template");
    $classid=(int)$add['classid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
    $add[temptext]=RepPhpAspJspcode($add[temptext]);
	$add[listvar]=RepPhpAspJspcode($add[listvar]);
	if($add['autorownum'])
	{
		$add[rownum]=substr_count($add[temptext],'<!--list.var');
	}
	//变量处理
	$add[subnews]=(int)$add[subnews];
	$add[rownum]=(int)$add[rownum];
	$add[modid]=(int)$add[modid];
	$add[subtitle]=(int)$add[subtitle];
	$docode=(int)$add[docode];
	$gid=(int)$add['gid'];
	$sql=$empire->query("update ".GetDoTemptb("enewssearchtemp",$gid)." set subnews=$add[subnews],tempname='$add[tempname]',temptext='".eaddslashes2($add[temptext])."',listvar='".eaddslashes2($add[listvar])."',rownum=$add[rownum],modid=$add[modid],showdate='$add[showdate]',subtitle=$add[subtitle],classid=$classid,docode='$docode' where tempid='$add[tempid]'");
	//备份模板
	AddEBakTemp('searchtemp',$gid,$add[tempid],$add[tempname],$add[temptext],$add[subnews],0,$add[listvar],$add[rownum],$add[modid],$add[showdate],$add[subtitle],$classid,$docode,$userid,$username);
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=".$add[tempid]."<br>tempname=".$add[tempname]."&gid=$gid");
		printerror("EditMSearchTempSuccess","ListSearchtemp.php?classid=$add[cid]&modid=$add[mid]&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除搜索模板
function DelMSearchtemp($tempid,$add,$userid,$username){
	global $empire,$dbtbpre;
	$tempid=(int)$tempid;
	if(!$tempid)
	{printerror("NotDelTemplateid","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$tr=$empire->fetch1("select tempname,isdefault from ".GetDoTemptb("enewssearchtemp",$gid)." where tempid='$tempid'");
	if($tr[isdefault])
	{printerror("NotDelDefaultTemp","history.go(-1)");}
	$sql=$empire->query("delete from ".GetDoTemptb("enewssearchtemp",$gid)." where tempid='$tempid'");
	$usql=$empire->query("update {$dbtbpre}enewsclass set searchtempid=0 where searchtempid='$tempid'");
	GetClass();
	//删除备份记录
	DelEbakTempAll('searchtemp',$gid,$tempid);
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=".$tempid."<br>tempname=".$tr[tempname]."&gid=$gid");
		printerror("DelMSearchTempSuccess","ListSearchtemp.php?classid=$add[cid]&modid=$add[mid]&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//设为默认搜索模板
function DefaultMSearchtemp($tempid,$add,$userid,$username){
	global $empire,$dbtbpre;
	$tempid=(int)$tempid;
	if(!$tempid)
	{printerror("EmptyDefaultSearchtempid","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewssearchtemp",$gid)." where tempid='$tempid'");
	$usql=$empire->query("update ".GetDoTemptb("enewssearchtemp",$gid)." set isdefault=0");
	$sql=$empire->query("update ".GetDoTemptb("enewssearchtemp",$gid)." set isdefault=1 where tempid='$tempid'");
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=".$tempid."<br>tempname=".$tr[tempname]."&gid=$gid");
		printerror("DefaultMSearchtempSuccess","ListSearchtemp.php?classid=$add[cid]&modid=$add[mid]&gid=$gid".hReturnEcmsHashStrHref2(0));
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
	include("../../class/tempfun.php");
}
//增加搜索模板
if($enews=="AddMSearchtemp")
{
	AddMSearchtemp($_POST,$logininid,$loginin);
}
//修改搜索模板
elseif($enews=="EditMSearchtemp")
{
	EditMSearchtemp($_POST,$logininid,$loginin);
}
//删除搜索模板
elseif($enews=="DelMSearchtemp")
{
	$tempid=$_GET['tempid'];
	DelMSearchtemp($tempid,$_GET,$logininid,$loginin);
}
//默认搜索模板
elseif($enews=="DefaultMSearchtemp")
{
	$tempid=$_GET['tempid'];
	DefaultMSearchtemp($tempid,$_GET,$logininid,$loginin);
}

$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$url=$urlgname."<a href=ListSearchtemp.php?gid=$gid".$ecms_hashur['ehref'].">管理搜索模板</a>";
$search="&gid=$gid".$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select tempid,tempname,modid,isdefault from ".GetDoTemptb("enewssearchtemp",$gid);
$totalquery="select count(*) as total from ".GetDoTemptb("enewssearchtemp",$gid);
//类别
$add="";
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid=$classid";
	$search.="&classid=$classid";
}
//模型
$modid=(int)$_GET['modid'];
if($modid)
{
	if(empty($add))
	{
		$add=" where modid=$modid";
	}
	else
	{
		$add.=" and modid=$modid";
	}
	$search.="&modid=$modid";
}
$query.=$add;
$totalquery.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by tempid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//分类
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewssearchtempclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$classid)
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
//模型
$mstr="";
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod where usemod=0 order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	$select="";
	if($mr[mid]==$modid)
	{
		$select=" selected";
	}
	$mstr.="<option value='".$mr[mid]."'".$select.">".$mr[mname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理搜索模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td> <div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加搜索模板" onclick="self.location.href='AddSearchtemp.php?enews=AddMSearchtemp&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit5" value="管理搜索模板分类" onclick="self.location.href='SearchtempClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form1" method="get" action="ListSearchtemp.php">
  <?=$ecms_hashur['eform']?>
  <input type=hidden name=gid value="<?=$gid?>">
    <tr> 
      <td height="25">限制显示： 
        <select name="classid" id="classid" onchange="document.form1.submit()">
          <option value="0">显示所有分类</option>
		  <?=$cstr?>
        </select>
        <select name="modid" id="modid" onchange="document.form1.submit()">
          <option value="0">显示所有系统模型</option>
		  <?=$mstr?>
        </select>
      </td>
    </tr>
	</form>
  </table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="8%" height="25"><div align="center">ID</div></td>
    <td width="41%" height="25"><div align="center">模板名</div></td>
    <td width="27%"><div align="center">所属系统模型</div></td>
    <td width="24%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  $modr=$empire->fetch1("select mid,mname from {$dbtbpre}enewsmod where mid=$r[modid]");
  $color="#ffffff";
  $movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
  if($r[isdefault])
  {
  $color="#DBEAF5";
  $movejs='';
  }
  ?>
  <tr bgcolor="<?=$color?>"<?=$movejs?>> 
    <td height="25"><div align="center"> 
        <?=$r[tempid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[tempname]?>
      </div></td>
    <td><div align="center">[<a href="ListSearchtemp.php?classid=<?=$classid?>&modid=<?=$modr[mid]?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>"><?=$modr[mname]?></a>]</div></td>
    <td height="25"><div align="center"> [<a href="AddSearchtemp.php?enews=EditMSearchtemp&tempid=<?=$r[tempid]?>&cid=<?=$classid?>&mid=<?=$modid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="AddSearchtemp.php?enews=AddMSearchtemp&docopy=1&tempid=<?=$r[tempid]?>&cid=<?=$classid?>&mid=<?=$modid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>">复制</a>] 
        [<a href="ListSearchtemp.php?enews=DefaultMSearchtemp&tempid=<?=$r[tempid]?>&cid=<?=$classid?>&mid=<?=$modid?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要设为默认?');">设为默认</a>] 
        [<a href="ListSearchtemp.php?enews=DelMSearchtemp&tempid=<?=$r[tempid]?>&cid=<?=$classid?>&mid=<?=$modid?>&gid=<?=$gid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="4">&nbsp;<?=$returnpage?></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
