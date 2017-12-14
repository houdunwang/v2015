<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
//显示配送方式
function ShowPs($pid){
	global $empire,$dbtbpre,$shoppr,$totalr;
	$pid=(int)$pid;
	$r=$empire->fetch1("select pid,pname,price,psay from {$dbtbpre}enewsshopps where pid='$pid' and isclose=0");
	if(empty($r[pid]))
	{
		printerror('请选择配送方式','',1,0,1);
	}
	$r['price']=ShopSys_PrePsTotal($r['pid'],$r['price'],$totalr['truetotalmoney'],$shoppr);
	echo"<table width='100%' border=0 align=center cellpadding=3 cellspacing=1>
  <tr> 
    <td width='69%' height=25> 
      <strong>".$r[pname]."</strong>
    </td>
    <td width='31%'><strong>费用:￥".$r['price']."</strong></td>
  </tr>
  <tr> 
    <td colspan=2><table width='98%' border=0 align=right cellpadding=3 cellspacing=1><tr><td>".$r[psay]."</td></tr></table></td>
  </tr>
</table>";
	return $r['price'];
}

//显示支付方式
function ShowPayfs($payfsid,$r,$price){
	global $empire,$public_r,$dbtbpre,$totalr,$shoppr;
	$payfsid=(int)$payfsid;
	$add=$empire->fetch1("select payid,payname,payurl,paysay,userpay,userfen from {$dbtbpre}enewsshoppayfs where payid='$payfsid' and isclose=0");
	if(empty($add[payid]))
	{
		printerror('请选择支付方式','',1,0,1);
	}
	//总金额
	$buyallmoney=$totalr['totalmoney']+$price-$totalr['pretotal'];
	if($add[userfen]&&$r[fp])
	{
		printerror("FenNotFp","history.go(-1)",1);
	}
	//发票
	if($r[fp])
	{
		$fptotal=($totalr['totalmoney']-$totalr['pretotal'])*($shoppr[fpnum]/100);
		$afp="+发票费(".$fptotal.")";
		$buyallmoney+=$fptotal;
	}
	$buyallfen=$totalr['totalfen']+$price;
	$returntotal="采购总额(".$totalr['totalmoney'].")+配送费(".$price.")".$afp."-优惠(".$totalr['pretotal'].")=总额(<b>".$buyallmoney." 元</b>)";
	$mytotal="结算总金额为:<b><font color=red>".$buyallmoney." 元</font></b> 全部";
	//是否登陆
	if($add[userfen]||$add[userpay])
	{
		if(!getcvar('mluserid'))
		{
			printerror("NotLoginTobuy","history.go(-1)",1);
		}
		$user=islogin();
		//点数购买
		if($add[userfen])
		{
			if($buyallfen>$user[userfen])
			{
				printerror("NotEnoughFenBuy","history.go(-1)",1);
			}
			$returntotal="采购总点数(".$totalr['totalfen'].")+配送点数费(".$price.")=总点数(<b>".$buyallfen." 点</b>)";
			$mytotal="结算总点数为:<b><font color=red>".$buyallfen." 点</font></b> 全部";
		}
		else//扣除余额
		{
			if($buyallmoney>$user[money])
			{
				printerror("NotEnoughMoneyBuy","history.go(-1)",1);
			}
		}
	}
	echo "<table width='100%' border=0 align=center cellpadding=3 cellspacing=1><tr><td>".$add[payname]."</td></tr></table>";
	$return[0]=$returntotal;
	$return[1]=$mytotal;
	return $return;
}
?>
<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.01 Transitional//EN>
<html>
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>订单确认</title>
<link href=../../data/images/css.css rel=stylesheet type=text/css>
</head>

<body>
<form action="../doaction.php" method="post" name="myorder" id="myorder">
<input type=hidden name=enews value=AddDd>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td height="27" bgcolor="#FFFFFF"><strong>订单号: 
        <?=$ddno?>
        <input name="ddno" type="hidden" id="ddno" value="<?=$ddno?>">
        </strong></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#EFEFEF"><strong>选择的商品</strong></td>
    </tr>
    <tr> 
      <td> 
      <?php
	  include('buycar/buycar_order.php');
	  $totalr=array();
	  $totalr['totalmoney']=$totalmoney;
	  $totalr['buytype']=$buytype;
	  $totalr['totalfen']=$totalfen;
	  //优惠码
	  $prer=array();
	  $pretotal=0;
	  if($r['precode'])
	  {
		$prer=ShopSys_GetPre($r['precode'],$totalr['totalmoney'],$user,$classids);
		$pretotal=ShopSys_PreMoney($prer,$totalr['totalmoney']);
	  }
	  $totalr['pretotal']=$pretotal;
	  $totalr['truetotalmoney']=$totalr['totalmoney']-$pretotal;
	  ?>
	  </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#EFEFEF"><strong>收货人信息</strong></td>
    </tr>
    <tr> 
      <td><table width="100%%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="20%">真实姓名:</td>
            <td width="80%"> 
              <?=$r[truename]?>
              <input name="truename" type="hidden" id="truename" value="<?=$r[truename]?>">            </td>
          </tr>
          <tr> 
            <td>OICQ:</td>
            <td> 
              <?=$r[oicq]?>
              <input name="oicq" type="hidden" id="oicq" value="<?=$r[oicq]?>"></td>
          </tr>
          <tr> 
            <td>MSN:</td>
            <td> 
              <?=$r[msn]?>
              <input name="msn" type="hidden" id="msn" value="<?=$r[msn]?>"></td>
          </tr>
          <tr> 
            <td>固定电话:</td>
            <td> 
              <?=$r[mycall]?>
              <input name="mycall" type="hidden" id="mycall" value="<?=$r[mycall]?>">            </td>
          </tr>
          <tr> 
            <td>移动电话:</td>
            <td> 
              <?=$r[phone]?>
              <input name="phone" type="hidden" id="phone" value="<?=$r[phone]?>"></td>
          </tr>
          <tr> 
            <td>联系邮箱:</td>
            <td> 
              <?=$r[email]?>
              <input name="email" type="hidden" id="email" value="<?=$r[email]?>">            </td>
          </tr>
          <tr> 
            <td>联系地址:</td>
            <td> 
              <?=$r[address]?>
              <input name="address" type="hidden" id="address" value="<?=$r[address]?>" size="60">            </td>
          </tr>
          <tr> 
            <td>邮编:</td>
            <td> 
              <?=$r[zip]?>
              <input name="zip" type="hidden" id="zip" value="<?=$r[zip]?>" size="8">            </td>
          </tr>
          <tr>
            <td>周边标志建筑:</td>
            <td><?=$r[signbuild]?>
              <input name="signbuild" type="hidden" id="signbuild" value="<?=$r[signbuild]?>" size="8"></td>
          </tr>
          <tr>
            <td>最佳送货时间:</td>
            <td><?=$r[besttime]?>
              <input name="besttime" type="hidden" id="besttime" value="<?=$r[besttime]?>" size="8"></td>
          </tr>
          <tr> 
            <td>备注:</td>
            <td> 
              <?=nl2br($r[bz])?> <input name="bz" type="hidden" value="<?=$r[bz]?>" size="8">            </td>
          </tr>
        </table></td>
    </tr>
	<?php
	if($shoppr['shoppsmust'])
	{
	?>
    <tr> 
      <td height="23" bgcolor="#EFEFEF"><strong>选择配送方式 
        <input name="psid" type="hidden" id="psid" value="<?=$r[psid]?>" size="8">
        </strong></td>
    </tr>
    <tr> 
      <td height="27"> 
      <?
	  $price=ShowPs($r[psid]);
	  ?>      </td>
    </tr>
	<?php
	}
	?>
	<?php
	if($shoppr['shoppayfsmust'])
	{
	?>
    <tr> 
      <td height="23" bgcolor="#EFEFEF"><strong>选择支付方式 
        <input name="payfsid" type="hidden" id="payfsid" value="<?=$r[payfsid]?>" size="8">
        </strong></td>
    </tr>
    <tr> 
      <td height="27"> 
        <?
	  $total=ShowPayfs($r[payfsid],$r,$price);
	  ?>      </td>
    </tr>
	<?php
	}
	?>
	<?php
	if($shoppr[havefp]&&$r[fp])
	{
	?>
    <tr>
      <td height="23" bgcolor="#EFEFEF"><strong>发票信息</strong></td>
    </tr>
    <tr>
      <td height="23" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="20%">发票费用:</td>
          <td width="80%"><?=$shoppr[fpnum]?>%</td>
        </tr>
        <tr>
          <td>发票抬头:</td>
          <td><?=$r['fptt']?></td>
        </tr>
        <tr>
          <td>发票名称:</td>
          <td><?=$r['fpname']?></td>
        </tr>
      </table>
	  	<input name="fp" type="hidden" id="fp" value="<?=$r[fp]?>">
        <input name="fptt" type="hidden" id="fptt" value="<?=$r[fptt]?>">
		<input name="fpname" type="hidden" id="fpname" value="<?=$r[fpname]?>">	  </td>
    </tr>
	<?php
	}
	?>
    <tr>
      <td height="23" bgcolor="#EFEFEF"><strong>优惠</strong></td>
    </tr>
    <tr>
      <td height="23" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="20%">优惠码:</td>
          <td width="80%"><?=$prer[precode]?><input name="precode" type="hidden" id="precode" value="<?=$r[precode]?>"></td>
        </tr>
        <tr>
          <td>优惠金额:</td>
          <td><?=$pretotal?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="23" bgcolor="#EFEFEF"><strong>结算信息 
        </strong></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr>
            <td><div align="center"><?=$total[0]?></div></td>
          </tr>
          <tr> 
            <td><div align="center">
                <?=$total[1]?>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr height=27> 
      <td><div align="center"> 
          <input type="button" name="Submit3" value=" 上一步 " onclick="history.go(-1)">
		  &nbsp;&nbsp;
		  <input type="submit" name="Submit" value=" 提交订单 ">
        </div></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>