<?php
define('EmpireCMSAdmin','1');
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
require '../'.LoadLang('pub/fun.php');
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
//CheckLevel($logininid,$loginin,$classid,"zt");

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
$url="<a href=UpdateZt.php".$ecms_hashur['whehref'].">更新专题</a>";
$time=time();
//类别
$zcid=(int)$_GET['zcid'];
if($zcid)
{
	$add=" and zcid=$zcid";
	$search.="&zcid=$zcid";
}
//分类
$zcstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsztclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$zcid)
	{
		$select=" selected";
	}
	$zcstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
$totalquery="select count(*) as total from {$dbtbpre}enewszt where usernames like '%$loginin%' and (endtime=0 or endtime>$time)".$add;
$query="select * from {$dbtbpre}enewszt where usernames like '%$loginin%' and (endtime=0 or endtime>$time)".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by myorder,ztid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>更新专题</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"></div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form1" method="get" action="UpdateZt.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="30">限制显示： 
        <select name="zcid" id="zcid" onchange="document.form1.submit()">
          <option value="0">显示所有分类</option>
          <?=$zcstr?>
        </select>
      </td>
    </tr>
  </form>
</table>
<br>
<table width="600" border="0" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="13%" height="25"><div align="center">ID</div></td>
      <td width="58%" height="25"><div align="center">专题名</div></td>
      <td width="29%" height="25"><div align="center">操作</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  if($r[zturl])
  {
  	$ztlink=$r[zturl];
  }
  else
  {
  	$ztlink="../../../".$r[ztpath];
  }
  ?>
    <tr bgcolor="ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"><div align="center"> 
          <a href="../ecmschtml.php?enews=ReZtHtml&ztid=<?=$r[ztid]?><?=$ecms_hashur['href']?>"><?=$r[ztid]?></a>
        </div></td>
      <td height="25"><div align="center"> 
          <a href="<?=$ztlink?>" target="_blank"><?=$r[ztname]?></a>
        </div></td>
      <td height="25"><div align="center"><a href="#ecms" onclick="window.open('../openpage/AdminPage.php?leftfile=<?=urlencode('../special/pageleft.php?ztid='.$r[ztid].$ecms_hashur['ehref'])?>&title=<?=urlencode($r[ztname])?><?=$ecms_hashur['ehref']?>','','');">更新专题</a> <a href="../ecmschtml.php?enews=ReZtHtml&ztid=<?=$r[ztid]?>&ecms=1<?=$ecms_hashur['href']?>">刷新</a></div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="ffffff">
      <td height="25" colspan="3">&nbsp;&nbsp; 
        <?=$returnpage?></td>
    </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
