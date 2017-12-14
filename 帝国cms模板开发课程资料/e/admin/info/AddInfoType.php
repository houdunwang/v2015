<?php
define('EmpireCMSAdmin','1');
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
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
CheckLevel($logininid,$loginin,$classid,"infotype");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href='InfoType.php".$ecms_hashur['whehref']."'>管理标题分类</a>&nbsp;>&nbsp;增加标题分类";
$postword='增加标题分类';
//初使化数据
$r[myorder]=0;
$r[reorder]="newstime DESC";
$r[maxnum]=0;
$r[tnum]=25;
$r[repagenum]=0;
$r[ttype]=".html";
$r[newline]=10;
$r[hotline]=10;
$r[goodline]=10;
$r[hotplline]=10;
$r[firstline]=10;
$pripath='t/';
//复制
$docopy=RepPostStr($_GET['docopy'],1);
if($docopy&&$enews=="AddInfoType")
{
	$copyclass=1;
}
$ecmsfirstpost=1;
//修改
if($enews=="EditInfoType"||$copyclass)
{
	$ecmsfirstpost=0;
	if($copyclass)
	{
		$thisdo="复制";
	}
	else
	{
		$thisdo="修改";
	}
	$typeid=(int)$_GET['typeid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfotype where typeid='$typeid'");
	$url="<a href='InfoType.php".$ecms_hashur['whehref']."'>管理标题分类</a>&nbsp;>&nbsp;".$thisdo."标题分类：".$r[tname];
	$postword=$thisdo.'标题分类';
	//分类目录
	$mycr=GetPathname($r[tpath]);
	$pripath=$mycr[1];
	$tpath=$mycr[0];
	//复制分类
	if($copyclass)
	{
		$r[tname].='(1)';
		$tpath.='1';
	}
}
//列表模板
$mod_options='';
$listtemp_options='';
$msql=$empire->query("select mid,mname,usemod from {$dbtbpre}enewsmod order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	if(empty($mr[usemod]))
	{
		if($mr[mid]==$r[mid])
		{$m_d=" selected";}
		else
		{$m_d="";}
		$mod_options.="<option value=".$mr[mid].$m_d.">".$mr[mname]."</option>";
	}
	//列表模板
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
//js模板
$jstemp='';
$jstempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsjstemp")." order by tempid");
while($jstempr=$empire->fetch($jstempsql))
{
	$select="";
	if($r[jstempid]==$jstempr[tempid])
	{
		$select=" selected";
	}
	$jstemp.="<option value='".$jstempr[tempid]."'".$select.">".$jstempr[tempname]."</option>";
}
//优化方案
$yh_options='';
$yhsql=$empire->query("select id,yhname from {$dbtbpre}enewsyh order by id");
while($yhr=$empire->fetch($yhsql))
{
	$select='';
	if($r[yhid]==$yhr[id])
	{
		$select=' selected';
	}
	$yh_options.="<option value='".$yhr[id]."'".$select.">".$yhr[yhname]."</option>";
}
//当前使用的模板组
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加标题分类</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
//检查
function CheckForm(obj){
	if(obj.tname.value=='')
	{
		alert("请输入分类名称");
		obj.tname.focus();
		return false;
	}
	if(obj.tpath.value=="")
	{
		alert("请输入分类目录");
		obj.tpath.focus();
		return false;
	}
	if(obj.listtempid.value==0)
	{
		alert("请选择列表模板");
		obj.listtempid.focus();
		return false;
	}
}
  </script>

</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置： 
      <?=$url?>
    </td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="InfoType.php" onsubmit="return CheckForm(document.form1);">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input type=hidden name=enews value=<?=$enews?>> </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">基本属性</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">分类名称(*)</td>
      <td width="76%" height="25" bgcolor="#FFFFFF"> <input name="tname" type="text" id="tname" value="<?=$r[tname]?>" size="38"> 
        <?
	  if($enews=="AddInfoType"||$docopy)
	  {
	  ?>
        <input type="button" name="Submit5" value="生成拼音目录" onclick="window.open('../GetPinyin.php?<?=$ecms_hashur['href']?>&hz='+document.form1.tname.value+'&returnform=opener.document.form1.tpath.value','','width=160,height=100');"> 
        <?
	  }
	  ?>
        <input name="typeid" type="hidden" id="typeid" value="<?=$typeid?>"> </td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">存放文件夹(*) 
        <input name="oldtpath" type="hidden" id="oldtpath" value="<?=$r[tpath]?>"> 
        <input name="oldpripath" type="hidden" id="oldpripath" value="<?=$pripath?>"> 
      </td>
      <td bgcolor="#FFFFFF"> <table border="0" cellspacing="1" cellpadding="3">
          <tr bgcolor="DBEAF5"> 
            <td bgcolor="DBEAF5">&nbsp;</td>
            <td bgcolor="DBEAF5">上层目录</td>
            <td bgcolor="DBEAF5">本分类目录</td>
            <td bgcolor="DBEAF5">&nbsp;</td>
          </tr>
          <tr> 
            <td><div align="right">根目录/</div></td>
            <td><input name="pripath" type="text" id="pripath" value="<?=$pripath?>" size="30"></td>
            <td><input name="tpath" type="text" id="tpath" value="<?=$tpath?>" size="16"></td>
            <td><input type="button" name="Submit3" value="检测目录" onclick="javascript:window.open('../ecmscom.php?<?=$ecms_hashur['href']?>&enews=CheckPath&pripath='+document.form1.pripath.value+'&classpath='+document.form1.tpath.value,'','width=100,height=100,top=250,left=450');"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">绑定的系统模型</td>
      <td bgcolor="#FFFFFF"><select name="mid" id="mid">
          <?=$mod_options?>
        </select> <input type="button" name="Submit6" value="管理系统模型" onclick="window.open('../db/ListTable.php<?=$ecms_hashur['whehref']?>');">
        * 
        <input name="oldmodid" type="hidden" id="oldmodid" value="<?=$r[modid]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">使用优化方案</td>
      <td bgcolor="#FFFFFF"><select name="yhid" id="yhid">
          <option name="0">不使用</option>
          <?=$yh_options?>
        </select> <input type="button" name="Submit63" value="管理优化方案" onclick="window.open('../db/ListYh.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">分类缩略图</td>
      <td bgcolor="#FFFFFF"> <input name="timg" type="text" id="timg" value="<?=$r[timg]?>" size="38"> 
        <a onclick="window.open('../ecmseditor/FileMain.php?modtype=5&type=1&classid=&doing=2&field=timg<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" width="22" height="22" border="0" align="absbottom"></a></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">网页关键字</td>
      <td bgcolor="#FFFFFF"> <input name="pagekey" type="text" id="pagekey" value="<?=$r[pagekey]?>" size="38"></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">分类简介</td>
      <td bgcolor="#FFFFFF"> <textarea name="intro" cols="70" rows="8" id="intro"><?=ehtmlspecialchars(stripSlashes($r[intro]))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">排序</td>
      <td bgcolor="#FFFFFF"><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="38"> 
        <font color="#666666"> (值越小越前面)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">页面设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">页面模式</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="listdt" value="0"<?=$r[listdt]==0?' checked':''?>>
        静态页面 
        <input type="radio" name="listdt" value="1"<?=$r[listdt]==1?' checked':''?>>
        动态页面</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">所用列表模板(*)</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="listtempid" id="listtempid">
          <?=$listtemp_options?>
        </select> <input type="button" name="Submit622" value="管理列表模板" onclick="window.open('../template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
        *</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">列表式页面排序方式</td>
      <td height="25" bgcolor="#FFFFFF"><input name="reorder" type="text" id="reorder" value="<?=$r[reorder]?>" size="38"> 
        <select name="orderselect" onchange="document.form1.reorder.value=this.value">
          <option value="newstime DESC"></option>
          <option value="newstime DESC">按发布时间降序排序</option>
          <option value="id DESC">按ID降序排序</option>
          <option value="onclick DESC">按点击率降序排序</option>
          <option value="totaldown DESC">按下载数降序排序</option>
          <option value="plnum DESC">按评论数降序排序</option>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">文件扩展名</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ttype" type="text" id="ttype" value="<?=$r[ttype]?>" size="38"> 
        <select name="select" onchange="document.form1.ttype.value=this.value">
          <option value=".html">扩展名</option>
          <option value=".html">.html</option>
          <option value=".htm">.htm</option>
          <option value=".php">.php</option>
          <option value=".shtml">.shtml</option>
        </select> <font color="#666666">(如.html,.xml,.htm等)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">显示总记录数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="maxnum" type="text" id="maxnum" value="<?=$r[maxnum]?>" size="38">
        条 <font color="#666666">(0为显示所有记录)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">生成静态页数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="repagenum" type="text" id="repagenum" value="<?=$r[repagenum]?>" size="38">
        页<font color="#666666">(超过分页采用动态链接，0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">每页显示记录数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="tnum" type="text" id="tnum" value="<?=$r[tnum]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">JS相关设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否生成JS调用</td>
      <td bgcolor="#FFFFFF"> <input type="radio" name="nrejs" value="0"<?=$r[nrejs]==0?' checked':''?>>
        生成 
        <input type="radio" name="nrejs" value="1"<?=$r[nrejs]==1?' checked':''?>>
        不生成</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">所用JS模板</td>
      <td bgcolor="#FFFFFF"> <select name="jstempid" id="jstempid">
          <?=$jstemp?>
        </select> <input type="button" name="Submit62223" value="管理JS模板" onclick="window.open('../template/ListJstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">最新信息JS显示</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="newline" type="text" id="newline" value="<?=$r[newline]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">热门信息JS显示</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="hotline" type="text" id="hotline" value="<?=$r[hotline]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">推荐信息JS显示</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="goodline" type="text" id="goodline" value="<?=$r[goodline]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">热门评论信息js显示</td>
      <td bgcolor="#FFFFFF"> <input name="hotplline" type="text" id="hotplline" value="<?=$r[hotplline]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">头条信息js显示</td>
      <td bgcolor="#FFFFFF"> <input name="firstline" type="text" id="firstline" value="<?=$r[firstline]?>" size="38">
        条记录</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"></div></td>
      <td bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> &nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="重置"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>