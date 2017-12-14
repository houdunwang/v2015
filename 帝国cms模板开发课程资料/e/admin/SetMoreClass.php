<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"setmclass");
$r[newline]=10;
$r[hotline]=10;
$r[goodline]=10;
$r[hotplline]=10;
$r[firstline]=10;
$url="<a href=SetMoreClass.php".$ecms_hashur['whehref'].">批量设置栏目</a>";
//系统模型
$m_sql=$empire->query("select mid,mname,usemod from {$dbtbpre}enewsmod order by myorder,mid");
while($m_r=$empire->fetch($m_sql))
{
	if(empty($m_r[usemod]))
	{
		if($m_r[mid]==$r[modid])
		{$m_d=" selected";}
		else
		{$m_d="";}
		$mod_options.="<option value=".$m_r[mid].$m_d.">".$m_r[mname]."</option>";
	}
	//列表模板
	$listtemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$lt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewslisttemp")." where modid='$m_r[mid]'");
	while($lt_r=$empire->fetch($lt_sql))
	{
		if($lt_r[tempid]==$r[listtempid])
		{$lt_d=" selected";}
		else
		{$lt_d="";}
		$listtemp_options.="<option value=".$lt_r[tempid].$lt_d."> |-".$lt_r[tempname]."</option>";
	}
	//搜索模板
	$searchtemp.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$st_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewssearchtemp")." where modid='$m_r[mid]'");
	while($st_r=$empire->fetch($st_sql))
	{
		if($st_r[tempid]==$r[searchtempid])
		{$st_d=" selected";}
		else
		{$st_d="";}
		$searchtemp.="<option value=".$st_r[tempid].$st_d."> |-".$st_r[tempname]."</option>";
	}
	$newstemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$nt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewsnewstemp")." where modid='$m_r[mid]'");
	while($nt_r=$empire->fetch($nt_sql))
	{
		if($nt_r[tempid]==$r[newstempid])
		{$nt_d=" selected";}
		else
		{$nt_d="";}
		$newstemp_options.="<option value=".$nt_r[tempid].$nt_d."> |-".$nt_r[tempname]."</option>";
	}
}
//会员组
$qgroup='';
$qgbr='';
$qgi=0;
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	if($r[groupid]==$l_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$l_r[groupid].$select.">".$l_r[groupname]."</option>";
	//投稿
	$qgi++;
	if($qgi%6==0)
	{
		$qgbr='<br>';
	}
	else
	{
		$qgbr='';
	}
	$qgchecked='';
	if(strstr($r[qaddgroupid],','.$l_r[groupid].','))
	{
		$qgchecked=' checked';
	}
	$qgroup.="<input type=checkbox name=qaddgroupidck[] value='".$l_r[groupid]."'".$qgchecked.">".$l_r[groupname]."&nbsp;".$br;
}
//封面模板
$classtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsclasstemp")." order by tempid");
while($classtempr=$empire->fetch($classtempsql))
{
	$select="";
	if($r[classtempid]==$classtempr[tempid])
	{
		$select=" selected";
	}
	$classtemp.="<option value='".$classtempr[tempid]."'".$select.">".$classtempr[tempname]."</option>";
}
//js模板
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
//评论模板
$pltempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewspltemp")." order by tempid");
while($pltempr=$empire->fetch($pltempsql))
{
	$select="";
	if($r[pltempid]==$pltempr[tempid])
	{
		$select=" selected";
	}
	$pltemp.="<option value='".$pltempr[tempid]."'".$select.">".$pltempr[tempname]."</option>";
}
//WAP模板
$wapstyles='';
$wapstyle_sql=$empire->query("select styleid,stylename from {$dbtbpre}enewswapstyle order by styleid");
while($wapstyle_r=$empire->fetch($wapstyle_sql))
{
	$select="";
	if($r[wapstyleid]==$wapstyle_r[styleid])
	{
		$select=" selected";
	}
	$wapstyles.="<option value='".$wapstyle_r[styleid]."'".$select.">".$wapstyle_r[stylename]."</option>";
}
//预设投票
$infovotesql=$empire->query("select voteid,ysvotename from {$dbtbpre}enewsvotemod order by voteid desc");
while($infovoter=$empire->fetch($infovotesql))
{
	$select="";
	if($r[definfovoteid]==$infovoter[voteid])
	{
		$select=" selected";
	}
	$definfovote.="<option value='".$infovoter[voteid]."'".$select.">".$infovoter[ysvotename]."</option>";
}
//--------------------操作的栏目
$fcfile="../data/fc/ListEnews.php";
$do_class="<script src=../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$do_class=ShowClass_AddClass("","n",0,"|-",0,0);}
db_close();
$empire=null;
//当前使用的模板组
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量设置栏目</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ecmsclass.php" onsubmit="return confirm('确认要操作?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">批量设置栏目属性</div></td>
    </tr>
    <tr> 
      <td width="23%" height="25" valign="top" bgcolor="#FFFFFF">
<div align="center">
          <select name="classid[]" size="73" multiple id="classid[]" style="width:180">
            <?=$do_class?>
          </select>
          <br>
          选择多个栏目请用CTRL/SHIFT</div></td>
      <td width="77%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">修改</div></td>
            <td colspan="2">设置项目</td>
          </tr>
          <tr class="header"> 
            <td width="6%" height="25"> <div align="center"></div></td>
            <td colspan="2"><font class=tabcolor><strong>基本属性设置</strong></font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="doclasstype" type="checkbox" id="doclasstype" value="1">
              </div></td>
            <td width="23%" bgcolor="#FFFFFF">栏目文件扩展名</td>
            <td width="71%" bgcolor="#FFFFFF"> <input name="classtype" type="text" id="classtype" value=".html" size="10"> 
              <select name="select" onchange="document.form1.classtype.value=this.value">
                <option value=".html">扩展名</option>
                <option value=".html">.html</option>
                <option value=".htm">.htm</option>
                <option value=".php">.php</option>
                <option value=".shtml">.shtml</option>
              </select> </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dolisttempid" type="checkbox" id="dolisttempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">所属列表模板</td>
            <td bgcolor="#FFFFFF"><select name="listtempid" id="listtempid">
                <?=$listtemp_options?>
              </select> <input type="button" name="Submit6222" value="管理列表模板" onclick="window.open('template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dodtlisttempid" type="checkbox" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">动态列表模板</td>
            <td bgcolor="#FFFFFF"><select name="dtlisttempid">
                <?=$listtemp_options?>
              </select> <input type="button" name="Submit62226" value="管理列表模板" onclick="window.open('template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"> 
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="domaxnum" type="checkbox" id="dobmaxnum" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">显示总记录数</td>
            <td bgcolor="#FFFFFF"><input name="maxnum" type="text" id="maxnum" value="0" size="5">
              条<font color="#666666">(0为显示所有记录)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dolencord" type="checkbox" id="domaxnum" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">每页显示记录数</td>
            <td bgcolor="#FFFFFF"><input name="lencord" type="text" id="lencord" value="25" size="5">
              条</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="dosearchtempid" type="checkbox" id="dosearchtempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">搜索模板</td>
            <td bgcolor="#FFFFFF"> <select name="searchtempid" id="searchtempid">
                <option value="0">使用默认模板 </option>
                <?=$searchtemp?>
              </select> <input type="button" name="Submit62" value="管理搜索模板" onclick="window.open('template/ListSearchtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dowapstyleid" type="checkbox" id="dowapstyleid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">WAP模板</td>
            <td bgcolor="#FFFFFF"><select name="wapstyleid" id="wapstyleid">
                <option value="0">使用默认模板</option>
                <?=$wapstyles?>
              </select> <input type="button" name="Submit6232" value="管理WAP模板" onclick="window.open('other/WapStyle.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="dolistorder" type="checkbox" id="dosearchtempid3" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">管理信息排序方式</td>
            <td bgcolor="#FFFFFF">
<input name="listorder" type="text" id="listorder" value="id DESC" size="38">
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="doreorder" type="checkbox" id="doreorder" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">列表式页面排序方式</td>
            <td bgcolor="#FFFFFF">
<input name="reorder" type="text" id="reorder" value="newstime DESC" size="38">
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="dolistdt" type="checkbox" id="dolistdt" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">栏目页模式</td>
            <td bgcolor="#FFFFFF"> <input type="radio" name="listdt" value="0"<?=$r[listdt]==0?' checked':''?>>
              静态页面
<input type="radio" name="listdt" value="1"<?=$r[listdt]==1?' checked':''?>>
              动态页面</td>
          </tr>
          <tr> 
            <td height="24" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="doshowdt" type="checkbox" id="doshowdt" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">内容页模式</td>
            <td bgcolor="#FFFFFF"> <input type="radio" name="showdt" value="0"<?=$r[showdt]==0?' checked':''?>>
              静态页面 
              <input type="radio" name="showdt" value="1"<?=$r[showdt]==1?' checked':''?>>
              动态生成 
              <input type="radio" name="showdt" value="2"<?=$r[showdt]==2?' checked':''?>>
              动态页面</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="doshowclass" type="checkbox" id="doshowclass" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">是否显示到导航</td>
            <td bgcolor="#FFFFFF"> <input type="radio" name="showclass" value="0"<?=$r[showclass]==0?' checked':''?>>
              是 
              <input type="radio" name="showclass" value="1"<?=$r[showclass]==1?' checked':''?>>
              否<font color="#666666">&nbsp; </font><font color="#666666">(如：导航标签，地图标签)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doopenadd" type="checkbox" id="doopenadd" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">开放投稿功能</td>
            <td bgcolor="#FFFFFF"><input name="openadd" type="radio" value="0" checked<?=$openadd0?>>
              是 
              <input type="radio" name="openadd" value="1"<?=$openadd1?>>
              否</td>
          </tr>
          <tr class="header"> 
            <td height="25"> <div align="center"></div></td>
            <td colspan="2"><strong>选项设置[大栏目]</strong></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doclasstempid" type="checkbox" id="doclasstempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">封面模板</td>
            <td bgcolor="#FFFFFF"><select name="classtempid">
                <?=$classtemp?>
              </select> <input type="button" name="Submit62232" value="管理封面模板" onclick="window.open('template/ListClasstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"> 
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
                <input name="doislist" type="checkbox" id="doshowclass3" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">列表式</td>
            <td bgcolor="#FFFFFF"><input type="radio" name="islist" value="0"<?=$r[islist]==0?' checked':''?>>
              封面式 
              <input type="radio" name="islist" value="1"<?=$r[islist]==1?' checked':''?>>
              列表式 
              <input type="radio" name="islist" value="2"<?=$r[islist]==2?' checked':''?>>
              页面内容式</td>
          </tr>
          <tr class="header"> 
            <td height="25"> <div align="center"></div></td>
            <td colspan="2"><strong>选项设置[终极栏目]</strong></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="donewstempid" type="checkbox" id="donewstempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">所属内容模板</td>
            <td bgcolor="#FFFFFF"><select name="newstempid" id="newstempid">
                <?=$newstemp_options?>
              </select> <input type="button" name="Submit62222" value="管理内容模板" onclick="window.open('template/ListNewstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
              ( 
              <input name="tobetempinfo" type="checkbox" id="tobetempinfo" value="1">
              应用于已生成的信息)</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dopltempid" type="checkbox" id="dopltempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">所属评论模板</td>
            <td bgcolor="#FFFFFF"><select name="pltempid" id="pltempid">
                <option value="0">使用默认模板 </option>
                <?=$pltemp?>
              </select> <input type="button" name="Submit623" value="管理评论模板" onclick="window.open('template/ListPltemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dolink_num" type="checkbox" id="dolencord" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">相关链接显示记录数</td>
            <td bgcolor="#FFFFFF"><input name="link_num" type="text" id="link_num" value="10" size="5">
              条<font color="#666666">(0为不生成相关链接)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doinfopath" type="checkbox" id="doinfopath" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">内容页存放目录</td>
            <td bgcolor="#FFFFFF"><input type="radio" name="infopath" value="0"<?=$r[ipath]==''?' checked':''?>>
              栏目目录 
              <input type="radio" name="infopath" value="1"<?=$r[ipath]<>''?' checked':''?>>
              自定义： / 
              <input name="ipath" type="text" id="ipath" value="<?=$r[ipath]?>"> 
              <font color="#666666">(从根目录开始)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="donewspath" type="checkbox" id="dolink_num" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">信息页目录存放形式</td>
            <td bgcolor="#FFFFFF"><input name="newspath" type="text" id="newspath" value="<?=$r[newspath]?>" size="10"> 
              <select name="select2" onchange="document.form1.newspath.value=this.value">
                <option value="Y-m-d">选择</option>
                <option value="Y-m-d">2005-01-27</option>
                <option value="Y/m-d">2005/01-27</option>
                <option value="Y/m/d">2005/01/27</option>
                <option value="Ymd">20050127</option>
                <option value="">不设置目录</option>
              </select> <font color="#666666">(如Y-m-d,Y/m-d,Ymd等形式)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dofilename_qz" type="checkbox" id="donewspath" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">信息页文件名前缀</td>
            <td bgcolor="#FFFFFF"> <input name="filename_qz" type="text" id="filename_qz" value="<?=$r[filename_qz]?>" size="15"> 
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dofilename" type="checkbox" id="dofilename" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">信息页文件命名规则</td>
            <td bgcolor="#FFFFFF"><input name="filename" type="radio" value="0" checked>
              信息ID 
              <input type="radio" name="filename" value="1">
              time() 
              <input type="radio" name="filename" value="2">
              md5() 
              <input type="radio" name="filename" value="3">
              目录</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dofiletype" type="checkbox" id="dofiletype" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">信息页文件扩展名</td>
            <td bgcolor="#FFFFFF"><input name="filetype" type="text" id="filetype" value=".html" size="10"> 
              <select name="select3" onchange="document.form1.filetype.value=this.value">
                <option value=".html">扩展名</option>
                <option value=".html">.html</option>
                <option value=".htm">.htm</option>
                <option value=".php">.php</option>
                <option value=".shtml">.shtml</option>
              </select>
              (如.html,.xml,.htm等)</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doopenpl" type="checkbox" id="doopenpl" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">是否开放评论功能</td>
            <td bgcolor="#FFFFFF"><input name="openpl" type="radio" value="0" checked<?=$openpl0?>>
              是 
              <input type="radio" name="openpl" value="1"<?=$openpl1?>>
              否</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="docheckpl" type="checkbox" id="docheckpl" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">评论需要审核</td>
            <td bgcolor="#FFFFFF"><input name="checkpl" type="checkbox" id="checkpl2" value="1"<?=$checkpl?>>
              是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doqaddshowkey" type="checkbox" id="docheckpl3" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">投稿开启验证码</td>
            <td bgcolor="#FFFFFF"><input name="qaddshowkey" type="checkbox" id="qaddshowkey2" value="1"<?=$r['qaddshowkey']==1?' checked':''?>>
              是 </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="docheckqadd" type="checkbox" id="doqaddshowkey" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">投稿需要审核</td>
            <td bgcolor="#FFFFFF"><input name="checkqadd" type="checkbox" id="checkqadd2" value="1"<?=$r['checkqadd']==1?' checked':''?>>
              直接通过审核</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doqaddgroupid" type="checkbox" id="doqaddgroupid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">投稿权限</td>
            <td bgcolor="#FFFFFF"> 
              <?=$qgroup?>
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doqaddlist" type="checkbox" id="doqaddlist" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">投稿生成列表</td>
            <td bgcolor="#FFFFFF"><select name="qaddlist" id="qaddlist">
                <option value="0"<?=$r['qaddlist']==0?' selected':''?>>不生成</option>
                <option value="1"<?=$r['qaddlist']==1?' selected':''?>>生成当前栏目</option>
                <option value="2"<?=$r['qaddlist']==2?' selected':''?>>生成首页</option>
                <option value="3"<?=$r['qaddlist']==3?' selected':''?>>生成父栏目</option>
                <option value="4"<?=$r['qaddlist']==4?' selected':''?>>生成当前栏目与父栏目</option>
                <option value="5"<?=$r['qaddlist']==5?' selected':''?>>生成父栏目与首页</option>
                <option value="6"<?=$r['qaddlist']==6?' selected':''?>>生成当前栏目、父栏目与首页</option>
              </select></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doaddinfofen" type="checkbox" id="doaddinfofen" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">单篇投稿审核后获得</td>
            <td bgcolor="#FFFFFF"><input name="addinfofen" type="text" id="addinfofen" value="<?=$r[addinfofen]?>" size="6">
              点数 <font color="#666666">(不增加请设为0,扣点请设为负数)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doadminqinfo" type="checkbox" id="doadminqinfo" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">管理投稿</td>
            <td bgcolor="#FFFFFF"><strong> 
              <select name="adminqinfo" id="adminqinfo">
                <option value="0"<?=$r['adminqinfo']==0?' selected':''?>>不能管理信息</option>
                <option value="1"<?=$r['adminqinfo']==1?' selected':''?>>可管理未审核信息</option>
                <option value="2"<?=$r['adminqinfo']==2?' selected':''?>>只可编辑未审核信息</option>
                <option value="3"<?=$r['adminqinfo']==3?' selected':''?>>只可删除未审核信息</option>
                <option value="4"<?=$r['adminqinfo']==4?' selected':''?>>可管理所有信息</option>
                <option value="5"<?=$r['adminqinfo']==5?' selected':''?>>只可编辑所有信息</option>
                <option value="6"<?=$r['adminqinfo']==6?' selected':''?>>只可删除所有信息</option>
              </select>
              </strong></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doqeditchecked" type="checkbox" id="doqeditchecked" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">编辑投稿需要审核</td>
            <td bgcolor="#FFFFFF"><strong> 
              <input name="qeditchecked" type="checkbox" id="qeditchecked" value="1"<?=$r['qeditchecked']==1?' checked':''?>>
              </strong>是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doaddreinfo" type="checkbox" id="doaddreinfo" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">发布信息生成内容页</td>
            <td bgcolor="#FFFFFF"><input name="addreinfo" type="checkbox" id="addreinfo" value="1"<?=$r['addreinfo']==1?' checked':''?>>
              是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dohaddlist" type="checkbox" id="dohaddlist" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">发布信息生成列表</td>
            <td bgcolor="#FFFFFF"><select name="haddlist" id="haddlist">
                <option value="0"<?=$r['haddlist']==0?' selected':''?>>不生成</option>
                <option value="1"<?=$r['haddlist']==1?' selected':''?>>生成当前栏目</option>
                <option value="2"<?=$r['haddlist']==2?' selected':''?>>生成首页</option>
                <option value="3"<?=$r['haddlist']==3?' selected':''?>>生成父栏目</option>
                <option value="4"<?=$r['haddlist']==4?' selected':''?>>生成当前栏目与父栏目</option>
                <option value="5"<?=$r['haddlist']==5?' selected':''?>>生成父栏目与首页</option>
                <option value="6"<?=$r['haddlist']==6?' selected':''?>>生成当前栏目、父栏目与首页</option>
              </select></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dosametitle" type="checkbox" id="dosametitle" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">检测标题重复</td>
            <td bgcolor="#FFFFFF"><input name="sametitle" type="checkbox" id="sametitle" value="1"<?=$r['sametitle']==1?' checked':''?>>
              是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dochecked" type="checkbox" id="dochecked" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">发布信息是否直接审核</td>
            <td bgcolor="#FFFFFF"><input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
              是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dorepreinfo" type="checkbox" id="dorepreinfo" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">发布信息生成上一篇信息</td>
            <td bgcolor="#FFFFFF"><input name="repreinfo" type="checkbox" id="repreinfo" value="1"<?=$r[repreinfo]==1?' checked':''?>>
              是</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dodefinfovoteid" type="checkbox" id="dodefinfovoteid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">信息预设投票</td>
            <td bgcolor="#FFFFFF"><select name="definfovoteid" id="definfovoteid">
                <option value="0">不设置</option>
                <?=$definfovote?>
              </select> <input type="button" name="Submit622" value="管理预设投票" onclick="window.open('other/ListVoteMod.php<?=$ecms_hashur['whehref']?>');"> 
              <font color="#666666">&nbsp;</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dogroupid" type="checkbox" id="dogroupid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">默认查看信息权限</td>
            <td bgcolor="#FFFFFF"><select name="groupid" id="groupid">
                <option value="0">游客</option>
                <?=$group?>
              </select> <font color="#666666">(增加信息时默认的会员组权限)</font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dodoctime" type="checkbox" id="dodoctime" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">归档时间</td>
            <td bgcolor="#FFFFFF">归档大于 
              <input name="doctime" type="text" id="doctime" value="100" size="6">
              天的信息<font color="#666666">(0为不归档)</font></td>
          </tr>
          <tr class="header"> 
            <td height="25"> <div align="center"></div></td>
            <td colspan="2"><strong>特殊模型设置</strong></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dodown_num" type="checkbox" id="dodown_num" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">下载/影视模型</td>
            <td bgcolor="#FFFFFF">每行显示 
              <input name="down_num" type="text" id="link_num3" value="1" size="5">
              个下载地址</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="doonline_num" type="checkbox" id="do3" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">影视模型</td>
            <td bgcolor="#FFFFFF">每行显示 
              <input name="online_num" type="text" id="down_num" value="1" size="5">
              个在线观看地址</td>
          </tr>
          <tr class="header"> 
            <td height="25"> <div align="center"></div></td>
            <td colspan="2"><strong>JS调用设置</strong></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dojstempid" type="checkbox" id="doonline_num" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">所用JS模板</td>
            <td bgcolor="#FFFFFF"><select name="jstempid" id="jstempid">
                <?=$jstemp?>
              </select> <input type="button" name="Submit62223" value="管理JS模板" onclick="window.open('template/ListJstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="donewjs" type="checkbox" id="dojstempid" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">最新信息js设置</td>
            <td bgcolor="#FFFFFF">调用 
              <input name="newline" type="text" id="newline" value="<?=$r[newline]?>" size="6">
              条记录</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dohotjs" type="checkbox" id="do4" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">热门信息js设置</td>
            <td bgcolor="#FFFFFF">调用 
              <input name="hotline" type="text" id="hotline" value="<?=$r[hotline]?>" size="6">
              条记录</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dogoodjs" type="checkbox" id="do5" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">推荐信息js设置</td>
            <td bgcolor="#FFFFFF">调用 
              <input name="goodline" type="text" id="goodline" value="<?=$r[goodline]?>" size="6">
              条记录</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dohotpljs" type="checkbox" id="do6" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">热门评论信息js设置</td>
            <td bgcolor="#FFFFFF">调用 
              <input name="hotplline" type="text" id="hotplline" value="<?=$r[hotplline]?>" size="6">
              条记录</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF"><div align="center"> 
                <input name="dofirstjs" type="checkbox" id="do7" value="1">
              </div></td>
            <td bgcolor="#FFFFFF">头条信息js设置</td>
            <td bgcolor="#FFFFFF">调用 
              <input name="firstline" type="text" id="firstline" value="<?=$r[firstline]?>" size="6">
              条记录</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center"> </div></td>
            <td colspan="2"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"> 
              <input name="enews" type="hidden" id="enews" value="SetMoreClass"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
</body>
</html>
