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
CheckLevel($logininid,$loginin,$classid,"userlist");
$enews=ehtmlspecialchars($_GET['enews']);
$cid=(int)$_GET['cid'];
$url="<a href=ListUserlist.php".$ecms_hashur['whehref'].">管理自定义信息列表</a> &gt; 增加自定义信息列表";
$r[jsfilename]="../../list/";
$r[filetype]=".html";
$r[filepath]="../../a/";
$r[totalsql]="select count(*) as total from [!db.pre!]ecms_news";
$r[listsql]="select * from [!db.pre!]ecms_news order by id desc";
$r[maxnum]=0;
$r[lencord]=25;
//复制
if($enews=="AddUserlist"&&$_GET['docopy'])
{
	$listid=(int)$_GET['listid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsuserlist where listid='$listid'");
	$url="<a href=ListUserlist.php".$ecms_hashur['whehref'].">管理自定义信息列表</a> &gt; 复制自定义信息列表：<b>".$r[listname]."</b>";
}
//修改
if($enews=="EditUserlist")
{
	$listid=(int)$_GET['listid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsuserlist where listid='$listid'");
	$url="<a href=ListUserlist.php".$ecms_hashur['whehref'].">管理自定义信息列表</a> -&gt; 修改自定义信息列表：<b>".$r[listname]."</b>";
}
//列表模板
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	$listtemp_options.="<option value=0 style='background:#99C4E3'>".$mr[mname]."</option>";
	$l_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewslisttemp")." where modid='$mr[mid]'");
	while($l_r=$empire->fetch($l_sql))
	{
		if($l_r[tempid]==$r[listtempid])
		{$l_d=" selected";}
		else
		{$l_d="";}
		$listtemp_options.="<option value=".$l_r[tempid].$l_d."> |-".$l_r[tempname]."</option>";
	}
}
//当前使用的模板组
$thegid=GetDoTempGid();
//分类
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsuserlistclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>自定义信息列表</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListUserlist.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加自定义信息列表 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="listid" type="hidden" id="listid" value="<?=$listid?>"> 
        <input name="oldfilepath" type="hidden" id="oldfilepath" value="<?=$r[filepath]?>"> 
        <input name="oldfiletype" type="hidden" id="oldfiletype" value="<?=$r[filetype]?>">
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">列表名称:</td>
      <td width="82%" height="25"> <input name="listname" type="text" id="listname" value="<?=$r[listname]?>" size="42">      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">所属分类:</td>
      <td height="25"><select name="classid" id="classid">
        <option value="0">不隶属于任何类别</option>
        <?=$cstr?>
      </select>
        <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('UserlistClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">网页标题:</td>
      <td height="25"><input name="pagetitle" type="text" id="pagetitle" value="<?=$r[pagetitle]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">网页关键词:</td>
      <td height="25"><input name="pagekeywords" type="text" id="pagekeywords" value="<?=$r[pagekeywords]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">网页描述:</td>
      <td height="25"><input name="pagedescription" type="text" id="pagedescription" value="<?=$r[pagedescription]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">文件存放目录:</td>
      <td height="25"><input name="filepath" type="text" id="filepath" value="<?=$r[filepath]?>" size="42"> 
        <input type="button" name="Submit4" value="选择目录" onclick="window.open('../file/ChangePath.php?<?=$ecms_hashur['ehref']?>&returnform=opener.document.form1.filepath.value','','width=400,height=500,scrollbars=yes');"> 
        <font color="#666666">(如:<strong>&quot;../../a/</strong>&quot;表示根目录下的a目录)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">文件扩展名：</td>
      <td height="25"><input name="filetype" type="text" id="filetype" value="<?=$r[filetype]?>" size="12"> 
        <select name="select" onchange="document.form1.filetype.value=this.value">
          <option value=".html">扩展名</option>
          <option value=".html">.html</option>
          <option value=".htm">.htm</option>
          <option value=".php">.php</option>
          <option value=".shtml">.shtml</option>
        </select>
        (如.html,.xml,.htm等) </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="4">查询SQL语句:</td>
      <td height="25">统计记录: 
        <input name="totalsql" type="text" id="totalsql" value="<?=ehtmlspecialchars(stripSlashes($r[totalsql]))?>" size="72"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">(如：select count(*) as total from phome_ecms_news 
        where classid=1)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">查询记录: 
        <input name="listsql" type="text" id="listsql" value="<?=ehtmlspecialchars(stripSlashes($r[listsql]))?>" size="72"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">(如：select * from phome_ecms_news where 
        classid=1 order by id desc)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="26">查询总条数：</td>
      <td height="26"><input name="maxnum" type="text" id="lencord" value="<?=$r[maxnum]?>" size="6">
        条信息(0为不限制)</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="26">每页显示：</td>
      <td height="26"> <input name="lencord" type="text" id="jsname3" value="<?=$r[lencord]?>" size="6">
        条信息</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">使用列表模板:</td>
      <td height="25"><select name="listtempid" id="listtempid">
          <?=$listtemp_options?>
        </select> <input type="button" name="Submit622" value="管理列表模板" onclick="window.open('../template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">表前缀可用“<strong>[!db.pre!]</strong>”表示</td>
    </tr>
  </table>
</form>
</body>
</html>
