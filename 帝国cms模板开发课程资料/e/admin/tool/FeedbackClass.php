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

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include("../../class/com_functions.php");
}
if($enews=="ReMoreFeedbackClassFile")
{
	ReMoreFeedbackClassFile(0,$logininid,$loginin);
}
//验证权限
CheckLevel($logininid,$loginin,$classid,"feedbackf");
include "../".LoadLang("pub/fun.php");
if($enews=="AddFeedbackClass")
{
	AddFeedbackClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditFeedbackClass")
{
	EditFeedbackClass($_POST,$logininid,$loginin);
}
elseif($enews=="DelFeedbackClass")
{
	DelFeedbackClass($_GET,$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=23;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select bid,bname from {$dbtbpre}enewsfeedbackclass";
$totalquery="select count(*) as total from {$dbtbpre}enewsfeedbackclass";
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by bid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置：<a href="feedback.php<?=$ecms_hashur['whehref']?>">管理信息反馈</a>&nbsp;&gt;&nbsp;<a href="FeedbackClass.php<?=$ecms_hashur['whehref']?>">管理反馈分类</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加反馈分类" onclick="self.location.href='AddFeedbackClass.php?enews=AddFeedbackClass<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
        <input type="button" name="Submit52" value="管理反馈字段" onclick="self.location.href='ListFeedbackF.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%"><div align="center">ID</div></td>
    <td width="32%" height="25"><div align="center">分类名称</div></td>
    <td width="42%"><div align="center">反馈提交地址</div></td>
    <td width="20%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$gourl=$public_r[newsurl].'e/tool/feedback/?bid='.$r[bid];
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <?=$r[bid]?>
        </div></td>
      <td height="25"> <div align="center"> 
          <a href="feedback.php?bid=<?=$r[bid]?><?=$ecms_hashur['ehref']?>" target="_blank" title="管理分类下的反馈信息"><?=$r[bname]?></a>
        </div></td>
      <td><div align="center"> 
          <input name="textfield" type="text" size="38" value="<?=$gourl?>">
          [<a href="<?=$gourl?>" target="_blank">访问</a>]</div></td>
      <td height="25"><div align="center">[<a href="AddFeedbackClass.php?enews=EditFeedbackClass&bid=<?=$r[bid]?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="AddFeedbackClass.php?enews=AddFeedbackClass&bid=<?=$r[bid]?>&docopy=1<?=$ecms_hashur['ehref']?>">复制</a>] [<a href="FeedbackClass.php?enews=DelFeedbackClass&bid=<?=$r[bid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除?');">删除</a>] </div></td>
    </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td height="25" colspan="3"><?=$returnpage?></td>
    </tr>
</table>
</body>
</html>
