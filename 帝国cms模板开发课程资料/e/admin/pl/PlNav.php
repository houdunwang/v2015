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
//CheckLevel($logininid,$loginin,$classid,"pl");
$gr=ReturnLeftLevel($loginlevel);

$plr=$empire->fetch1("select pldatatbs,pldeftb from {$dbtbpre}enewspl_set limit 1");
$tr=explode(',',$plr['pldatatbs']);
//今日评论
$pur=$empire->fetch1("select lasttimepl,lastnumpl,lastnumpltb,todaytimeinfo,todaytimepl,todaynumpl,yesterdaynumpl from {$dbtbpre}enewspublic_update limit 1");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>菜单</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<SCRIPT lanuage="JScript">
function DisplayImg(ss,imgname,phome)
{
	if(imgname=="plimg")
	{
		img=todisplay(dopl,phome);
		document.images.plimg.src=img;
	}
	else if(imgname=="plotherimg")
	{
		img=todisplay(doplother,phome);
		document.images.plotherimg.src=img;
	}
	else
	{
	}
}
function todisplay(ss,phome)
{
	if(ss.style.display=="") 
	{
  		ss.style.display="none";
		theimg="../openpage/images/add.gif";
	}
	else
	{
  		ss.style.display="";
		theimg="../openpage/images/noadd.gif";
	}
	return theimg;
}
function turnit(ss,img)
{
	DisplayImg(ss,img,0);
}
</SCRIPT>
</head>

<body topmargin="0">
<br>
<?php
if($gr['dopl'])
{
?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doplid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="plimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dopl,"plimg"); style="CURSOR: hand">管理评论</a></td>
  </tr>
  <tbody id="dopl">
	  <?php
	  $count=count($tr)-1;
	  for($i=1;$i<$count;$i++)
	  {
		$thistb=$tr[$i];
		$restbname="评论表".$thistb;
		$pltbname=$dbtbpre.'enewspl_'.$thistb;
		if($thistb==$plr['pldeftb'])
		{
			$restbname='<b>'.$restbname.'</b>';
		}
		$exp='|'.$thistb.',';
		$addnumr=explode($exp,$pur['lastnumpltb']);
		$addnumrt=explode('|',$addnumr[1]);
		$addnum=(int)$addnumrt[0];
	  ?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListAllPl.php?restb=<?=$tr[$i]?><?=$ecms_hashur['ehref']?>" title="+<?=$addnum?>" target="apmain"><?=$restbname?></a></td>
    </tr>
	  <?php
	  }
	  ?>
  </tbody>
</table>
  <br>
  <br>
<?php
}
?>
<?php
if($gr['doplf']||$gr['dopltable']||$gr['dopl']||$gr['dopublic'])
{
?>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doplotherid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="ztimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(doplother,"plotherimg"); style="CURSOR: hand">其他管理</a></td>
    </tr>
    <tbody id="doplother">
	<?php
	if($gr['doplf'])
	{
	?>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListPlF.php<?=$ecms_hashur['whehref']?>" target="apmain">自定义评论字段</a></td>
      </tr>
	<?php
	}
	?>
	<?php
	if($gr['dopl'])
	{
	?>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="DelMorePl.php<?=$ecms_hashur['whehref']?>" target="apmain">批量删除评论</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="plface.php<?=$ecms_hashur['whehref']?>" target="apmain">管理评论表情</a></td>
      </tr>
	<?php
	}
	?>
	<?php
	if($gr['dopublic'])
	{
	?>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="SetPl.php<?=$ecms_hashur['whehref']?>" target="apmain">设置评论参数</a></td>
      </tr>
	<?php
	}
	?>
    </tbody>
  </table>
<?php
}
?>
  <br>

</body>
</html>
<?php
db_close();
$empire=null;
?>