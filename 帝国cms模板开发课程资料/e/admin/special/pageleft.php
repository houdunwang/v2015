<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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

$ztid=(int)$_GET['ztid'];
if(empty($class_zr[$ztid][zturl]))
{$zturl=$public_r[newsurl].$class_zr[$ztid][ztpath]."/";}
else
{$zturl=$class_zr[$ztid][zturl];}
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
	if(imgname=="ztimg")
	{
		img=todisplay(dozt,phome);
		document.images.ztimg.src=img;
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
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doztid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="ztimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dozt,"ztimg"); style="CURSOR: hand">当前专题管理</a></td>
  </tr>
  <tbody id="dozt">
    <tr> 
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="AddZt.php?enews=EditZt&ztid=<?=$ztid?>&from=1<?=$ecms_hashur['ehref']?>" target="apmain">修改专题</a></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ZtType.php?ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>" target="apmain">管理专题子类</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListZtInfo.php?ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>" target="apmain">管理信息</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../pl/ListZtPl.php?ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>" target="apmain">管理评论</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="TogZt.php?ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>" target="apmain">组合专题</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="SpecialPathfile.php?ztid=<?=$ztid?><?=$ecms_hashur['ehref']?>" target="apmain">管理专题附件</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../ecmschtml.php?enews=ReZtHtml&ztid=<?=$ztid?>&ecms=1<?=$ecms_hashur['href']?>" target="apmain">刷新专题页面</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$zturl?>" target="_blank">预览专题</a></td>
    </tr>
  </tbody>
</table>
  <br>
</body>
</html>
<?php
db_close();
$empire=null;
?>