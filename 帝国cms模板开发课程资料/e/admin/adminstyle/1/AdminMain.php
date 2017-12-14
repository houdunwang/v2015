<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
$r=ReturnLeftLevel($loginlevel);
//菜单显示
$showfastmenu=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmenuclass where classtype=1 limit 1");//常用菜单
$showextmenu=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmenuclass where classtype=3 limit 1");//扩展菜单
$showshopmenu=stristr($public_r['closehmenu'],',shop,')?0:1;
//图片识别
if(stristr($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0'))
{
	$menufiletype='.gif';
}
else
{
	$menufiletype='.png';
}
?>
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<TITLE>帝国网站管理系统 － 最安全、最稳定的开源CMS系统</TITLE>
<LINK href="adminstyle/1/adminmain.css" rel=stylesheet>
<STYLE>
.flyoutLink A {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:hover {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:visited {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:active {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutMenu {
	BACKGROUND-COLOR: #C9F1FF
}
.flyoutMenu TD.flyoutLink {
	BORDER-RIGHT: #C9F1FF 1px solid; BORDER-TOP: #C9F1FF 1px solid; BORDER-LEFT: #C9F1FF 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #C9F1FF 1px solid
}
.flyoutMenu1 {
	BACKGROUND-COLOR: #fbf9f9
}
.flyoutMenu1 TD.flyoutLink1 {
	BORDER-RIGHT: #fbf9f9 1px solid; BORDER-TOP: #fbf9f9 1px solid; BORDER-LEFT: #fbf9f9 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #fbf9f9 1px solid
}
</STYLE>
<SCRIPT>
function switchSysBar(){
	if(switchPoint.innerText==3)
	{
		switchPoint.innerText=4
		document.all("frmTitle").style.display="none"
	}
	else
	{
		switchPoint.innerText=3
		document.all("frmTitle").style.display=""
	}
}
function switchSysBarInfo(){
	switchPoint.innerText=3
	document.all("frmTitle").style.display=""
}

function about(){
	window.showModalDialog("adminstyle/1/page/about.htm","ABOUT","dialogwidth:300px;dialogheight:150px;center:yes;status:no;scroll:no;help:no");
}

function over(obj){
		if(obj.className=="flyoutLink")
		{
			obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'
		}
		else if(obj.className=="flyoutLink1")
		{
		    obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'				
		}
}
function out(obj){
		if(obj.className=="flyoutLink")
		{
			obj.style.backgroundColor='#C9F1FF'
			obj.style.borderColor = 'C9F1FF'
		}
		else if(obj.className=="#flyoutLink1")
		{
		    obj.style.backgroundColor='#FBF9F9'
			obj.style.borderColor = '#FBF9F9'				
		}
}

function show(d){
	if(obj=document.all(d))	obj.style.visibility="visible";

}
function hide(d){
	if(obj=document.all(d))	obj.style.visibility="hidden";
}

function JumpToLeftMenu(url){
	document.getElementById("left").src=url;
}
function JumpToMain(url){
	document.getElementById("main").src=url;
}
function DoOnclickMenu(m){
	if(m!='dosysmenu')
	{
		document.getElementById("dosysmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("dosysmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='doinfomenu')
	{
		document.getElementById("doinfomenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("doinfomenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='doclassmenu')
	{
		document.getElementById("doclassmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("doclassmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='dotempmenu')
	{
		document.getElementById("dotempmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("dotempmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='dousermenu')
	{
		document.getElementById("dousermenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("dousermenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='dotoolmenu')
	{
		document.getElementById("dotoolmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("dotoolmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='doshopmenu')
	{
		document.getElementById("doshopmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("doshopmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='doextmenu')
	{
		document.getElementById("doextmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("doextmenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='doothermenu')
	{
		document.getElementById("doothermenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("doothermenu").style.backgroundColor='#8CBDEF';
	}
	if(m!='dofastmenu')
	{
		document.getElementById("dofastmenu").style.backgroundColor='';
	}
	else
	{
		document.getElementById("dofastmenu").style.backgroundColor='#8CBDEF';
	}
	document.menuform.onclickmenu.value=m;
}
</SCRIPT>
</HEAD>
<BODY bgColor="#C9F1FF" leftMargin=0 topMargin=0>
<TABLE width="100%" height="100%" border=0 cellpadding="0" cellSpacing=0>
<tr>
<td height="60">

  <TABLE width="100%" height="60" border=0 cellpadding="0" cellSpacing=0 background="adminstyle/1/images/topbg.gif">
  <form name="menuform" id="menuform">
    <TBODY>
	<input type="hidden" name="onclickmenu" value="">
      <TR> 
            <TD width="180"><div align="center"><a href="main.php<?=$ecms_hashur['whehref']?>" target="main" title="帝国网站管理系统"><img src="adminstyle/1/images/logo.gif" border="0"></a></div></TD>
		<TD height="60"> 
			<TABLE width="760" height="60" border=0 cellpadding="0" cellSpacing=0>
                <TBODY>
                  <TR align=middle> 
                    <TD width=60 onmouseover="if(document.menuform.onclickmenu.value!='dosysmenu'){this.style.backgroundColor='#8CBDEF';}" onmouseout="if(document.menuform.onclickmenu.value!='dosysmenu'){this.style.backgroundColor='';}" onclick="DoOnclickMenu('dosysmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=system<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="dosysmenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/system<?=$menufiletype?>" width=32 border=0 title="系统设置"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>系统</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='doinfomenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='doinfomenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('doinfomenu');switchSysBarInfo();JumpToLeftMenu('ListEnews.php<?=$ecms_hashur['whehref']?>');" style="CURSOR: hand" id="doinfomenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/info<?=$menufiletype?>" width=32 border=0 title="信息管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>信息</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='doclassmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='doclassmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('doclassmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=classdata<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="doclassmenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><img height=32 src="adminstyle/1/images/class<?=$menufiletype?>" width=32 border=0 title="栏目管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>栏目</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='dotempmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='dotempmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('dotempmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=template<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="dotempmenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><img src="adminstyle/1/images/template<?=$menufiletype?>" width="32" height="32" border="0" title="模板管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>模板</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='dousermenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='dousermenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('dousermenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=usercp<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="dousermenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/usercp<?=$menufiletype?>" width=32 border=0 title="用户和会员"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>用户</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='dotoolmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='dotoolmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('dotoolmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=tool<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="dotoolmenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/tool<?=$menufiletype?>" width=32 border=0 title="插件管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>插件</strong></font></div></td>
                        </tr>
                      </table></TD>
					<TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='doshopmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='doshopmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('doshopmenu');window.open('openpage/AdminPage.php?leftfile=<?=urlencode('../ShopSys/pageleft.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../other/OtherMain.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('商城系统管理')?><?=$ecms_hashur['ehref']?>','AdminShopSys','');" style="CURSOR: hand;<?=$showshopmenu?'':'display:none'?>" id="doshopmenu"> 
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/shop<?=$menufiletype?>" width=32 border=0 title="商城系统管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>商城</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='doothermenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='doothermenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('doothermenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=other<?=$ecms_hashur['ehref']?>');" style="CURSOR: hand" id="doothermenu"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/other<?=$menufiletype?>" width=32 border=0 title="其他管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>其他</strong></font></div></td>
                        </tr>
                      </table></TD>
					  <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='doextmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='doextmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('doextmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=extend<?=$ecms_hashur['ehref']?>');" style="CURSOR:hand;<?=$showextmenu?'':'display:none'?>" id="doextmenu"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/extend<?=$menufiletype?>" width=32 border=0 title="扩展菜单项"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>扩展</strong></font></div></td>
                        </tr>
                      </table> </TD>
                    <TD width=60 onmouseout="if(document.menuform.onclickmenu.value!='dofastmenu'){this.style.backgroundColor='';}" onmouseover="if(document.menuform.onclickmenu.value!='dofastmenu'){this.style.backgroundColor='#8CBDEF';}" onclick="DoOnclickMenu('dofastmenu');JumpToLeftMenu('adminstyle/1/left.php?ecms=fastmenu<?=$ecms_hashur['ehref']?>');" style="CURSOR:hand;<?=$showfastmenu?'':'display:none'?>" id="dofastmenu"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/1/images/fastmenu<?=$menufiletype?>" width=32 border=0 title="常用操作"></div></td>
                        </tr>
                        <tr> 
                          <td height="20">
<div align="center"><font color="#FFFFFF"><strong>常用</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width="301"><div align="right"><font color="#ffffff">用户：<a href="user/EditPassword.php<?=$ecms_hashur['whehref']?>" target="main"><font color="#ffffff"><b><?=$loginin?></b></font></a>&nbsp;&nbsp;&nbsp;[<a href="#ecms" onclick="if(confirm('确认要退出?')){JumpToMain('ecmsadmin.php?enews=exit<?=$ecms_hashur['href']?>');}"><font color="#ffffff">退出</font></a>]&nbsp;&nbsp;</font></div></TD>
                  </TR>
                </TBODY>
              </TABLE>
        
      </TD>
      </TR>
    </TBODY>
	</form>
  </TABLE>

</td></tr>
<tr><td height="22">

  <TABLE width="100%" height="22" border=0 cellpadding="0" cellSpacing=0>
    <TBODY>
      <TR> 
        <TD class=flyoutMenu width="1%"> </TD>   
		    <TD width="99%" height="27"> 
              <TABLE class=flyoutMenu border=0>
                <TBODY>
                  <TR align=middle> 
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('AddInfoChClass.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">增加信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListAllInfo.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListAllInfo.php?ecmscheck=1<?=$ecms_hashur['ehref']?>');" onmouseover="over(this)" onmouseout="out(this)">审核信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('workflow/ListWfInfo.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">签发信息</TD>
					<?php
					if($r[dopl])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../pl/PlMain.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('管理评论')?><?=$ecms_hashur['ehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理评论</TD>
					<?php
					}
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('sp/UpdateSp.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">更新碎片</TD>
					<TD width="60" class="flyoutLink" onclick="JumpToMain('special/UpdateZt.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">更新专题</TD>
					<?php
					if($r[dochangedata])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">数据更新</TD>
					<?php
					}
					?>
					<TD width="60" class="flyoutLink" onclick="JumpToMain('info/InfoMain.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">数据统计</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('infotop.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">排行统计</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('main.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">后台首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('../../');" onmouseover="over(this)" onmouseout="out(this)">网站首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('map.php<?=$ecms_hashur['whehref']?>','','width=1250,height=760,scrollbars=auto,resizable=yes,top=80,left=120');" onmouseover="over(this)" onmouseout="out(this)">后台地图</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('http://bbs.phome.net/listthread-23-cms-page-0.html');" onmouseover="over(this)" onmouseout="out(this)">版本更新</TD>
                  </TR>
                </TBODY>
              </TABLE>
            </TD>
      </TR>
    </TBODY>
  </TABLE>

</td></tr>
<tr><td height="100%" bgcolor="#ffffff">

  <TABLE width="100%" height="100%" cellpadding="0" cellSpacing=0 border=0 borderColor="#ff0000">
  <TBODY>
    <TR> 
      <TD width="123" valign="top" bgcolor="#C9F1FF">
		<IFRAME frameBorder="0" id="dorepage" name="dorepage" scrolling="no" src="DoTimeRepage.php<?=$ecms_hashur['whhref']?>" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
      </TD>
      <TD noWrap id="frmTitle">
		<IFRAME frameBorder="0" id="left" name="left" scrolling="auto" src="ListEnews.php<?=$ecms_hashur['whehref']?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:200px;Z-INDEX:2"></IFRAME>
      </TD>
      <TD>
		<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" bgcolor="#C9F1FF">
          <TBODY>
            <tr> 
              <TD onclick="switchSysBar()" style="HEIGHT:100%;"> <font style="COLOR:666666;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:9pt;"> 
                <SPAN id="switchPoint" title="打开/关闭左边导航栏">3</SPAN></font> 
          </TBODY>
        </TABLE>
      </TD>
      <TD width="100%">
		<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" align="right" border=0>
          <TBODY>
            <TR> 
              <TD align=right>
				<IFRAME id="main" name="main" style="WIDTH: 100%; HEIGHT: 100%" src="main.php<?=$ecms_hashur['whehref']?>" frameBorder=0></IFRAME>
              </TD>
            </TR>
          </TBODY>
        </TABLE>
      </TD>
    </TR>
  </TBODY>
  </TABLE>

</td></tr>
</TABLE>

</BODY>
</HTML>