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
CheckLevel($logininid,$loginin,$classid,"template");
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$tname=ehtmlspecialchars($_GET['tname']);
$r=$empire->fetch1("select * from ".GetDoTemptb('enewspubtemp',$gid)." limit 1");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公共模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
<script>
function ReTempBak(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="83%"><p>位置: 
        <?=$gname?>
        &nbsp;>&nbsp;<a href="EditPublicTemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>">公共模板管理</a></p></td>
    <td width="17%"> <div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="进入数据更新" onclick="window.open('../ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>');">
      </div></td>
  </tr>
</table>
<?
if($tname=="indextemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=indextemp>
	<form name="formindex" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">修改首页模板(<a href="../../../" target="_blank">预览</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><div align="center">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formindex.temptext.value);document.formindex.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formindex.temptext.value&returnvar=opener.document.formindex.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</div></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[indextemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="修改">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditPublicTemp">
          <input name="templatename" type="hidden" id="templatename" value="indextemp">
          <input type="reset" name="Submit2" value="重置">
          <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubindextemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
      <td bgcolor="#FFFFFF"><div align="right" class="emenubutton">
          <input type="button" name="Submit3" value="管理首页方案" onclick="window.open('ListIndexpage.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>');">
        </div></td>
    </tr>
	</form>
	<tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(indexshowtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">查看模板标签语法</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看标签模板</a>]</td>
    </tr>
    <tr id="indexshowtempvar" style="display:none"> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><strong>首页模板支持的变量说明</strong> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="50%" height="25"> <input name="textfield" type="text" value="[!--pagetitle--]">
              :网站名称</td>
            <td width="50%"> <input name="textfield2" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td width="50%"><input name="textfield923" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield72" type="text" value="[!--pagekey--]">
              :页面关键字</td>
            <td><input name="textfield73" type="text" value="[!--pagedes--]">
              :页面描述</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>支持公共模板变量</strong></td>
            <td><strong>支持所有模板标签</strong></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="cptemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=cptemp>
	<form name="formcp" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">控制面板模板 (<a href="../../member/cp" target="_blank">预览</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formcp.temptext.value);document.formcp.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formcp.temptext.value&returnvar=opener.document.formcp.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[cptemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditCptemp">
          <input name="templatename" type="hidden" id="templatename" value="cptemp">
          <input type="reset" name="Submit22" value="重置">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubcptemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(cpshowtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>]</td>
    </tr>
    <tr id="cpshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield30" type="text" value="[!--newsnav--]">
              :所在位置导航条</td>
            <td width="34%"><input name="textfield31" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td width="33%"><input name="textfield3" type="text" value="[!--pagetitle--]">
              ：页面标题</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield722" type="text" value="[!--pagekey--]">
              :页面关键字</td>
            <td><input name="textfield732" type="text" value="[!--pagedes--]">
              :页面描述</td>
            <td><input name="textfield922" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><strong>支持公共模板变量</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">说明: 在要显示内容的地方(如注册，登陆等)加上“[!--empirenews.template--]”</td>
    </tr>
  </table>
<br>
<?
}
if($tname=="schalltemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=schalltemp>
	<form name="formschall" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">全站搜索模板(<a href="../../sch/sch.html" target="_blank">测试模板</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formschall.temptext.value);document.formschall.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formschall.temptext.value&returnvar=opener.document.formschall.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[schalltemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">简介截取字数： 
          <input name="schallsubnum" type="text" id="schallsubnum" value="<?=$r[schallsubnum]?>">
          ，时间格式： 
          <input name="schalldate" type="text" id="schalldate" value="<?=$r[schalldate]?>">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditSchallTemp">
          <input name="tempname" type="hidden" id="tempname" value="schalltemp">
          <input type="reset" name="Submit22" value="重置">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubschalltemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(schallshowtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>]</td>
    </tr>
    <tr id="schallshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield3023" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td width="34%"><input name="textfield3123" type="text" value="[!--newsnav--]">
              :导航条</td>
            <td width="33%"><input name="textfield31222" type="text" value="[!--keyboard--]">
              :搜索关键字</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield302232" type="text" value="[!--num--]">
              :总记录数</td>
            <td><input name="textfield57" type="text" value="[!--listpage--]">
              :分页导航</td>
            <td><input name="textfield58" type="text" value="[!--no.num--]">
              :编号</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield55" type="text" value="[!--titleurl--]">
              :信息链接</td>
            <td><input name="textfield56" type="text" value="[!--id--]">
              :信息ID</td>
            <td><input name="textfield59" type="text" value="[!--classid--]">
              :栏目ID</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield60" type="text" value="[!--titlepic--]">
              :标题图片</td>
            <td><input name="textfield61" type="text" value="[!--newstime--]">
              :发布时间</td>
            <td><input name="textfield62" type="text" value="[!--title--]">
              :信息标题</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield63" type="text" value="[!--smalltext--]">
              :简介</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
            <td><strong>支持公共模板变量</strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p>模板格式:列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾<br>
        </p></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="searchformtemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchtemp>
	<form name="formsearchform" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">高级搜索表单模板 (<a href="../../../search/" target="_blank">预览</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formsearchform.temptext.value);document.formsearchform.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formsearchform.temptext.value&returnvar=opener.document.formsearchform.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchtemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchtemp">
          <input type="reset" name="Submit22" value="重置">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchtemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
	</form>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(searchformshowtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>]</td>
    </tr>
    <tr id="searchformshowtempvar" style="display:none"> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield302" type="text" value="[!--class--]">
              :搜索栏目列表</td>
            <td width="34%"><input name="textfield312" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td width="33%"><input name="textfield31232" type="text" value="[!--newsnav--]">
              :导航条</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield723" type="text" value="[!--pagekey--]">
              :页面关键字</td>
            <td><input name="textfield733" type="text" value="[!--pagedes--]">
              :页面描述</td>
            <td><input name="textfield924" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>支持公共模板变量</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="searchformjs"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchjstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">搜索JS模板[横向]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchjstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchjstemp">
          <input type="reset" name="Submit22" value="重置">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchjstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明:</strong> <br>
          站点地址: [!--news.url--]，搜索栏目列表: [!--class--] <br>
          <br>
          <strong>调用地址：</strong> 
          <input name="textfield1322" type="text" id="textfield1322" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."d/js/js/search_news1.js";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."d/js/js/search_news1.js";?><?=$ecms_hashur['ehref']?>" target="_blank">预览</a>] 
        </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="searchformjs1"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchjstemp1>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">搜索JS模板[纵向]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchjstemp1]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchjstemp1">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchjstemp1&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明:</strong> <br>
          站点地址: [!--news.url--]，搜索栏目列表: [!--class--] <br>
          <br>
          <strong>调用地址：</strong> 
          <input name="textfield13222" type="text" id="textfield13222" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."d/js/js/search_news2.js";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."d/js/js/search_news2.js";?><?=$ecms_hashur['ehref']?>" target="_blank">预览</a>] 
        </p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="otherlinktemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=otherlinktemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">相关信息链接模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[otherlinktemp]))?></textarea>
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center">标题截取字数：
          <input name="otherlinktempsub" type="text" id="otherlinktempsub" value="<?=$r[otherlinktempsub]?>">
          ，时间格式：
          <input name="otherlinktempdate" type="text" id="otherlinktempdate" value="<?=$r[otherlinktempdate]?>">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherLinkTemp">
          <input name="tempname" type="hidden" id="tempname" value="otherlinktemp">
          <input type="reset" name="Submit22" value="重置">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubotherlinktemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板格式:</strong>列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾<br>
          <strong>模板变量说明：</strong><br>
          标题: [!--title--]，标题alt：[!--oldtitle--], 标题链接: [!--titleurl--] <br>
          发布时间: [!--newstime--], 标题图片: [!--titlepic--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="gbooktemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=gbooktemp>
	<form name="formgbook" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">留言板模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formgbook.temptext.value);document.formgbook.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formgbook.temptext.value&returnvar=opener.document.formgbook.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r['gbooktemp']))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="修改">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditGbooktemp">
          <input name="templatename" type="hidden" id="templatename" value="gbooktemp">
          <input type="reset" name="Submit2" value="重置">
          <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubgbooktemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(gbookshowtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>]</td>
    </tr>
    <tr id="gbookshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><strong>1、整体页面支持的变量</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield32" type="text" value="[!--newsnav--]">
              :所在位置导航条</td>
            <td width="34%"><input name="textfield724" type="text" value="[!--pagekey--]">
              :页面关键字 </td>
            <td width="33%"><input name="textfield734" type="text" value="[!--pagedes--]">
              :页面描述 </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield33" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td><input name="textfield34" type="text" value="[!--bname--]">
              :留言分类名称</td>
            <td><input name="textfield925" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield35" type="text" value="[!--bid--]">
              :留言分类ID</td>
            <td><input name="textfield36" type="text" value="[!--listpage--]">
              :分页导航</td>
            <td><input name="textfield37" type="text" value="[!--num--]">
              :总记录数</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>支持公共模板变量</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <strong>2、列表内容支持的变量</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25">
<input name="textfield38" type="text" value="[!--lyid--]">
              :留言ID</td>
            <td width="34%"> 
              <input name="textfield39" type="text" value="[!--name--]">
              :留言者</td>
            <td width="33%">
<input name="textfield40" type="text" value="[!--email--]">
              :留言者邮箱</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield41" type="text" value="[!--mycall--]">
              :留言者电话</td>
            <td><input name="textfield42" type="text" value="[!--lytime--]">
              :留言时间</td>
            <td><input name="textfield43" type="text" value="[!--lytext--]">
              :留言内容</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield44" type="text" value="[!--retext--]">
              :回复内容</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>页面格式:</strong> 列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾<br>
          <strong>回复显示格式：</strong>[!--start.regbook--]回复显示格式内容[!--end.regbook--]</p></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="pljstemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=pljstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">修改评论JS调用模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[pljstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="pljstemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubpljstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板格式:列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾<br>
          模板变量说明：</strong><br>
          网站地址：[!--news.url--],栏目ID：[!--classid--],信息ID：[!--id--]<br>
          评论ID：[!--plid--],评论内容：[!--pltext--],评论发表时间：[!--pltime--],发表者IP：[!--plip--]<br>
          发表者ID：[!--userid--],发表者：[!--username--],支持数：[!--zcnum--],反对数：[!--fdnum--]<br>
          <br>
          <strong>信息评论调用地址：</strong>&lt;script src=&quot;[!--news.url--]e/pl/more/?classid=[!--classid--]&amp;id=[!--id--]&amp;num=10&quot;&gt;&lt;/script&gt;<br>
          <strong>专题评论调用地址：</strong>&lt;script src=&quot;[!--news.url--]e/pl/more/?doaction=dozt&amp;classid=[!--classid--]&amp;num=10&quot;&gt;&lt;/script&gt;<br>
        </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="downpagetemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=downpagetemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">修改最终下载页模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[downpagetemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="downpagetemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubdownpagetemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明：</strong><br>
          网站地址：[!--news.url--],页面标题：[!--pagetitle--],导航条：[!--newsnav--]<br>
          页面关键字：[!--pagekey--],页面描述：[!--pagedes--],一级栏目导航：[!--class.menu--],栏目ID：[!--classid--]<br>
          栏目名称：[!--class.name--],父栏目ID：[!--bclass.id--],父栏目名称：[!--bclass.name--],信息ID：[!--id--]<br>
          地址ID:[!--pathid--],地址名称:[!--down.name--],下载地址:[!--down.url--],文件真实地址：[!--true.down.url--]<br>
          扣除积分:[!--fen--],下载等级:[!--group--],信息地址：[!--titleurl--],信息标题：[!--title--]<br>
          发布时间：[!--newstime--],标题图片：[!--titlepic--],关键字：[!--keyboard--],点击数：[!--onclick--]<br>
          下载数：[!--totaldown--],发布用户ID：[!--userid--],发布用户名：[!--username--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="downsofttemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=downsofttemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">下载地址模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[downsofttemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="downsofttemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubdownsofttemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明：</strong><br>
          下载名称:[!--down.name--],弹出下载地址:[!--down.url--],文件真实地址：[!--true.down.url--]<br>
          下载地址号:[!--pathid--],栏目ID:[!--classid--],信息ID:[!--id--],扣除积分:[!--fen--],下载等级:[!--group--]<br>
          网站地址：[!--news.url--],信息标题：[!--title--] </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="onlinemovietemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=onlinemovietemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">在线播放地址模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[onlinemovietemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="onlinemovietemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubonlinemovietemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明：</strong><br>
          观看名称:[!--down.name--],弹出观看地址:[!--down.url--],文件真实地址：[!--true.down.url--]<br>
          观看地址号:[!--pathid--],栏目ID:[!--classid--],信息ID:[!--id--],扣除积分:[!--fen--],下载等级:[!--group--]<br>
          网站地址：[!--news.url--],信息标题：[!--title--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="listpagetemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=listpagetemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">列表分页模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[listpagetemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="listpagetemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publistpagetemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板变量说明：</strong><br>
          本页页码:[!--thispage--], 总页数:[!--pagenum--], 每页显示条数:[!--lencord--] <br>
          总条数:[!--num--], 分页链接:[!--pagelink--], 下拉分页:[!--options--] </p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="loginiframe"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=loginiframe>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">登陆状态模板 (<a href="../../member/iframe" target="_blank">预览</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="25" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[loginiframe]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditLoginIframe">
          <input name="tempname" type="hidden" id="tempname" value="loginiframe">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publoginiframe&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板格式：</strong>登陆前显示内容[!--empirenews.template--]登陆后显示内容<br>
          <strong>模板变量说明： </strong><br>
          用户ID:[!--userid--]，用户名:[!--username--]，网站地址：[!--news.url--]<br>
          会员等级:[!--groupname--]，现金:[!--money--]，帐户有效天数:[!--userdate--]<br>
          有新信息:[!--havemsg--]，积分:[!--userfen--]</p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="loginjstemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=loginjstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">JS调用登陆状态模板</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="25" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[loginjstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="修改">
          <input name="enews" type="hidden" id="enews" value="EditLoginJstemp">
          <input name="tempname" type="hidden" id="tempname" value="loginjstemp">
          <input type="reset" name="Submit22" value="重置">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publoginjstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>模板格式：</strong>登陆前显示内容[!--empirenews.template--]登陆后显示内容<br>
          <strong>模板变量说明：</strong> <br>
          用户ID:[!--userid--]，用户名:[!--username--]，网站地址：[!--news.url--]<br>
          会员等级:[!--groupname--]，现金:[!--money--]，帐户有效天数:[!--userdate--]<br>
          有新信息:[!--havemsg--]，积分:[!--userfen--]<br>
          <br>
          <strong>调用地址：</strong> 
          <input name="textfield132" type="text" id="textfield132" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."e/member/login/loginjs.php";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."e/member/login/loginjs.php";?><?=$ecms_hashur['ehref']?>" target="_blank">预览</a>] 
        </p>
        </td>
    </tr>
  </table>
</form>
<?
}
?>
</body>
</html>
