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
$urlgname=$gname."&nbsp;>&nbsp;";
$enews=ehtmlspecialchars($_GET['enews']);
$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">管理投票模板</a>&nbsp;>&nbsp;增加投票模板";
//复制
if($enews=="AddVoteTemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewsvotetemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">管理投票模板</a>&nbsp;>&nbsp;复制投票模板：<b>".$r[tempname]."</b>";
}
//修改
if($enews=="EditVoteTemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewsvotetemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">管理投票模板</a>&nbsp;>&nbsp;修改投票模板：<b>".$r[tempname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加投票模板</title>
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
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListVotetemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加投票模板 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">模板名称</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>模板内容</strong>(*)</td>
      <td height="25">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml&notfullpage=1<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="23" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置">
        <?php
		if($enews=='EditVoteTemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=votetemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">显示模板变量说明</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><strong>(1)、投票插件使用时支持的模板变量列表 </strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF">
            <td height="25"><div align="center">[!--news.url--]</div></td>
            <td>网站地址</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="36%" height="25"> <div align="center">[!--vote.action--]</div></td>
            <td width="64%">投票表单提交地址</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--title--]</div></td>
            <td>显示投票的标题</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.view--]</div></td>
            <td>查看投票结果地址</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--width--](宽度)、[!--height--](高度)</div></td>
            <td>弹出投票结果窗口大小</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--voteid--]</div></td>
            <td>此投票的ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.box--]</div></td>
            <td>投票选项（单选框 
              <input type="radio" name="radiobutton" value="radiobutton">
              与复选框 
              <input type="checkbox" name="checkbox" value="checkbox">
              ）</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.name--]</div></td>
            <td>投票选项名称</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">投票事件变量</div></td>
            <td>&lt;input type=&quot;hidden&quot; name=&quot;<strong>enews</strong>&quot; 
              value=&quot;<strong>AddVote</strong>&quot;&gt;</td>
          </tr>
        </table>
        <br> <strong>(2)、信息投票使用时支持的模板变量列表 </strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF">
            <td height="25"><div align="center">[!--news.url--]</div></td>
            <td>网站地址</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="36%" height="25"> <div align="center">投票表单提交地址</div></td>
            <td width="64%">/e/enews/index.php</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">查看投票结果地址</div></td>
            <td>/e/public/vote/?classid=[!--classid--]&amp;id=[!--id--]</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--title--]</div></td>
            <td>显示投票的标题</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--width--](宽度)、[!--height--](高度)</div></td>
            <td>弹出投票结果窗口大小</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--id--]</div></td>
            <td>信息ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">[!--classid--]</div></td>
            <td>栏目ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.box--]</div></td>
            <td>投票选项（单选框 
              <input type="radio" name="radiobutton" value="radiobutton">
              与复选框 
              <input type="checkbox" name="checkbox2" value="checkbox">
              ）</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.name--]</div></td>
            <td>投票选项名称</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">投票事件变量</div></td>
            <td>&lt;input type=&quot;hidden&quot; name=&quot;<strong>enews</strong>&quot; 
              value=&quot;<strong>AddInfoVote</strong>&quot;&gt;</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">模板格式:</td>
      <td height="25">列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾</td>
    </tr>
  </table>
</body>
</html>
