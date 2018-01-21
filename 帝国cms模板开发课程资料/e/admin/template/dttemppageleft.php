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
CheckLevel($logininid,$loginin,$classid,"dttemp");
//关闭
if(!$ecms_config['esafe']['openeditdttemp'])
{
	echo"没有开启在线修改动态页面模板";
	exit();
}

$showtempr=array();
$showtempr['incfile']='';
$showtempr['doinfo']='';
$showtempr['pubtemp']='';
$showtempr['shopsys']='';
$showtempr['member']='';
$showtempr['membermsg']='';
$showtempr['memberfriend']='';
$showtempr['memberfav']='';
$showtempr['memberother']='';
$showtempr['memberspace']='';
$showtempr['memberconnect']='';
$showtempr['diytemp']='';
$tempsql=$empire->query("select tempid,tempvar,tempname,tempfile,temptype from {$dbtbpre}enewstempdt order by myorder,tempid");
while($tempr=$empire->fetch($tempsql))
{
	$andstr='<tr><td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor=\'#EFEFEF\'" onMouseOut="this.style.backgroundColor=\'#FFFFFF\'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="EditDttemp.php?tempid='.$tempr['tempid'].$ecms_hashur['ehref'].'" target="apmain">'.$tempr['tempname'].'</a></td></tr>';
	if($tempr['temptype']=='incfile')
	{
		$showtempr['incfile'].=$andstr;
	}
	if($tempr['temptype']=='doinfo')
	{
		$showtempr['doinfo'].=$andstr;
	}
	if($tempr['temptype']=='pubtemp')
	{
		$showtempr['pubtemp'].=$andstr;
	}
	if($tempr['temptype']=='shopsys')
	{
		$showtempr['shopsys'].=$andstr;
	}
	if($tempr['temptype']=='member')
	{
		$showtempr['member'].=$andstr;
	}
	if($tempr['temptype']=='membermsg')
	{
		$showtempr['membermsg'].=$andstr;
	}
	if($tempr['temptype']=='memberfriend')
	{
		$showtempr['memberfriend'].=$andstr;
	}
	if($tempr['temptype']=='memberfav')
	{
		$showtempr['memberfav'].=$andstr;
	}
	if($tempr['temptype']=='memberother')
	{
		$showtempr['memberother'].=$andstr;
	}
	if($tempr['temptype']=='memberspace')
	{
		$showtempr['memberspace'].=$andstr;
	}
	if($tempr['temptype']=='memberconnect')
	{
		$showtempr['memberconnect'].=$andstr;
	}
	if($tempr['temptype']=='diytemp')
	{
		$showtempr['diytemp'].=$andstr;
	}
}
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
	if(imgname=="incfileimg")
	{
		img=todisplay(incfile,phome);
		document.images.incfileimg.src=img;
	}
	else if(imgname=="memberimg")
	{
		img=todisplay(member,phome);
		document.images.memberimg.src=img;
	}
	else if(imgname=="memberfunimg")
	{
		img=todisplay(memberfun,phome);
		document.images.memberfunimg.src=img;
	}
	else if(imgname=="memberspaceimg")
	{
		img=todisplay(memberspace,phome);
		document.images.memberspaceimg.src=img;
	}
	else if(imgname=="memberconnectimg")
	{
		img=todisplay(memberconnect,phome);
		document.images.memberconnectimg.src=img;
	}
	else if(imgname=="memberotherimg")
	{
		img=todisplay(memberother,phome);
		document.images.memberotherimg.src=img;
	}
	else if(imgname=="doinfoimg")
	{
		img=todisplay(doinfo,phome);
		document.images.doinfoimg.src=img;
	}
	else if(imgname=="shopsysimg")
	{
		img=todisplay(shopsys,phome);
		document.images.shopsysimg.src=img;
	}
	else if(imgname=="pubtempimg")
	{
		img=todisplay(pubtemp,phome);
		document.images.pubtempimg.src=img;
	}
	else if(imgname=="diytempimg")
	{
		img=todisplay(diytemp,phome);
		document.images.diytempimg.src=img;
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
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="incfileid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="incfileimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(incfile,"incfileimg"); style="CURSOR: hand">公共引用页面</a></td>
  </tr>
  <tbody id="incfile">
	<?=$showtempr['incfile']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="memberid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="memberimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(member,"memberimg"); style="CURSOR: hand">会员基本页面</a></td>
  </tr>
  <tbody id="member">
  	<?=$showtempr['member']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="memberfunid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="memberfunimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(memberfun,"memberfunimg"); style="CURSOR: hand">会员模块页面</a></td>
  </tr>
  <tbody id="memberfun">
    <tr>
      <td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;短消息页面</td>
    </tr>
	<?=$showtempr['membermsg']?>
	<tr>
      <td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;好友页面</td>
    </tr>
	<?=$showtempr['memberfriend']?>
	<tr>
      <td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收藏夹页面</td>
    </tr>
	<?=$showtempr['memberfav']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="memberspaceid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="memberspaceimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(memberspace,"memberspaceimg"); style="CURSOR: hand">会员空间</a></td>
  </tr>
  <tbody id="memberspace">
	<?=$showtempr['memberspace']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="memberconnectid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="memberconnectimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(memberconnect,"memberconnectimg"); style="CURSOR: hand">会员登录绑定</a></td>
  </tr>
  <tbody id="memberconnect">
	<?=$showtempr['memberconnect']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="memberotherid">
  <tr>
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="memberotherimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(memberother,"memberotherimg"); style="CURSOR: hand">会员其他页面</a></td>
  </tr>
  <tbody id="memberother">
	<?=$showtempr['memberother']?>
  </tbody>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doinfoid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="doinfoimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(doinfo,"doinfoimg"); style="CURSOR: hand">投稿</a></td>
  </tr>
  <tbody id="doinfo">
  	<?=$showtempr['doinfo']?>
  </tbody>
</table>
  <br>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="shopsysid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="shopsysimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(shopsys,"shopsysimg"); style="CURSOR: hand">商城</a></td>
  </tr>
  <tbody id="shopsys">
  	<?=$showtempr['shopsys']?>
  </tbody>
</table>
  <br>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="pubtempid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="pubtempimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(pubtemp,"pubtempimg"); style="CURSOR: hand">其他</a></td>
    </tr>
    <tbody id="pubtemp">
      <?=$showtempr['pubtemp']?>
    </tbody>
  </table>
  <br>
<?php
if($showtempr['diytemp'])
{
?>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="diytempid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="diytempimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(diy,"diytempimg"); style="CURSOR: hand">自定义</a></td>
    </tr>
    <tbody id="diy">
      <?=$showtempr['diytemp']?>
    </tbody>
  </table>
  <br>
<?php
}
?>
</body>
</html>
<?php
db_close();
$empire=null;
?>