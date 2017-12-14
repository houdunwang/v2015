<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
$r=ReturnLeftLevel($loginlevel);
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
<LINK href="adminstyle/2/adminmain.css" rel=stylesheet>
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
	window.showModalDialog("adminstyle/2/page/about.htm","ABOUT","dialogwidth:300px;dialogheight:150px;center:yes;status:no;scroll:no;help:no");
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

function tododisplay(ss){
	if(ss=="ecmsinfomenu") 
	{
  		document.getElementById('ecmsinfomenu').style.display="";
		document.getElementById('ecmssysmenu').style.display="none";
	}
	else
	{
  		document.getElementById('ecmsinfomenu').style.display="none";
		document.getElementById('ecmssysmenu').style.display="";
	}
}
</SCRIPT>
</HEAD>
<BODY bgColor="#C9F1FF" leftMargin=0 topMargin=0>
<TABLE width="100%" height="100%" border=0 cellpadding="0" cellSpacing=0>
<tr>
<td height="60">

  <TABLE width="100%" height="60" border=0 cellpadding="0" cellSpacing=0 background="adminstyle/2/images/topbg.gif">
    <TBODY>
      <TR> 
        <TD width="180"><div align="center"><a href="main.php<?=$ecms_hashur['whehref']?>" target="main" title="帝国网站管理系统"><img src="adminstyle/2/images/logo.gif" border="0"></a></div></TD>
		<TD height=60> 
			<TABLE width=480 height="60" border=0 cellpadding="0" cellSpacing=0>
                <TBODY>
                  <TR align=middle> 
                    <TD width=80 onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#8CBDEF';tododisplay('ecmsinfomenu');" onclick="switchSysBarInfo();JumpToLeftMenu('ListEnews.php<?=$ecms_hashur['whehref']?>');" style="CURSOR: hand"> 
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/2/images/info<?=$menufiletype?>" width=32 border=0 title="信息管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="23"><div align="center"><font color="#FFFFFF"><strong>信息管理</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=80 onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#8CBDEF';tododisplay('ecmssysmenu');" onclick="return false;" style="CURSOR: hand"> 
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/2/images/other<?=$menufiletype?>" width=32 border=0 title="功能菜单"></div></td>
                        </tr>
                        <tr> 
                          <td height="23"><div align="center"><font color="#FFFFFF"><strong>功能菜单</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width="351"><div align="right"><font color="#ffffff">用户：<a href="user/EditPassword.php<?=$ecms_hashur['whehref']?>" target="main"><font color="#ffffff"><b><?=$loginin?></b></font></a>&nbsp;&nbsp;&nbsp;[<a href="#ecms" onclick="if(confirm('确认要退出?')){JumpToMain('ecmsadmin.php?enews=exit<?=$ecms_hashur['href']?>');}"><font color="#ffffff">退出</font></a>]&nbsp;&nbsp;</font></div></TD>
                  </TR>
                </TBODY>
              </TABLE>
        
      </TD>
      </TR>
    </TBODY>
  </TABLE>

</td></tr>
<tr><td height="22">

  <TABLE width="100%" height="22" border=0 cellpadding="0" cellSpacing=0>
    <TBODY>
      <TR> 
        <TD class=flyoutMenu width="1%"> </TD>   
		    <TD width="99%" height="27"> 
              <TABLE class=flyoutMenu border=0 id="ecmsinfomenu">
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
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('main.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">后台首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('../../');" onmouseover="over(this)" onmouseout="out(this)">网站首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('map.php<?=$ecms_hashur['whehref']?>','','width=1250,height=760,scrollbars=auto,resizable=yes,top=80,left=120');" onmouseover="over(this)" onmouseout="out(this)">后台地图</TD>
                  </TR>
                </TBODY>
              </TABLE>
              <TABLE class=flyoutMenu border=0 id="ecmssysmenu" style="display:none">
                <TBODY>
                  <TR align=middle> 
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('user/EditPassword.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">修改资料</TD>
					<?php
					if($r[doclass])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListClass.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理栏目</TD>
					<?php
					}
					?>
					<?php
					if($r[dozt])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('special/ListZt.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理专题</TD>
					<?php
					}
					?>
					<?php
					if($r[docj])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListInfoClass.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理采集</TD>
					<?php
					}
					?>
					<?php
					if($r[dofile])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('file/ListFile.php?type=9<?=$ecms_hashur['ehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理附件</TD>
					<?php
					}
					?>
					<?php
					if($r[dosp])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('sp/ListSp.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理碎片</TD>
					<?php
					}
					?>
					<?php
					if($r[dotags])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tags/ListTags.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理TAGS</TD>
					<?php
					}
					?>
					<?php
					if($r[dogbook])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tool/gbook.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理留言</TD>
					<?php
					}
					?>
					<?php
					if($r[dofeedback])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tool/feedback.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">管理反馈</TD>
					<?php
					}
					?>
					<?php
					if($r[dodownerror])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('DownSys/ListError.php<?=$ecms_hashur['whehref']?>');" onmouseover="over(this)" onmouseout="out(this)">错误报告</TD>
					<?php
					}
					?>
                  </TR>
                </TBODY>
              </TABLE></TD>
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