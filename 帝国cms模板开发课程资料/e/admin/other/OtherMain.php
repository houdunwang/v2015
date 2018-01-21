<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
//CheckLevel($logininid,$loginin,$classid,"pl");

$todaydate=date('Y-m-d');
$yesterday=date('Y-m-d',time()-24*3600);
//会员
$membertb=eReturnMemberTable();
$checkmembernum=$empire->gettotal("select count(*) as total from ".$membertb." where ".egetmf('checked')."=0");
$allmembernum=eGetTableRowNum($membertb);
//管理员
$adminnum=eGetTableRowNum($dbtbpre.'enewsuser');
//订单
$showshopmenu=stristr($public_r['closehmenu'],',shop,')?0:1;
if($showshopmenu)
{
	$allddnum=eGetTableRowNum($dbtbpre.'enewsshopdd');
	$todayddnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshopdd where ddtime>='".$todaydate." 00:00:00' and ddtime<='".$todaydate." 23:59:59' limit 1");
	$yesterdayddnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshopdd where ddtime>='".$yesterday." 00:00:00' and ddtime<='".$yesterday." 23:59:59' limit 1");
}
//留言
$allgbooknum=eGetTableRowNum($dbtbpre.'enewsgbook');
$checkgbooknum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsgbook where checked=1");
//反馈
$allfeedbacknum=eGetTableRowNum($dbtbpre.'enewsfeedback');
$noreadfeedbacknum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsfeedback where haveread=0");
//广告
$alladnum=eGetTableRowNum($dbtbpre.'enewsad');
$outtimeadnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsad where endtime<'$todaydate' and endtime<>'0000-00-00'");
//错误报告
$errornum=eGetTableRowNum($dbtbpre.'enewsdownerror');
//友情链接
$sitelinknum=eGetTableRowNum($dbtbpre.'enewslink');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>统计</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function OpenShopSysDdPage(){
	window.open('../openpage/AdminPage.php?leftfile=<?=urlencode('../ShopSys/pageleft.php'.$ecms_hashur['whehref'])?>&mainfile=<?=urlencode('../ShopSys/ListDd.php'.$ecms_hashur['whehref'])?>&title=<?=urlencode('商城系统管理')?><?=$ecms_hashur['ehref']?>','AdminShopSys','');
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="OtherMain.php<?=$ecms_hashur['whehref']?>">其他统计</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td width="10%" height="25" bgcolor="#C9F1FF"><div align="center"><a href="../info/InfoMain.php<?=$ecms_hashur['whehref']?>">信息统计</a></div></td>
      <td width="10%" bgcolor="#C9F1FF"><div align="center"><a href="../pl/PlMain.php<?=$ecms_hashur['whehref']?>">评论统计</a></div></td>
      <td width="10%" class="header"><div align="center"><a href="../other/OtherMain.php<?=$ecms_hashur['whehref']?>">其他统计</a></div></td>
      <td width="58%">&nbsp;</td>
      <td width="6%">&nbsp;</td>
      <td width="6%">&nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="2">其他统计</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="18%" height="25">
		<div align="center"><strong>会员</strong></div></td>
    <td width="82%" align="right"><div align="left">待审核会员：<a href="../member/ListMember.php?sear=1&schecked=1<?=$ecms_hashur['ehref']?>" target="_blank"><?=$checkmembernum?></a>，会员总数：<a href="../member/ListMember.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$allmembernum?></a></div></td>
  </tr>
  <tr bgcolor="#C3EFFF">
    <td height="25"><div align="center"><strong>管理员</strong></div></td>
    <td align="right"><div align="left">管理员总数：<a href="../user/ListUser.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$adminnum?></a></div></td>
  </tr>
  <?php
  if($showshopmenu)
  {
  ?>
  <tr bgcolor="#FFFFFF">
    <td height="25"><div align="center"><strong>商城订单</strong></div></td>
    <td align="right"><div align="left">今天订单数：<a href="#empirecms" onclick="OpenShopSysDdPage();"><?=$todayddnum?></a>，昨日订单数：<a href="#empirecms" onclick="OpenShopSysDdPage();"><?=$yesterdayddnum?></a>，总订单数：<a href="#empirecms" onclick="OpenShopSysDdPage();"><?=$allddnum?></a></div></td>
  </tr>
  <?php
  }
  ?>
  <tr bgcolor="#C3EFFF">
    <td height="25"><div align="center"><strong>留言</strong></div></td>
    <td align="right"><div align="left">待审核留言：<a href="../tool/gbook.php?sear=1&checked=2<?=$ecms_hashur['ehref']?>" target="_blank"><?=$checkgbooknum?></a>，总留言数：<a href="../tool/gbook.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$allgbooknum?></a></div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25"><div align="center"><strong>反馈</strong></div></td>
    <td align="right"><div align="left">未查看反馈：<a href="../tool/feedback.php?sear=1&haveread=2<?=$ecms_hashur['ehref']?>" target="_blank"><?=$noreadfeedbacknum?></a>，总反馈数：<a href="../tool/feedback.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$allfeedbacknum?></a></div></td>
  </tr>
  <tr bgcolor="#C3EFFF">
    <td height="25"><div align="center"><strong>广告</strong></div></td>
    <td align="right"><div align="left">过期广告数：<a href="../tool/ListAd.php?time=1<?=$ecms_hashur['ehref']?>" target="_blank"><?=$outtimeadnum?></a>，总广告数：<a href="../tool/ListAd.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$alladnum?></a></div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25"><div align="center"><strong>错误报告</strong></div></td>
    <td align="right"><div align="left">错误报告数：<a href="../DownSys/ListError.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$errornum?></a></div></td>
  </tr>
  <tr bgcolor="#C3EFFF">
    <td height="25"><div align="center"><strong>友情链接</strong></div></td>
    <td align="right"><div align="left">友情链接数：<a href="../tool/ListLink.php<?=$ecms_hashur['whehref']?>" target="_blank"><?=$sitelinknum?></a></div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="23"><font color="#666666">说明：点击“数量”可进入相应的管理。</font></td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>