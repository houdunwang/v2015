<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

//------------------ 参数开始 ------------------

//商户号
$v_mid=$payr['payuser'];

//密钥
$key=$payr['paykey'];

//返回地址
$v_url=$PayReturnUrlQz."e/payapi/chinabank/payend.php";

//币种
$v_moneytype="CNY";

//------------------ 参数结束 ------------------

$v_amount=$money;
//产生定单号
$v_oid=date("Ymd")."-".$v_mid."-".date("His");
$ddno=$ddno?$ddno:time();	//订单号
esetcookie("checkpaysession",$ddno,0);	//设置定单号
//md5
$text=$v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;
$v_md5info=strtoupper(md5($text));

$remark1=$ddno;//备注字段1
$remark2=$productname;//备注字段2
?>
<html>
<title>在线支付</title>
<meta http-equiv="Cache-Control" content="no-cache"/>
<body>
<form method="post" name="dopaypost" id="dopaypost" action="https://pay3.chinabank.com.cn/PayGate">
	<input type="hidden" name="v_mid"    value="<?php echo $v_mid;?>">
	<input type="hidden" name="v_oid"     value="<?php echo $v_oid;?>">
	<input type="hidden" name="v_amount" value="<?php echo $v_amount;?>">
	<input type="hidden" name="v_moneytype"  value="<?php echo $v_moneytype;?>">
	<input type="hidden" name="v_url"  value="<?php echo $v_url ;?>">
	<input type="hidden" name="v_md5info"   value="<?php echo $v_md5info;?>">
	<input type="hidden" name="remark1"   value="<?php echo $remark1;?>">
	<input type="hidden" name="remark2"   value="<?php echo $remark2;?>">
	<input type="submit" style="font-size: 9pt" value="在线支付" name="v_action">
</form>
<script>
document.getElementById('dopaypost').submit();
</script>
</body>
</html>