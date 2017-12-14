<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

//------------------ 参数开始 ------------------

//商户号
$bargainor_id=$payr['payuser'];

//密钥
$key=$payr['paykey'];

//返回地址
$return_url=$PayReturnUrlQz."e/payapi/tenpay/payend.php";

//支付币种,1为人民币
$fee_type=1;

//银行类型
$bank_type="0";

//------------------ 参数结束 ------------------

//支付金额
$total_fee=$money*100;

//提交的数据

$strCmdNo="1";	//财付通支付为"1" (当前只支持 cmdno=1)
$strBillDate=date('Ymd');	//交易日期 (yyyymmdd)
$desc=$productname;	//商品名称
$strBuyerId="";	//QQ号码
$strSpBillNo=$ddno?$ddno:time();	//订单号
esetcookie("checkpaysession",$strSpBillNo,0);	//设置定单号
$strTransactionId=$bargainor_id.$strBillDate.substr($strSpBillNo,0,10);	//交易订单号
$attach=$strSpBillNo;
$spbill_create_ip=egetip();

//md5
$strSignText="cmdno=".$strCmdNo."&date=".$strBillDate."&bargainor_id=".$bargainor_id."&transaction_id=".$strTransactionId."&sp_billno=".$strSpBillNo."&total_fee=".$total_fee."&fee_type=".$fee_type."&return_url=".$return_url."&attach=".$attach."&spbill_create_ip=".$spbill_create_ip."&key=".$key;
$strSign=strtoupper(md5($strSignText));
?>
<html>
<title>财付通支付</title>
<meta http-equiv="Cache-Control" content="no-cache"/>
<body>
<form action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" name="dopaypost" id="dopaypost">
<input type=hidden name="cmdno" value="<?echo $strCmdNo; ?>">
<input type=hidden name="date" value="<?echo $strBillDate; ?>">
<input type=hidden name="bank_type" value="<?echo $bank_type; ?>">
<input type=hidden name="desc" value="<?echo $desc; ?>">
<input type=hidden name="purchaser_id" value="<?echo $strBuyerId; ?>">
<input type=hidden name="bargainor_id" value="<?echo $bargainor_id; ?>">
<input type=hidden name="transaction_id" value="<?echo $strTransactionId; ?>">
<input type=hidden name="sp_billno" value="<?echo $strSpBillNo; ?>">
<input type=hidden name="total_fee" value="<?echo $total_fee; ?>">
<input type=hidden name="fee_type" value="<?echo $fee_type; ?>">
<input type=hidden name="return_url" value="<?echo $return_url; ?>">
<input type=hidden name="attach" value="<?echo $attach; ?>">
<input type=hidden name="spbill_create_ip" value="<?echo $spbill_create_ip; ?>">
<input type=hidden name="sign" value="<?echo $strSign; ?>">
<input type="submit" name="submit2" value="财付通支付">
</form>
<script>
document.getElementById('dopaypost').submit();
</script>
</body>
</html>