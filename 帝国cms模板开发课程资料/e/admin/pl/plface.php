<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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
CheckLevel($logininid,$loginin,$classid,"pl");

//验证文件
function CheckPlfaceFilename($filename){
	if(strstr($filename,"\\")||strstr($filename,"/")||strstr($filename,".."))
	{
		printerror("FileNotExist","history.go(-1)");
	}
	//文件是否存在
	if(!file_exists("../../data/face/".$filename))
	{
		printerror("FileNotExist","history.go(-1)");
	}
}

//过滤字符
function DoRepPlface($str){
	$str=str_replace('##','',$str);
	$str=str_replace('||','',$str);
	return $str;
}

//------------------增加表情
function AddPlface($add,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[facefile]||!$add[faceword])
	{
		printerror("EmptyPlface","history.go(-1)");
	}
	$facefile=DoRepPlface($add[facefile]);
	$faceword=DoRepPlface($add[faceword]);
	CheckPlfaceFilename($add[facefile]);
	$r=$empire->fetch1("select plface from {$dbtbpre}enewspl_set limit 1");
	if(strstr($r[plface],'||'.$faceword.'##'))
	{
		printerror("HavePlface","history.go(-1)");
	}
	if(empty($r[plface]))
	{
		$r[plface]='||';
	}
	$newplface=$r[plface].$faceword."##".$facefile."||";
	$sql=$empire->query("update {$dbtbpre}enewspl_set set plface='$newplface' limit 1");
	if($sql)
	{
		GetPlfaceJs();
		GetConfig();//更新缓存
		//操作日志
		insert_dolog("$faceword");
		printerror("AddPlfaceSuccess","plface.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------修改表情
function EditPlface($add,$userid,$username){
	global $empire,$dbtbpre;
	$facefile=$add[facefile];
	$faceword=$add[faceword];
	$count=count($faceword);
	$plface='||';
	for($i=0;$i<$count;$i++)
	{
		$facefile[$i]=DoRepPlface($facefile[$i]);
		$faceword[$i]=DoRepPlface($faceword[$i]);
		if($faceword[$i])
		{
			$plface.=$faceword[$i]."##".$facefile[$i]."||";
		}
	}
	$sql=$empire->query("update {$dbtbpre}enewspl_set set plface='$plface' limit 1");
	if($sql)
	{
		GetPlfaceJs();
		GetConfig();//更新缓存
		//操作日志
		insert_dolog("");
		printerror("EditPlfaceSuccess","plface.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------生成表情JS
function GetPlfaceJs(){
	global $empire,$dbtbpre,$public_r;
	$r=$empire->fetch1("select plface,plfacenum from {$dbtbpre}enewspl_set limit 1");
	if(empty($r['plfacenum']))
	{
		return '';
	}
	$filename="../../../d/js/js/plface.js";
	$facer=explode('||',$r['plface']);
	$count=count($facer);
	for($i=1;$i<$count-1;$i++)
	{
		if($i%$r['plfacenum']==0)
		{
			$br="<br>";
		}
		else
		{
			$br="&nbsp;";
		}
		$face=explode('##',$facer[$i]);
		$allface.="<a href='#eface' onclick=\\\"eaddplface('".$face[0]."');\\\"><img src='".$public_r[newsurl]."e/data/face/".$face[1]."' border=0></a>".$br;
	}
	$allface="document.write(\"<script src='".$public_r[newsurl]."e/data/js/addplface.js'></script>\");document.write(\"".$allface."\");";
	WriteFiletext_n($filename,$allface);
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('../../class/hplfun.php');
}
//增加
if($enews=="AddPlface")
{
	AddPlface($_POST,$logininid,$loginin);
}
//修改
elseif($enews=="EditPlface")
{
	EditPlface($_POST,$logininid,$loginin);
}
$r=$empire->fetch1("select plface from {$dbtbpre}enewspl_set limit 1");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理评论表情</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="ListAllPl.php<?=$ecms_hashur['whehref']?>">管理评论</a> &gt; <a href="plface.php<?=$ecms_hashur['whehref']?>">管理评论表情</a></td>
  </tr>
</table>
<form name="addplfaceform" method="post" action="plface.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="53%" height="25">增加表情: 
        <input type=hidden name=enews value=AddPlface></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">将符号:
<input name="faceword" type="text" id="faceword">
          替换成图片:
		  e/data/face/<input name="facefile" type="text" id="facefile" value="">
          <a href="#ecms" onclick="window.open('ChangePlfaceFile.php?returnform=opener.document.addplfaceform.facefile.value<?=$ecms_hashur['ehref']?>','','width=400,height=500,scrollbars=yes');">[选择]</a> 
          &nbsp;<input type="submit" name="Submit" value="增加">
        </div></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="plfaceform" method=post action=plface.php>
  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=EditPlface>
    <tr class="header"> 
      <td width="79%" height="25"><div align="center">管理表情</div></td>
    </tr>
    <?php
	$facer=explode("||",$r[plface]);
	$count=count($facer);
	for($i=1;$i<$count-1;$i++)
	{
		$face=explode("##",$facer[$i]);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center">将符号 
          <input name="faceword[]" type="text" value="<?=$face[0]?>">
          替换成&nbsp;
		  <img src="../../data/face/<?=$face[1]?>" border=0>&nbsp;(e/data/face/ 
          <input name="facefile[]" type="text" value="<?=$face[1]?>">
          )</div></td>
    </tr>
	<?
	}
	?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"><div align="center"> 
        <input type="submit" name="Submit3" value="提交">
        &nbsp; 
        <input name="Submit4" type="reset" value="重置">
      </div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25"><font color="#666666">说明：要删除的表情将符号设为空即可。</font></td>
  </tr>
  </form>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>前台评论表情调用代码：
      <input name="textfield" type="text" value="&lt;script src=&quot;<?=$public_r['newsurl']?>d/js/js/plface.js&quot;&gt;&lt;/script&gt;" size="60">
      [<a href="../view/js.php?js=plface&p=js<?=$ecms_hashur['ehref']?>" target="_blank">预览</a>]</td>
  </tr>
</table>
</body>
</html>
