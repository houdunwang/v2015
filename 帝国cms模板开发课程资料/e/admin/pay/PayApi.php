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
CheckLevel($logininid,$loginin,$classid,"pay");

//设置接口
function EditPayApi($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[payid]=(int)$add[payid];
	if(empty($add[payname])||!$add[payid])
	{
		printerror("EmptyPayApi","history.go(-1)");
    }
	$add[isclose]=(int)$add[isclose];
	$add[myorder]=(int)$add[myorder];
	$add[paymethod]=(int)$add[paymethod];
	$sql=$empire->query("update {$dbtbpre}enewspayapi set isclose='$add[isclose]',payname='$add[payname]',paysay='$add[paysay]',payuser='$add[payuser]',paykey='$add[paykey]',payfee='$add[payfee]',payemail='$add[payemail]',myorder='$add[myorder]',paymethod='$add[paymethod]' where payid='$add[payid]'");
	if($sql)
	{
		//操作日志
		insert_dolog("payid=".$add[payid]."<br>payname=".$add[payname]);
		printerror("EditPayApiSuccess","PayApi.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//支付参数设置
function SetPayFen($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[paymoneytofen]=(int)$add[paymoneytofen];
	$add[payminmoney]=(int)$add[payminmoney];
	if(empty($add[paymoneytofen]))
	{
		printerror("EmptySetPayFen","history.go(-1)");
    }
	$sql=$empire->query("update {$dbtbpre}enewspublic set paymoneytofen='$add[paymoneytofen]',payminmoney='$add[payminmoney]'");
	if($sql)
	{
		//操作日志
		insert_dolog("moneytofen=$add[paymoneytofen]&minmoney=$add[payminmoney]");
		printerror("SetPayFenSuccess","SetPayFen.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加用户
if($enews=="EditPayApi")
{
	EditPayApi($_POST,$logininid,$loginin);
}
elseif($enews=="SetPayFen")
{
	SetPayFen($_POST,$logininid,$loginin);
}

$sql=$empire->query("select payid,paytype,payfee,paylogo,paysay,payname,isclose from {$dbtbpre}enewspayapi order by myorder,payid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>支付接口</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置：在线支付&gt; <a href="PayApi.php<?=$ecms_hashur['whehref']?>">管理支付接口</a> </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="管理支付记录" onclick="self.location.href='ListPayRecord.php<?=$ecms_hashur['whehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit52" value="支付参数设置" onclick="self.location.href='SetPayFen.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="15%"><div align="center">接口名称</div></td>
    <td width="47%"><div align="center">接口描述</div></td>
    <td width="7%"><div align="center">状态</div></td>
    <td width="12%" height="25"><div align="center">接口类型</div></td>
    <td width="11%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
	  if($r[paytype]=='alipay')
	  {
		  $r[payname]="<font color='red'><b>".$r[payname]."</b></font>";
	  }
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="38" align="center"> 
      <?=$r[payname]?>
    </td>
    <td>
      <?=$r[paysay]?>
    </td>
    <td><div align="center">
        <?=$r[isclose]==0?'开启':'关闭'?>
      </div></td>
    <td height="25"> <div align="center">
        <?=$r[paytype]?>
      </div></td>
    <td height="25"> <div align="center"><a href="SetPayApi.php?enews=EditPayApi&payid=<?=$r[payid]?><?=$ecms_hashur['ehref']?>">配置接口</a></div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
