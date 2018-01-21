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
CheckLevel($logininid,$loginin,$classid,"userlist");

//增加自定义信息列表
function AddUserlist($add,$userid,$username){
	global $empire,$dbtbpre;
	$cid=(int)$add['cid'];
	$listtempid=(int)$add['listtempid'];
	$maxnum=(int)$add['maxnum'];
	$lencord=(int)$add['lencord'];
	if(!$add[listname]||!$listtempid||!$add[listsql]||!$add[totalsql]||!$add[filepath]||!$add[filetype]||!$add[lencord])
	{
		printerror("EmptyUserListname","history.go(-1)");
	}
	$query_first=substr($add['totalsql'],0,7);
	$query_firstlist=substr($add['listsql'],0,7);
	if(!($query_first=="select "||$query_first=="SELECT "||$query_firstlist=="select "||$query_firstlist=="SELECT "))
	{
		printerror("ListSqlError","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"userlist");
	if(empty($add['pagetitle']))
	{
		$add['pagetitle']=$add['listname'];
	}
	$add['listname']=ehtmlspecialchars($add['listname']);
	$add['pagetitle']=AddAddsData(RepPhpAspJspcode($add['pagetitle']));
	$add['pagekeywords']=AddAddsData(RepPhpAspJspcode($add['pagekeywords']));
	$add['pagedescription']=AddAddsData(RepPhpAspJspcode($add['pagedescription']));
	$add[totalsql]=ClearAddsData($add[totalsql]);
	$add[listsql]=ClearAddsData($add[listsql]);
	$add['classid']=(int)$add['classid'];
	$sql=$empire->query("insert into {$dbtbpre}enewsuserlist(listname,pagetitle,filepath,filetype,totalsql,listsql,maxnum,lencord,listtempid,pagekeywords,pagedescription,classid) values('$add[listname]','".$add[pagetitle]."','$add[filepath]','$add[filetype]','".addslashes($add[totalsql])."','".addslashes($add[listsql])."',$maxnum,$lencord,$listtempid,'".$add[pagekeywords]."','".$add[pagedescription]."','$add[classid]');");
	//刷新列表
	ReUserlist($add,"../");
	if($sql)
	{
		$listid=$empire->lastid();
		//操作日志
		insert_dolog("listid=$listid&listname=$add[listname]");
		printerror("AddUserlistSuccess","AddUserlist.php?enews=AddUserlist&classid=$cid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改自定义信息列表
function EditUserlist($add,$userid,$username){
	global $empire,$dbtbpre;
	$cid=(int)$add['cid'];
	$listid=(int)$add['listid'];
	$listtempid=(int)$add['listtempid'];
	$maxnum=(int)$add['maxnum'];
	$lencord=(int)$add['lencord'];
	if(!$listid||!$add[listname]||!$listtempid||!$add[listsql]||!$add[totalsql]||!$add[filepath]||!$add[filetype]||!$add[lencord])
	{
		printerror("EmptyUserListname","history.go(-1)");
	}
	$query_first=substr($add['totalsql'],0,7);
	$query_firstlist=substr($add['listsql'],0,7);
	if(!($query_first=="select "||$query_first=="SELECT "||$query_firstlist=="select "||$query_firstlist=="SELECT "))
	{
		printerror("ListSqlError","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"userlist");
	/*
	//删除旧文件
	if(!($add['oldfilepath']<>$add['filepath']||$add['oldfiletype']<>$add['filetype']))
	{
		DelFiletext($add['oldjsfilename']);
	}
	*/
	if(empty($add['pagetitle']))
	{
		$add['pagetitle']=$add['listname'];
	}
	$add['listname']=ehtmlspecialchars($add['listname']);
	$add['pagetitle']=AddAddsData(RepPhpAspJspcode($add['pagetitle']));
	$add['pagekeywords']=AddAddsData(RepPhpAspJspcode($add['pagekeywords']));
	$add['pagedescription']=AddAddsData(RepPhpAspJspcode($add['pagedescription']));
	$add[totalsql]=ClearAddsData($add[totalsql]);
	$add[listsql]=ClearAddsData($add[listsql]);
	$add['classid']=(int)$add['classid'];
	$sql=$empire->query("update {$dbtbpre}enewsuserlist set listname='$add[listname]',pagetitle='$add[pagetitle]',filepath='$add[filepath]',filetype='$add[filetype]',totalsql='".addslashes($add['totalsql'])."',listsql='".addslashes($add['listsql'])."',maxnum=$maxnum,lencord=$lencord,listtempid=$listtempid,pagekeywords='$add[pagekeywords]',pagedescription='$add[pagedescription]',classid='$add[classid]' where listid=$listid");
	//刷新列表
	ReUserlist($add,"../");
	if($sql)
	{
		//操作日志
	    insert_dolog("listid=$listid&listname=$add[listname]");
		printerror("EditUserlistSuccess","ListUserlist.php?classid=$cid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除自定义信息列表
function DelUserlist($listid,$userid,$username){
	global $empire,$dbtbpre;
	$cid=(int)$add['cid'];
	$listid=(int)$listid;
	if(!$listid)
	{
		printerror("NotChangeUserlistid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"userlist");
	$r=$empire->fetch1("select listname from {$dbtbpre}enewsuserlist where listid=$listid");
	$sql=$empire->query("delete from {$dbtbpre}enewsuserlist where listid=$listid");
	if($sql)
	{
		//操作日志
		insert_dolog("listid=$listid&listname=$r[listname]");
		printerror("DelUserlistSuccess","ListUserlist.php?classid=$cid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//刷新自定义列表
function DoReUserlist($add,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"userlist");
	$listid=$add['listid'];
	$count=count($listid);
	if(!$count)
	{
		printerror("EmptyReUserlistid","history.go(-1)");
    }
	for($i=0;$i<$count;$i++)
	{
		$listid[$i]=(int)$listid[$i];
		if(empty($listid[$i]))
		{
			continue;
		}
		$ur=$empire->fetch1("select listid,pagetitle,filepath,filetype,totalsql,listsql,maxnum,lencord,listtempid,pagekeywords,pagedescription from {$dbtbpre}enewsuserlist where listid='".$listid[$i]."'");
		ReUserlist($ur,"../");
	}
	//操作日志
	insert_dolog("");
	printerror("DoReUserlistSuccess",$_SERVER['HTTP_REFERER']);
}

$addgethtmlpath="../";
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	require("../../data/dbcache/class.php");
	include("../../class/t_functions.php");
}
if($enews=="AddUserlist")
{
	AddUserlist($_POST,$logininid,$loginin);
}
elseif($enews=="EditUserlist")
{
	EditUserlist($_POST,$logininid,$loginin);
}
elseif($enews=="DelUserlist")
{
	$listid=$_GET['listid'];
	DelUserlist($listid,$logininid,$loginin);
}
elseif($enews=="DoReUserlist")
{
	DoReUserlist($_POST,$logininid,$loginin);
}
else
{}
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=20;//每页显示链接数
$offset=$page*$line;//总偏移量
$search='';
$search.=$ecms_hashur['ehref'];
$query="select listid,listname,filepath from {$dbtbpre}enewsuserlist";
$totalquery="select count(*) as total from {$dbtbpre}enewsuserlist";
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
$query=$query." order by listid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//分类
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsuserlistclass order by classid");
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
<title>管理自定义信息列表</title>
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
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置：<a href=ListUserlist.php<?=$ecms_hashur['whehref']?>>管理自定义信息列表</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="增加自定义列表" onclick="self.location.href='AddUserlist.php?enews=AddUserlist<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit5" value="管理自定义列表分类" onclick="self.location.href='UserlistClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td> 选择类别：
      <select name="classid" id="classid" onchange=window.location='ListUserlist.php?<?=$ecms_hashur['ehref']?>&classid='+this.options[this.selectedIndex].value>
          <option value="0">显示所有类别</option>
          <?=$cstr?>
      </select>
    </td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListUserlist.php">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td width="4%"><div align="center">
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td width="7%" height="25"> <div align="center">ID</div></td>
      <td width="32%" height="25"> <div align="center">列表名称</div></td>
      <td width="29%"><div align="center">页面地址</div></td>
      <td width="10%"><div align="center">预览</div></td>
      <td width="18%" height="25"> <div align="center">操作</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  $jspath=$public_r['newsurl'].str_replace("../../","",$r['filepath']);
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center">
          <input name="listid[]" type="checkbox" id="listid[]" value="<?=$r[listid]?>">
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[listid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[listname]?>
        </div></td>
      <td><div align="center">
        <input name="textfield" type="text" value="<?=$jspath?>">
      </div></td>
      <td><div align="center">[<a href="<?=$jspath?>" target="_blank">预览</a>]</div></td>
      <td height="25"> <div align="center">[<a href="AddUserlist.php?enews=EditUserlist&listid=<?=$r[listid]?>&cid=<?=$classid?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="AddUserlist.php?enews=AddUserlist&docopy=1&listid=<?=$r[listid]?>&cid=<?=$classid?><?=$ecms_hashur['ehref']?>">复制</a>]&nbsp;[<a href="ListUserlist.php?enews=DelUserlist&listid=<?=$r[listid]?>&cid=<?=$classid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6"> 
        <?=$returnpage?>
        &nbsp;&nbsp;&nbsp; <input type="submit" name="Submit3" value="刷新"> <input name="enews" type="hidden" id="enews" value="DoReUserlist">      </td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
