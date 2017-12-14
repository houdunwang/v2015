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
CheckLevel($logininid,$loginin,$classid,"zt");

//修改栏目顺序
function EditZtOrder($ztid,$myorder,$userid,$username){
	global $empire,$dbtbpre;
	for($i=0;$i<count($ztid);$i++)
	{
		$newmyorder=(int)$myorder[$i];
		$ztid[$i]=(int)$ztid[$i];
		$sql=$empire->query("update {$dbtbpre}enewszt set myorder='$newmyorder' where ztid='$ztid[$i]'");
    }
	//操作日志
	insert_dolog("");
	printerror("EditZtOrderSuccess",$_SERVER['HTTP_REFERER']);
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//修改显示顺序
if($enews=="EditZtOrder")
{
	EditZtOrder($_POST['ztid'],$_POST['myorder'],$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
$url="<a href=ListZt.php".$ecms_hashur['whehref'].">管理专题</a>";
//类别
$zcid=(int)$_GET['zcid'];
if($zcid)
{
	$add=" where zcid=$zcid";
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
$totalquery="select count(*) as total from {$dbtbpre}enewszt".$add;
$query="select * from {$dbtbpre}enewszt".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by myorder,ztid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>专题</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit52" value="增加专题" onclick="self.location.href='AddZt.php?enews=AddZt<?=$ecms_hashur['ehref']?>';"> 
		&nbsp;&nbsp;
        <input type="button" name="Submit6" value="数据更新中心" onclick="window.open('../ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>');">
      </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form1" method="get" action="ListZt.php">
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
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="editorder" method="post" action="ListZt.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="5%"><div align="center">顺序</div></td>
      <td width="6%" height="25"><div align="center">ID</div></td>
      <td width="34%" height="25"><div align="center">专题名</div></td>
      <td width="20%"><div align="center">增加时间</div></td>
      <td width="11%"><div align="center">访问量</div></td>
      <td width="13%">专题管理</td>
      <td width="11%" height="25"><div align="center">操作</div></td>
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
      <td><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="2">
          <input name="ztid[]" type="hidden" id="ztid[]" value="<?=$r[ztid]?>">
        </div></td>
      <td height="25"><div align="center"> 
          <a href="../ecmschtml.php?enews=ReZtHtml&ztid=<?=$r[ztid]?><?=$ecms_hashur['href']?>"><?=$r[ztid]?></a>
        </div></td>
      <td height="25"><div align="center"> 
          <a href="<?=$ztlink?>" target="_blank"><?=$r[ztname]?></a>
        </div></td>
      <td><div align="center"><?=$r['addtime']?date("Y-m-d",$r['addtime']):'---'?></div></td>
      <td><div align="center"> 
          <?=$r[onclick]?>
        </div></td>
      <td><a href="AddZt.php?enews=EditZt&ztid=<?=$r[ztid]?><?=$ecms_hashur['ehref']?>">修改</a> <a href="../ecmschtml.php?enews=ReZtHtml&ztid=<?=$r[ztid]?>&ecms=1<?=$ecms_hashur['href']?>">刷新</a> <a href="AddZt.php?enews=AddZt&ztid=<?=$r[ztid]?>&docopy=1<?=$ecms_hashur['ehref']?>">复制</a> <a href="../ecmsclass.php?enews=DelZt&ztid=<?=$r[ztid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除此专题？');">删除</a></td>
      <td height="25"><div align="center"><a href="#ecms" onclick="window.open('../openpage/AdminPage.php?leftfile=<?=urlencode('../special/pageleft.php?ztid='.$r[ztid].$ecms_hashur['ehref'])?>&title=<?=urlencode($r[ztname])?><?=$ecms_hashur['ehref']?>','','');">更新专题</a></div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="ffffff"> 
      <td height="25" colspan="7"><div align="right">
        <input type="submit" name="Submit5" value="修改专题顺序" onClick="document.editorder.enews.value='EditZtOrder';"> 
        <input name="enews" type="hidden" id="enews" value="EditZtOrder"> 
      <font color="#666666">(顺序值越小越前面)</font></div></td>
    </tr>
    <tr bgcolor="ffffff">
      <td height="25" colspan="7">&nbsp;&nbsp; 
        <?=$returnpage?></td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
