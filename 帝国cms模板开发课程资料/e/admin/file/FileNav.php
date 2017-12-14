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
//CheckLevel($logininid,$loginin,$classid,"file");
$gr=ReturnLeftLevel($loginlevel);

$url="<a href=ListFile.php?type=9".$ecms_hashur['ehref'].">管理附件</a>";
$filer=$empire->fetch1("select filedatatbs,filedeftb from {$dbtbpre}enewspublic limit 1");
$tr=explode(',',$filer['filedatatbs']);
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
	if(imgname=="infofileimg")
	{
		img=todisplay(doinfofile,phome);
		document.images.infofileimg.src=img;
	}
	else if(imgname=="otherfileimg")
	{
		img=todisplay(dootherfile,phome);
		document.images.otherfileimg.src=img;
	}
	else if(imgname=="fotherimg")
	{
		img=todisplay(dofother,phome);
		document.images.fotherimg.src=img;
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
if($gr['dofile'])
{
?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doinfofileid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="infofileimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(doinfofile,"infofileimg"); style="CURSOR: hand">管理信息附件</a></td>
  </tr>
  <tbody id="doinfofile">
	  <?php
	  $count=count($tr)-1;
	  for($i=1;$i<$count;$i++)
	  {
		$thistb=$tr[$i];
		$fstbname="信息附件表".$thistb;
		$filetbname=$dbtbpre.'enewsfile_'.$thistb;
		if($thistb==$filer['filedeftb'])
		{
			$fstbname='<b>'.$fstbname.'</b>';
		}
	  ?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&fstb=<?=$tr[$i]?><?=$ecms_hashur['ehref']?>" target="apmain"><?=$fstbname?></a></td>
    </tr>
	  <?php
	  }
	  ?>
  </tbody>
</table>
  <br>
  <br>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="dootherfileid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="otherfileimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dootherfile,"otherfileimg"); style="CURSOR: hand">管理其他附件</a></td>
    </tr>
    <tbody id="dootherfile">
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=5<?=$ecms_hashur['ehref']?>" target="apmain">公共附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=1<?=$ecms_hashur['ehref']?>" target="apmain">栏目附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=2<?=$ecms_hashur['ehref']?>" target="apmain">专题附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=6<?=$ecms_hashur['ehref']?>" target="apmain">会员附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=7<?=$ecms_hashur['ehref']?>" target="apmain">碎片附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=4<?=$ecms_hashur['ehref']?>" target="apmain">反馈附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListFile.php?type=9&modtype=3<?=$ecms_hashur['ehref']?>" target="apmain">广告附件</a></td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
<?php
}
?>
<?php
if($gr['dofile']||$gr['dofiletable'])
{
?>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="dofotherid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="fotherimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dofother,"fotherimg"); style="CURSOR: hand">其他管理</a></td>
    </tr>
    <tbody id="dofother">
	<?php
	if($gr['dofile'])
	{
	?>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="FilePath.php<?=$ecms_hashur['whehref']?>" target="apmain">目录式管理附件</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="TranMoreFile.php<?=$ecms_hashur['whehref']?>" target="apmain">上传多附件</a></td>
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