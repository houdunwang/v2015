<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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

//推送信息
function PushInfoToZt($add,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	$tid=(int)$add['tid'];
	$ztid=$add['ztid'];
	$cid=$add['cid'];
	$id=$add['id'];
	$count=count($ztid);
	if(!$count||!$id)
	{
		echo"<script>window.close();</script>";
		exit();
	}
	//表名
	$tbname='';
	if($classid)
	{
		$tbname=$class_r[$classid]['tbname'];
	}
	elseif($tid)
	{
		$tbr=$empire->fetch1("select tbname from {$dbtbpre}enewstable where tid='$tid'");
		$tbname=$tbr['tbname'];
	}
	if(!$tbname)
	{
		printerror('ErrorUrl','');
	}
	//ID
	$id=eReturnInids($id);
	$where='id in ('.$id.')';
	$ztids='';
	$zcids='';
	for($i=0;$i<$count;$i++)
	{
		$true_ztid=(int)$ztid[$i];
		if(!$true_ztid)
		{
			continue;
		}
		$true_cid=(int)$cid[$true_ztid];
		if($true_cid<0)
		{
			$true_cid=0;
		}
		$ztids.=$dh.$true_ztid;
		$dh=',';
		AddMoreInfoToZt($true_ztid,$true_cid,$tbname,$where,1);
	}
	//操作日志
	insert_dolog("classid=$classid&tid=$tid<br>ztid=".$ztids."<br>id=".$id);
	echo"<script>alert('推送成功');window.close();</script>";
	exit();
}

//返回所属选择专题
function ReturnZtToInfo($add,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$ztid=$add['ztid'];
	$cid=$add['cid'];
	$count=count($ztid);
	if(!$count)
	{
		//echo"<script>window.close();</script>";
		//exit();
	}
	$ztids='';
	$zcids='';
	$oldztids=$add['oldztids'];
	$oldzcids=$add['oldcids'];
	for($i=0;$i<$count;$i++)
	{
		$true_ztid=(int)$ztid[$i];
		if(!$true_ztid)
		{
			continue;
		}
		$true_cid=(int)$cid[$true_ztid];
		$ztids.=$dh.$true_ztid;
		$dh=',';
		$zcids.=$cdh.$true_cid;
		$cdh=',';
	}
	?>
	<script>
	opener.document.add.ztids.value="<?=$ztids?>";
	opener.document.add.zcids.value="<?=$zcids?>";
	opener.document.add.oldztids.value="<?=$oldztids?>";
	opener.document.add.oldzcids.value="<?=$oldzcids?>";
	window.close();
	</script>
	<?php
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='PushInfoToZt')//选择专题
{
	if($_POST['sinfo'])
	{
		ReturnZtToInfo($_POST,$logininid,$loginin);
	}
	PushInfoToZt($_POST,$logininid,$loginin);
}

$add='';
//分类
$zcid=(int)$_GET['zcid'];
if($zcid)
{
	$add.=" and zcid='$zcid'";
}
//栏目
$classid=(int)$_GET['classid'];
if($classid)
{
	$classwhere=ReturnClass($class_r[$classid][featherclass]);
	$add.=" and (classid=0 or classid='$classid' or (".$classwhere."))";
}
$sinfo=(int)$_GET['sinfo'];
//表ID
$tid=(int)$_GET['tid'];
//ID
$id=RepPostStr($_GET['id'],1);
if(empty($sinfo)&&!$id)
{
	echo"<script>alert('请选择信息');window.close();</script>";
	exit();
}
//信息
$info_ztids='';
$info_cids='';
if($sinfo&&$id)
{
	$ztdh='';
	$cdh='';
	$id=(int)$id;
	$infosql=$empire->query("select ztid,cid from {$dbtbpre}enewsztinfo where id='$id' and classid='$classid'");
	while($infor=$empire->fetch($infosql))
	{
		$info_ztids.=$ztdh.$infor['ztid'];
		$ztdh=',';
		if($infor['cid'])
		{
			$info_cids.=$cdh.$infor['cid'];
		}
		else
		{
			$info_cids.=$cdh.'-'.$infor['ztid'];
		}
		$cdh=',';
	}
}
elseif($sinfo&&empty($id))
{
	$firstpost=1;
}
$time=time();
//专题
$query="select ztid,ztname from {$dbtbpre}enewszt where usezt=0 and (endtime=0 or endtime>$time)".$add." order by myorder,ztid desc";
$sql=$empire->query($query);
//分类
$zcstr="";
$zcsql=$empire->query("select classid,classname from {$dbtbpre}enewsztclass order by classid");
while($zcr=$empire->fetch($zcsql))
{
	$select="";
	if($zcr[classid]==$zcid)
	{
		$select=" selected";
	}
	$zcstr.="<option value='".$zcr[classid]."'".$select.">".$zcr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>推送信息到专题</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td>位置: 推送信息到专题
<div align="right"> </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchform" method="GET" action="PushToZt.php">
<?=$ecms_hashur['eform']?>
  <tr> 
      <td> 选择专题分类： 
        <select name="select" id="select" onchange=window.location='PushToZt.php?<?=$ecms_hashur['ehref']?>&classid=<?=$classid?>&tid=<?=$tid?>&id=<?=$id?>&sinfo=<?=$sinfo?>&oldztids=<?=$info_ztids?>&oldcids=<?=$info_cids?>&zcid='+this.options[this.selectedIndex].value>
          <option value="0">所有分类</option>
          <?=$zcstr?>
        </select></td>
  </tr>
</form>
</table>
<form name="form1" method="post" action="PushToZt.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <?=$ecms_hashur['form']?>
    <tr>
      <td>
	  <?php
	  if(empty($sinfo))
	  {
	  ?>
	  推送信息ID：<?=$id?>
	  <?php
	  }
	  else
	  {
	  ?>
	  推送信息：<script>document.write(opener.document.add.title.value);</script>
	  <?php
	  }
	  ?>
	  </td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="74%" height="25"> 专题名称</td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
	  $check='';
	  if($info_ztids&&strstr(','.$info_ztids.',',','.$r[ztid].','))
	  {
		  $check=' checked';
	  }
  ?>
    <tr bgcolor="#FFFFFF" id="chzt<?=$r[ztid]?>"> 
      <td height="25"><input name="ztid[]" type="checkbox" id="ztid[]" value="<?=$r[ztid]?>"<?=$check?>>
        <?=$r['ztname']?></td>
    </tr>
	  <tr bgcolor="#FFFFFF">
      <td height="25"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
			<tr>
				<td><input type="radio" name="cid[<?=$r['ztid']?>]" value="-<?=$r[ztid]?>"<?=empty($check)||$firstpost==1||($check&&$info_cids&&strstr(','.$info_cids.',',',-'.$r[ztid].','))?' checked':''?>> 不属专题子类</td>
			</tr>
		<?php
		$csql=$empire->query("select cid,cname from {$dbtbpre}enewszttype where ztid='$r[ztid]'");
		while($cr=$empire->fetch($csql))
		{
			?>
			<tr>
				<td><input type="radio" name="cid[<?=$r['ztid']?>]" value="<?=$cr[cid]?>"<?=$check&&$info_cids&&strstr(','.$info_cids.',',','.$cr[cid].',')?' checked':''?>> <?=$cr[cname]?></td>
			</tr>
			<?php
		}
		?>
        </table></td>
    </tr>
    <?php
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit2" value="确定推送">
          &nbsp;&nbsp; 
          <input type="button" name="Submit3" value="取消" onclick="window.close();">
          <input name="enews" type="hidden" id="enews" value="PushInfoToZt">
          <input name="classid" type="hidden" id="classid" value="<?=$classid?>">
          <input name="tid" type="hidden" id="tid" value="<?=$tid?>">
          <input name="id" type="hidden" id="id" value="<?=$id?>">
		  <input name="sinfo" type="hidden" id="sinfo" value="<?=$sinfo?>">
			<input name="oldztids" type="hidden" value="<?=$info_ztids?>">
			<input name="oldcids" type="hidden" value="<?=$info_cids?>">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
