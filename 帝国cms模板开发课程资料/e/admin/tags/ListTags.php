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
CheckLevel($logininid,$loginin,$classid,"tags");

//删除TAGS
function DelTags($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagid=(int)$add['tagid'];
	if(!$tagid)
	{
		printerror("EmptyTagid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$r=$empire->fetch1("select tagname from {$dbtbpre}enewstags where tagid='$tagid'");
	$sql=$empire->query("delete from {$dbtbpre}enewstags where tagid='$tagid'");
	$sql2=$empire->query("delete from {$dbtbpre}enewstagsdata where tagid='$tagid'");
	if($sql&&$sql2)
	{
		//操作日志
		insert_dolog("tagid=$tagid&tagname=$r[tagname]");
		printerror("DelTagsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量删除TAGS
function DelTags_all($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagid=$add['tagid'];
	$count=count($tagid);
	if(!$count)
	{
		printerror("EmptyTagid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$tagid[$i];
		$ids.=$dh.$id;
		$dh=',';
	}
	$sql=$empire->query("delete from {$dbtbpre}enewstags where tagid in ($ids)");
	$sql2=$empire->query("delete from {$dbtbpre}enewstagsdata where tagid in ($ids)");
	if($sql&&$sql2)
	{
		//操作日志
		insert_dolog("");
		printerror("DelTagsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除使用率低的TAGS
function DelLessTags($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$num=(int)$add['num'];
	$ids='';
	$dh='';
	$sql=$empire->query("select tagid from {$dbtbpre}enewstags where num<=$num");
	while($r=$empire->fetch($sql))
	{
		$ids.=$dh.$r[tagid];
		$dh=',';
	}
	if(!$ids)
	{
		printerror("EmptyLessTags","history.go(-1)");
	}
	$del=$empire->query("delete from {$dbtbpre}enewstags where num<=$num");
	$del2=$empire->query("delete from {$dbtbpre}enewstagsdata where tagid in ($ids)");
	if($del&&$del2)
	{
		//操作日志
		insert_dolog("num=$num");
		printerror("DelLessTagsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除过期的TAG信息
function DelOldTagsInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	if(empty($add['newstime']))
	{
		printerror("EmptyTagsTime","history.go(-1)");
	}
	$newstime=to_time($add['newstime']);
	$sql=$empire->query("select tagid from {$dbtbpre}enewstagsdata where newstime<=$newstime");
	while($r=$empire->fetch($sql))
	{
		$empire->query("update {$dbtbpre}enewstags set num=num-1 where tagid='$r[tagid]'");
	}
	$del=$empire->query("delete from {$dbtbpre}enewstagsdata where newstime<=$newstime");
	if($del)
	{
		//操作日志
		insert_dolog("newstime=$add[newstime]");
		printerror("DelOldTagsInfoSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//合并TAGS
function MergeTags($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagid=$add['tagid'];
	$count=count($tagid);
	if(!$count)
	{
		printerror("EmptyTagid","history.go(-1)");
	}
	$newtagname=RepPostVar($add['newtagname']);
	if(!$newtagname)
	{
		printerror("NotMergeTagname","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$r=$empire->fetch1("select tagid from {$dbtbpre}enewstags where tagname='$newtagname' limit 1");
	if(!$r[tagid])
	{
		printerror("NotMergeTagname","history.go(-1)");
	}
	$ids='';
	$dh='';
	$allnum=0;
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$tagid[$i];
		if(!$id)
		{
			continue;
		}
		$tr=$empire->fetch1("select tagid,num from {$dbtbpre}enewstags where tagid='$id'");
		if(!$tr[tagid])
		{
			continue;
		}
		$ids.=$dh.$id;
		$dh=',';
		$allnum+=$tr[num];
	}
	if(empty($ids))
	{
		printerror("EmptyTagid","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewstags set num=num+$allnum where tagid='$r[tagid]'");
	$sql2=$empire->query("update {$dbtbpre}enewstagsdata set tagid='$r[tagid]' where tagid in ($ids)");
	$sql3=$empire->query("delete from {$dbtbpre}enewstags where tagid in ($ids)");
	if($sql&&$sql2&&$sql3)
	{
		//操作日志
		insert_dolog("newtagname=$newtagname");
		printerror("MergeTagsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//增加TAGS
function AddTags($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagname=RepPostVar($add['tagname']);
	$cid=(int)$add['cid'];
	if(!$tagname)
	{
		printerror("EmptyTagname","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstags where tagname='$tagname' limit 1");
	if($num)
	{
		printerror("HaveTagname","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewstags(tagname,num,isgood,cid) values('$tagname',0,0,'$cid');");
	if($sql)
	{
		$tagid=$empire->lastid();
		//操作日志
		insert_dolog("tagid=$tagid&tagname=$tagname");
		printerror("AddTagsSuccess","AddTags.php?enews=AddTags".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改TAGS
function EditTags($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagid=(int)$add['tagid'];
	$tagname=RepPostVar($add['tagname']);
	$cid=(int)$add['cid'];
	if(!$tagid||!$tagname)
	{
		printerror("EmptyTagname","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstags where tagname='$tagname' and tagid<>$tagid limit 1");
	if($num)
	{
		printerror("HaveTagname","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewstags set tagname='$tagname',cid='$cid' where tagid='$tagid'");
	if($sql)
	{
		//操作日志
		insert_dolog("tagid=$tagid&tagname=$tagname");
		printerror("EditTagsSuccess","ListTags.php?cid=$add[fcid]".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//批量推荐TAGS
function GoodTags($add,$userid,$username){
	global $empire,$dbtbpre;
	$tagid=$add['tagid'];
	$count=count($tagid);
	$isgood=(int)$add['isgood'];
	if(!$count)
	{
		printerror("EmptyTagid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$tagid[$i];
		$ids.=$dh.$id;
		$dh=',';
	}
	$sql=$empire->query("update {$dbtbpre}enewstags set isgood=$isgood where tagid in ($ids)");
	if($sql)
	{
		//操作日志
		insert_dolog("");
		printerror("GoodTagsSuccess",$_SERVER['HTTP_REFERER']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//设置TAGS
function SetTags($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"tags");
	$opentags=(int)$add['opentags'];
	$tagstempid=(int)$add['tagstempid'];
	$usetags=eReturnRDataStr($add['umid']);
	$chtags=eReturnRDataStr($add['cmid']);
	$tagslistnum=(int)$add['tagslistnum'];
	$sql=$empire->query("update {$dbtbpre}enewspublic set opentags='$opentags',tagstempid='$tagstempid',usetags='$usetags',chtags='$chtags',tagslistnum='$tagslistnum' limit 1");
	if($sql)
	{
		GetConfig();
		//操作日志
		insert_dolog("");
		printerror("SetTagsSuccess","SetTags.php".hReturnEcmsHashStrHref2(1));
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
if($enews=="AddTags")//增加TAGS
{
	AddTags($_POST,$logininid,$loginin);
}
elseif($enews=="EditTags")//修改TAGS
{
	EditTags($_POST,$logininid,$loginin);
}
elseif($enews=="DelTags")//删除TAGS
{
	DelTags($_GET,$logininid,$loginin);
}
elseif($enews=="DelTags_all")//批量删除TAGS
{
	DelTags_all($_POST,$logininid,$loginin);
}
elseif($enews=="MergeTags")//合并TAGS
{
	MergeTags($_POST,$logininid,$loginin);
}
elseif($enews=="GoodTags")//推荐TAGS
{
	GoodTags($_POST,$logininid,$loginin);
}
elseif($enews=="DelLessTags")//删除使用率低的TAGS
{
	DelLessTags($_POST,$logininid,$loginin);
}
elseif($enews=="DelOldTagsInfo")//删除过期TAGS信息
{
	DelOldTagsInfo($_POST,$logininid,$loginin);
}
elseif($enews=="SetTags")//设置TAGS
{
	SetTags($_POST,$logininid,$loginin);
}
else
{}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=20;//每页显示链接数
$offset=$page*$line;//总偏移量
//搜索
$add='';
$search='';
$search.=$ecms_hashur['ehref'];
//推荐
$isgood=(int)$_GET[isgood];
if($isgood)
{
	$add.=' and isgood=1';
	$search.="&isgood=$isgood";
}
//分类
$cid=(int)$_GET[cid];
if($cid)
{
	$add.=" and cid='$cid'";
	$search.="&cid=$cid";
}
//关键字
if($_GET['keyboard'])
{
	$keyboard=RepPostVar($_GET['keyboard']);
	$show=(int)$_GET['show'];
	if($show==1)
	{
		$add.=" and tagid='$keyboard'";
	}
	else
	{
		$add.=" and tagname like '%$keyboard%'";
	}
	$search.="&show=$show&keyboard=$keyboard";
}
//排序
$orderby=RepPostStr($_GET['orderby'],1);
if($orderby==1)//按TAGID升序排序
{$doorder='tagid asc';}
elseif($orderby==2)//按信息数降序排序
{$doorder='num desc';}
elseif($orderby==3)//按信息数升序排序
{$doorder='num asc';}
else//按TAGID降序排序
{$doorder='tagid desc';}
$search.="&orderby=$orderby";
$add=$add?' where '.substr($add,5):'';
$query="select tagid,tagname,num,isgood,cid from {$dbtbpre}enewstags".$add;
$totalquery="select count(*) as total from {$dbtbpre}enewstags".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by ".$doorder." limit $offset,$line";
$sql=$empire->query($query);
//分类
$csql=$empire->query("select classid,classname from {$dbtbpre}enewstagsclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cid==$cr[classid])
	{
		$select=" selected";
	}
	$cs.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理TAGS</title>
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
    <td width="22%" height="25">位置：<a href="ListTags.php<?=$ecms_hashur['whehref']?>">管理TAGS</a></td>
    <td width="78%"><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="增加TAGS" onclick="self.location.href='AddTags.php?enews=AddTags<?=$ecms_hashur['ehref']?>';">&nbsp;
        <input type="button" name="Submit4" value="TAGS分类管理" onclick="self.location.href='TagsClass.php<?=$ecms_hashur['whehref']?>';">&nbsp;
        <input type="button" name="Submit42" value="设置TAGS" onclick="self.location.href='SetTags.php<?=$ecms_hashur['whehref']?>';">&nbsp;
        <input type="button" name="Submit422" value="清理多余TAGS信息" onclick="self.location.href='ClearTags.php<?=$ecms_hashur['whehref']?>';">&nbsp;
        <input type="button" name="Submit5" value="删除使用率低的TAGS" onclick="self.location.href='DelLessTags.php<?=$ecms_hashur['whehref']?>';">&nbsp;
        <input type="button" name="Submit6" value="删除过期的TAGS信息" onclick="self.location.href='DelOldTagsInfo.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <form name="searchform" method="GET" action="ListTags.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25">搜索：
        <select name="show" id="show">
          <option value="0"<?=$show==0?' selected':''?>>TAG名称</option>
		  <option value="1"<?=$show==1?' selected':''?>>TAGID</option>
        </select> 
        <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
        <select name="cid" id="cid">
          <option value="0">不限分类</option>
		  <?=$cs?>
        </select>
        <input name="isgood" type="checkbox" id="isgood" value="1"<?=$isgood==1?' checked':''?>>
        推荐TAGS
        <select name="orderby" id="orderby">
          <option value="0"<?=$orderby==0?' selected':''?>>按TAGID降序排序</option>
		  <option value="1"<?=$orderby==1?' selected':''?>>按TAGID升序排序</option>
          <option value="2"<?=$orderby==2?' selected':''?>>按信息数降序排序</option>
		  <option value="3"<?=$orderby==3?' selected':''?>>按信息数升序排序</option>
        </select> 
        <input type="submit" name="Submit2" value="显示"></td>
    </tr>
  </form>
  </table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="listform" method="post" action="ListTags.php" onsubmit="return confirm('确认要操作?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="4%"><div align="center">选择</div></td>
      <td width="7%" height="25"> <div align="center">ID</div></td>
      <td width="25%" height="25"> <div align="center">TAG名称</div></td>
      <td width="25%" height="25"> <div align="center">信息数</div></td>
      <td width="21%"><div align="center">分类</div></td>
      <td width="18%" height="25"> <div align="center">操作</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	$st='';
  	if($r[isgood]==1)
	{
		$st='<font color="red">[推]</font>';
	}
	if($r[cid])
	{
		$cr=$empire->fetch1("select classname from {$dbtbpre}enewstagsclass where classid='$r[cid]'");
		$classname='<a href="ListTags.php?cid='.$r[cid].$ecms_hashur['ehref'].'">'.$cr[classname].'</a>';
	}
	else
	{
		$classname='未分类';
	}
	$rewriter=eReturnRewriteTagsUrl($r['tagid'],$r['tagname'],1);
	$tagsurl=$rewriter['pageurl'];
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="tagid[]" type="checkbox" id="tagid[]" value="<?=$r[tagid]?>">
        </div></td>
      <td height="25"> <div align="center"> 
          <?=$r[tagid]?>
        </div></td>
      <td height="25"> 
        <?=$st?>
        <a href="<?=$tagsurl?>" target="_blank">
        <?=$r[tagname]?>
        </a> </td>
      <td height="25"> <div align="center">
          <?=$r[num]?>
        </div></td>
      <td><div align="center">
          <?=$classname?>
        </div></td>
      <td height="25"> <div align="center">[<a href="AddTags.php?enews=EditTags&tagid=<?=$r[tagid]?>&fcid=<?=$cid?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;&nbsp;[<a href="ListTags.php?enews=DelTags&tagid=<?=$r[tagid]?>&fcid=<?=$cid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="center"> 
          <input type=checkbox name=chkall value=on onClick=CheckAll(this.form)>
        </div></td>
      <td height="25" colspan="5"> <div align="right">
          <input type="submit" name="Submit8" value="推荐" onClick="document.listform.enews.value='GoodTags';document.listform.isgood.value='1';">
          <input type="submit" name="Submit82" value="取消推荐" onClick="document.listform.enews.value='GoodTags';document.listform.isgood.value='0';">
          <input type="submit" name="Submit822" value="删除" onClick="document.listform.enews.value='DelTags_all';">
          目标TAGS 
          <input name="newtagname" type="text" size="20">
          <input type="submit" name="Submit3" value="合并" onClick="document.listform.enews.value='MergeTags';">
          <input name="enews" type="hidden" id="enews" value="DelTags_all">
          <input name="isgood" type="hidden" id="isgood" value="1">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25" colspan="5">
        <?=$returnpage?>
      </td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>