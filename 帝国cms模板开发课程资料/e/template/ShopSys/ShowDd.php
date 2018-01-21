<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../data/images/css.css" rel="stylesheet" type="text/css">
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
  <tr> 
    <td width="61%" height="27" bgcolor="#FFFFFF"><strong>订单号: 
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
      <?php
	  $buycar=$addr['buycar'];
	  $payby=$r['payby'];
	  include('buycar/buycar_showdd.php');
	  ?>
    </td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>订单信息</strong></td>
  </tr>
  <tr> 
    <td height="23" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="12%" height="25"> 
            <div align="right">订单号：</div></td>
          <td width="32%"><strong> 
            <?=$r[ddno]?>
            </strong></td>
          <td width="14%"> 
            <div align="right">订单状态：</div></td>
          <td width="41%"><strong> 
            <?=$ha?>
            </strong>/<strong> 
            <?=$ou?>
            </strong>/<strong> 
            <?=$ch?>
            </strong> 
            <?=$topay?>          </td>
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
          <td height="25">移动电话:</td>
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
          <td height="25">最佳送货地址:</td>
          <td><?=$r[besttime]?></td>
        </tr>
        <tr> 
          <td height="25">备注:</td>
          <td> 
            <?=nl2br($addr[bz])?>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="23" colspan="2" bgcolor="#EFEFEF"><strong>管理员备注信息</strong></td>
  </tr>
  <tr> 
    <td colspan="2"><table width="100%%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="20%" height="25">备注内容:</td>
          <td width="80%"> 
            <?=nl2br($addr['retext'])?>          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
        <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" id="pdiv">
          <tr> 
            <td><div align="center">
                <input type="button" name="Submit" value=" 打 印 " onclick="javascript:PrintDd();">
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
</body>
</html>