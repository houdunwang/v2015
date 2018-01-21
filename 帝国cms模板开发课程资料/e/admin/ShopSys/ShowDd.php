<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/hShopSysFun.php");
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
CheckLevel($logininid,$loginin,$classid,"shopdd");
$enews=ehtmlspecialchars($_GET['enews']);
$url="查看订单";
$ddid=(int)$_GET['ddid'];
if(!$ddid)
{
	printerror('ErrorUrl','');
}
$r=$empire->fetch1("select * from {$dbtbpre}enewsshopdd where ddid='$ddid'");
if(!$r['ddid'])
{
	printerror('ErrorUrl','');
}
$addr=$empire->fetch1("select * from {$dbtbpre}enewsshopdd_add where ddid='$ddid'");
//提交者
if(empty($r[userid]))//非会员
{
	$username="<font color=cccccc>游客</font>";
}
else
{
	$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r[userid].$ecms_hashur['ehref']."' target=_blank>".$r[username]."</a>";
}
//需要发票
$fp="否";
if($r[fp])
{
	$fp="是";
}
//金额
$total=0;
if($r[payby]==1)
{
	$pstotal=$r[pstotal]." 点";
	$alltotal=$r[alltotalfen]." 点";
	$total=$r[pstotal]+$r[alltotalfen];
	$mytotal=$total." 点";
}
else
{
	$pstotal=$r[pstotal]." 元";
	$alltotal=$r[alltotal]." 元";
	$total=$r[pstotal]+$r[alltotal]+$r[fptotal]-$r[pretotal];
	$mytotal=$total." 元";
}
//支付方式
if($r[payby]==1)
{
	$payfsname=$r[payfsname]."(积分购买)";
}
elseif($r[payby]==2)
{
	$payfsname=$r[payfsname]."(余额购买)";
}
else
{
	$payfsname=$r[payfsname];
}
//状态
if($r['checked']==1)
{
	$ch="已确认";
}
elseif($r['checked']==2)
{
	$ch="取消";
}
elseif($r['checked']==3)
{
	$ch="退货";
}
else
{
	$ch="<font color=red>未确认</font>";
}
//发货
if($r['outproduct']==1)
{
	$ou="已发货";
}
elseif($r['outproduct']==2)
{
	$ou="备货中";
}
else
{
	$ou="<font color=red>未发货</font>";
}
if($r['haveprice']==1)
{
	$ha="已付款";
}
else
{
	$ha="<font color=red>未付款</font>";
}
//显示商品信息
function ShowBuyproduct($buycar,$payby){
	global $empire,$dbtbpre;
	$record="!";
	$field="|";
	$buycarr=explode($record,$buycar);
	$bcount=count($buycarr);
	$totalmoney=0;
	$totalfen=0;
	?>
	<table width='100%' border=0 align=center cellpadding=3 cellspacing=1>
        <tr class='header'> 
            <td width='9%' height=23> <div align=center>序号</div></td>
            <td width='42%'> <div align=center>商品名称</div></td>
            <td width='15%'> <div align=center>单价</div></td>
            <td width='10%'> <div align=center>数量</div></td>
            <td width='19%'> <div align=center>小计</div></td>
        </tr>
	<?php
	$j=0;
	for($i=0;$i<$bcount-1;$i++)
	{
		$j++;
		$pr=explode($field,$buycarr[$i]);
		$productid=$pr[1];
		$fr=explode(",",$pr[1]);
		//ID
		$classid=(int)$fr[0];
		$id=(int)$fr[1];
		//属性
		$addatt='';
		if($pr[2])
		{
			$addatt=$pr[2];
		}
		//数量
		$pnum=(int)$pr[3];
		if(empty($pnum))
		{
			$pnum=1;
		}
		//单价
		$price=$pr[4];
		$thistotal=$price*$pnum;
		$buyfen=$pr[5];
		$thistotalfen=$buyfen*$pnum;
		if($payby==1)
		{
			$showprice=$buyfen." 点";
			$showthistotal=$thistotalfen." 点";
		}
		else
		{
			$showprice=$price." 元";
			$showthistotal=$thistotal." 元";
		}
		//产品名称
		$title=stripSlashes($pr[6]);
		//返回链接
		$titleurl="../../public/InfoUrl/?classid=$classid&id=$id";
		$totalmoney+=$thistotal;
		$totalfen+=$thistotalfen;
		?>
		<tr>
	<td align=center><?=$j?></td>
	<td align=center><a href="<?=$titleurl?>" target="_blank"><?=$title?></a><?=$addatt?' - '.$addatt:''?></td>
	<td align=right><b>￥<?=$showprice?></b></td>
	<td align=right><?=$pnum?></td>
	<td align=right><?=$showthistotal?></td>
	</tr>
		<?php
    }
	//点数付费
	if($payby==1)
	{
		?>
	<tr> 
      <td colspan=5><div align=right>合计点数:<strong><?=$totalfen?></strong></div></td>
      <td>&nbsp;</td>
    </tr>
		<?php
	}
	else
	{
		?>
	<tr> 
      <td colspan=5><div align=right>合计:<strong>￥<?=$totalmoney?></strong></div></td>
      <td>&nbsp;</td>
    </tr>
		<?php
	}
	?>
	</table>
	<?php
}

//------ 操作日志 ------
//操作事件

$shopecms_r=array
(
	'SetChecked'=>'设置订单状态',
	'SetOutProduct'=>'设置发货状态',
	'SetHaveprice'=>'设置付款状态',
	'DelDd'=>'删除订单',
	'EditPretotal'=>'修改优惠金额',
	'DdRetext'=>'修改后台订单备注',
	'DoCutMaxnum'=>'设置库存',
);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>查看订单</title>
<script>
function PrintDd()
{
	pdiv.style.display="none";
	window.print();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="showddform" id="showddform" method="post" action="ecmsshop.php" onsubmit="return confirm('确认要操作?');">
<?=$ecms_hashur['form']?>
  <input name="enews" type="hidden" id="enews" value="DdRetext">
  <input name="ddid" type="hidden" id="ddid" value="<?=$ddid?>">
  <tr> 
    <td width="61%" height="27" bgcolor="#FFFFFF"><strong>订单ID: 
      <?=$r[ddno]?>
      </strong></td>
    <td width="39%" bgcolor="#FFFFFF"><strong>下单时间: 
      <?=$r[ddtime]?>
      </strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>商品信息</strong></td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <?
	  ShowBuyproduct($addr[buycar],$r[payby]);
	  ?>    </td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>订单信息</strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        
        <tr>
          <td height="25"><div align="right">提交者：</div></td>
          <td><?=$username?></td>
          <td><div align="right">提交者IP地址：</div></td>
          <td><strong>
            <?=$r[userip]?>
          </strong></td>
        </tr>
        <tr> 
          <td width="15%" height="25"> 
            <div align="right">订单号：</div></td>
          <td width="35%"><strong> 
            <?=$r[ddno]?>
            </strong></td>
          <td width="15%"><div align="right">订单状态：</div></td>
          <td width="35%"><strong> 
            <?=$ha?>
            </strong>/<strong> 
            <?=$ou?>
            </strong>/<strong> 
            <?=$ch?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">下单时间：</div></td>
          <td><strong> 
            <?=$r[ddtime]?>
            </strong></td>
          <td><div align="right">商品总金额：</div></td>
          <td><strong>
            <?=$alltotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">配送方式：</div></td>
          <td><strong>
            <?=$r[psname]?>
            </strong></td>
          <td><div align="right">+ 商品运费：</div></td>
          <td><strong>
            <?=$pstotal?>
            </strong></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">支付方式：</div></td>
          <td><strong>
            <?=$payfsname?>
            </strong></td>
          <td><div align="right">+ 发票费用：</div></td>
          <td><?=$r[fptotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">需要发票：</div></td>
          <td><?=$fp?></td>
          <td><div align="right">- 优惠：</div></td>
          <td><?=$r[pretotal]?></td>
        </tr>
        <tr> 
          <td height="25"> 
            <div align="right">发票抬头：</div></td>
          <td><strong> 
            <?=$r[fptt]?>
            </strong></td>
          <td><div align="right">订单总金额：</div></td>
          <td><strong>
            <?=$mytotal?>
          </strong></td>
        </tr>
        <tr>
          <td height="25"><div align="right">发票名称：</div></td>
          <td colspan="3"><strong>
            <?=$r[fpname]?>
          </strong></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>收货人信息</strong></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="20%" height="25">真实姓名:</td>
          <td width="80%"> 
            <?=$r[truename]?>          </td>
        </tr>
        <tr> 
          <td height="25">QQ:</td>
          <td> 
            <?=$r[oicq]?>          </td>
        </tr>
        <tr> 
          <td height="25">MSN:</td>
          <td> 
            <?=$r[msn]?>          </td>
        </tr>
        <tr> 
          <td height="25">固定电话:</td>
          <td> 
            <?=$r[mycall]?>          </td>
        </tr>
        <tr> 
          <td height="25">手机:</td>
          <td> 
            <?=$r[phone]?>          </td>
        </tr>
        <tr> 
          <td height="25">联系邮箱:</td>
          <td> 
            <?=$r[email]?>          </td>
        </tr>
        <tr> 
          <td height="25">联系地址:</td>
          <td> 
            <?=$r[address]?>          </td>
        </tr>
        <tr> 
          <td height="25">邮编:</td>
          <td> 
            <?=$r[zip]?>          </td>
        </tr>
        <tr>
          <td height="25">标志建筑:</td>
          <td><?=$r[signbuild]?></td>
        </tr>
        <tr>
          <td height="25">最佳送货时间:</td>
          <td><?=$r[besttime]?></td>
        </tr>
        <tr> 
          <td height="25">备注:</td>
          <td> 
            <?=nl2br($addr[bz])?>          </td>
        </tr>
      </table></td>
  </tr>
  <tbody id="pdiv">
  <tr>
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>相关操作</strong></td>
  </tr>
  <tr>
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="16%">后台备注内容:<br>
          <br>
          <font color="#666666">(前台会员可查看，比如提供快递号等信息)</font></td>
        <td width="77%"><textarea name="retext" cols="65" rows="6" id="retext"><?=$addr['retext']?></textarea></td>
        <td width="7%"><input type="submit" name="Submit2" value="提交" onClick="document.showddform.enews.value='DdRetext';"></td>
      </tr>
      <tr>
        <td height="25">修改优惠金额：</td>
        <td><input name="pretotal" type="text" id="pretotal" value="<?=$r[pretotal]?>">
        修改原因：
          <input name="bz" type="text" id="bz"></td>
        <td><input type="submit" name="Submit3" value="提交" onClick="document.showddform.enews.value='EditPretotal';"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>订单操作日志</strong></td>
  </tr>
  <tr>
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
      <tr class="header">
        <td width="21%" height="23"><div align="center">操作时间</div></td>
        <td width="17%"><div align="center">操作者</div></td>
        <td width="19%"><div align="center">事件</div></td>
        <td width="19%"><div align="center">操作内容</div></td>
        <td width="24%"><div align="center">操作原因</div></td>
      </tr>
	  <?php
	  $logsql=$empire->query("select logid,userid,username,ecms,bz,addbz,logtime from {$dbtbpre}enewsshop_ddlog where ddid='$ddid' order by logid desc");
	  while($logr=$empire->fetch($logsql))
	  {
		  $empirecms=$shopecms_r[$logr['ecms']];
		  if($logr['ecms']=='DoCutMaxnum')
		  {
			  $logr['addbz']=$logr['addbz']=='ecms=1'?'还原库存':'减少库存';
		  }
	  ?>
      <tr bgcolor="#ffffff">
        <td height="23"><div align="center"><?=$logr['logtime']?></div></td>
        <td><div align="center"><?=$logr['username']?></div></td>
        <td><div align="center"><?=$empirecms?></div></td>
        <td><?=$logr['addbz']?></td>
        <td><?=$logr['bz']?></td>
      </tr>
      <?php
	  }
	  ?>
    </table></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
        <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td><div align="center">
                <input type="button" name="Submit" value=" 打 印 " onclick="javascript:PrintDd();">
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
  </tbody>
 </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>