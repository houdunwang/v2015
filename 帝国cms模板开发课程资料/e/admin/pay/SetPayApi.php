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
CheckLevel($logininid,$loginin,$classid,"pay");
$enews=ehtmlspecialchars($_GET['enews']);
$payid=(int)$_GET['payid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewspayapi where payid='$payid'");
$url="在线支付&gt; <a href=PayApi.php".$ecms_hashur['whehref'].">管理支付接口</a>&nbsp;>&nbsp;配置支付接口：<b>".$r[paytype]."</b>";
$registerpay='';
//支付宝
if($r[paytype]=='alipay')
{
	$registerpay="<input type=\"button\" value=\"立即申请支付宝接口\" onclick=\"javascript:window.open('http://www.phome.net/empireupdate/payapi/?ecms=alipay');\">";
}
db_close();
$empire=null;
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
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="管理支付记录" onclick="self.location.href='ListPayRecord.php<?=$ecms_hashur['whehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit52" value="支付参数设置" onclick="self.location.href='SetPayFen.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="setpayform" method="post" action="PayApi.php" enctype="multipart/form-data">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">配置支付接口 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="payid" type="hidden" id="payid" value="<?=$payid?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">接口类型：</div></td>
      <td height="25"> 
        <?=$r[paytype]?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">接口状态：</div></td>
      <td height="25"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
        开启 
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
        关闭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25"><div align="right">接口名称：</div></td>
      <td width="77%" height="25"><input name="payname" type="text" id="payname" value="<?=$r[payname]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><div align="right">接口描述：</div></td>
      <td height="25"><textarea name="paysay" cols="65" rows="6" id="paysay"><?=ehtmlspecialchars($r[paysay])?></textarea></td>
    </tr>
    <?php
	if($r[paytype]=='alipay')
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">支付宝类型：</div></td>
      <td height="25"><select name="paymethod" id="paymethod">
          <option value="0"<?=$r[paymethod]==0?' selected':''?>>使用标准双接口</option>
          <option value="1"<?=$r[paymethod]==1?' selected':''?>>使用即时到帐交易接口</option>
          <option value="2"<?=$r[paymethod]==2?' selected':''?>>使用担保交易接口</option>
        </select></td>
    </tr>
    <?php
	}
	?>
	<?php
	if($r[paytype]=='alipay')
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">支付宝帐号：</div></td>
      <td height="25"><input name="payemail" type="text" id="payemail" value="<?=$r[payemail]?>" size="35"></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right"><?=$r[paytype]=='alipay'?'合作者身份(parterID)':'商户号(ID)'?>：</div></td>
      <td height="25"><input name="payuser" type="text" id="payuser" value="<?=$r[payuser]?>" size="35"> 
        <?=$registerpay?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right"><?=$r[paytype]=='alipay'?'交易安全校验码(key)':'密钥(KEY)'?>：</div></td>
      <td height="25"><input name="paykey" type="text" id="paykey" value="<?=$r[paykey]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">手续费：</div></td>
      <td height="25"><input name=payfee type=text id="payfee" value='<?=$r[payfee]?>' size="35">
        % </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="right">显示排序：</div></td>
      <td height="25"><input name=myorder type=text id="myorder" value='<?=$r[myorder]?>' size="35">
        <font color="#666666">(值越小显示越前面)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value=" 设 置 "> &nbsp;&nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
