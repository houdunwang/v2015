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
	if(imgname=="listddimg")
	{
		img=todisplay(dolistdd,phome);
		document.images.listddimg.src=img;
	}
	else if(imgname=="addsaleimg")
	{
		img=todisplay(doaddsale,phome);
		document.images.addsaleimg.src=img;
	}
	else if(imgname=="paysendimg")
	{
		img=todisplay(dopaysend,phome);
		document.images.paysendimg.src=img;
	}
	else if(imgname=="setshopimg")
	{
		img=todisplay(dosetshop,phome);
		document.images.setshopimg.src=img;
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
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="dolistddid">
  <tr> 
    <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="listddimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dolistdd,"listddimg"); style="CURSOR: hand">管理订单</a></td>
  </tr>
  <tbody id="dolistdd">
    <tr> 
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListDd.php<?=$ecms_hashur['whehref']?>" target="apmain">所有订单</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListDd.php?sear=1&outproduct=9<?=$ecms_hashur['ehref']?>" target="apmain">未发货订单</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListDd.php?sear=1&outproduct=2<?=$ecms_hashur['ehref']?>" target="apmain">备货中的订单</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListDd.php?sear=1&outproduct=1<?=$ecms_hashur['ehref']?>" target="apmain">已发货的订单</a></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListDd.php?sear=1&checked=3<?=$ecms_hashur['ehref']?>" target="apmain">退货的订单</a></td>
    </tr>
  </tbody>
</table>
  <br>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="doaddsaleid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="addsaleimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(doaddsale,"addsaleimg"); style="CURSOR: hand">管理促销</a></td>
    </tr>
    <tbody id="doaddsale">
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListPrecode.php<?=$ecms_hashur['whehref']?>" target="apmain">优惠码</a></td>
      </tr>
    </tbody>
  </table>
  <br>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="dopaysendid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="paysendimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dopaysend,"paysendimg"); style="CURSOR: hand">支付与配送</a></td>
    </tr>
    <tbody id="dopaysend">
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListPayfs.php<?=$ecms_hashur['whehref']?>" target="apmain">管理支付方式</a></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ListPs.php<?=$ecms_hashur['whehref']?>" target="apmain">管理配送方式</a></td>
      </tr>
    </tbody>
  </table>
  <br>
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tableborder" id="dosetshopid">
    <tr>
      <td height="25" class="header"><img src="../openpage/images/noadd.gif" name="setshopimg" width="20" height="9" border="0"><a href="#ecms" onMouseUp=turnit(dosetshop,"setshopimg"); style="CURSOR: hand">商城参数设置</a></td>
    </tr>
    <tbody id="dosetshop">
      <tr>
        <td height="25" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#EFEFEF'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="SetShopSys.php<?=$ecms_hashur['whehref']?>" target="apmain">商城参数设置</a></td>
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