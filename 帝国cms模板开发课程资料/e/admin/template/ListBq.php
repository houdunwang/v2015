<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"bq");

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select bqid,bqname,bq,issys,funname,isclose,classid from {$dbtbpre}enewsbq";
$totalquery="select count(*) as total from {$dbtbpre}enewsbq";
//类别
$add="";
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid=$classid";
	$search.="&classid=$classid";
}
$query.=$add;
$totalquery.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by myorder desc,isclose,bqid limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//类别
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsbqclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$classid)
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理标签</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置：<a href="ListBq.php<?=$ecms_hashur['whehref']?>">管理标签</a></td>
    <td><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="增加标签" onclick="self.location.href='AddBq.php?enews=AddBq&gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit5" value="导入标签" onclick="self.location.href='LoadInBq.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit52" value="管理标签分类" onclick="self.location.href='BqClass.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td> 选择类别： 
      <select name="classid" id="classid" onchange=window.location='ListBq.php?<?=$ecms_hashur['ehref']?>&classid='+this.options[this.selectedIndex].value>
        <option value="0">显示所有类别</option>
        <?=$cstr?>
      </select> </td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"> <div align="center">ID</div></td>
    <td width="27%" height="25"> <div align="center">标签名称</div></td>
    <td width="26%" height="25"> <div align="center">标签符号</div></td>
    <td width="11%" height="25"> <div align="center">系统标签</div></td>
    <td width="8%"><div align="center">开启</div></td>
    <td width="23%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  if($r[issys])
  {$issys="是";}
  else
  {$issys="否";}
  //开启
  if($r[isclose])
  {
  $isclose="<font color=red>关闭</font>";
  }
  else
  {
  $isclose="开启";
  }
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center">
        <?=$r[bqid]?>
      </div></td>
    <td height="25"> <div align="center">
        <?=$r[bqname]?>
      </div></td>
    <td height="25"> <div align="center">
        <?=$r[bq]?>
      </div></td>
    <td height="25"> <div align="center">
        <?=$issys?>
      </div></td>
    <td><div align="center"><?=$isclose?></div></td>
    <td height="25"> <div align="center">[<a href="AddBq.php?enews=EditBq&bqid=<?=$r[bqid]?>&cid=<?=$classid?><?=$ecms_hashur['ehref']?>">修改</a>]&nbsp;[<a href="../ecmstemp.php?enews=DelBq&bqid=<?=$r[bqid]?>&cid=<?=$classid?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>]&nbsp;[<a href="#ecms" onclick="window.open('LoadOutBq.php?bqid=<?=$r[bqid]?><?=$ecms_hashur['ehref']?>','','width=500,height=500,scrollbars=auto');">导出</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
