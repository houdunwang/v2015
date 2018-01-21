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
CheckLevel($logininid,$loginin,$classid,"public");
$r=$empire->fetch1("select * from {$dbtbpre}enewsshop_set limit 1");
//刷新表
$changetable='';
$i=0;
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$i++;
	if($i%4==0)
	{
		$br="<br>";
	}
	else
	{
		$br="";
	}
	$checked='';
	if(stristr($r['shoptbs'],','.$tr[tbname].','))
	{
		$checked=' checked';
	}
	$changetable.="<input type=checkbox name=tbname[] value='$tr[tbname]'".$checked.">$tr[tname]&nbsp;&nbsp;".$br;
}
//权限
$shopddgroup='';
$mgsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($mgr=$empire->fetch($mgsql))
{
	if($r[shopddgroupid]==$mgr[groupid])
	{
		$shopddgroup_select=' selected';
	}
	else
	{
		$shopddgroup_select='';
	}
	$shopddgroup.="<option value=".$mgr[groupid].$shopddgroup_select.">".$mgr[groupname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>商城参数设置</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><p>位置：商城参数设置</p>
      </td>
  </tr>
</table>
<form name="plset" method="post" action="ecmsshop.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">商城参数设置 
        <input name=enews type=hidden value=SetShopSys></td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">指定使用商城功能的数据表</td>
	  <td width="81%"><?=$changetable?></td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">购买流程</td>
	  <td><select name="buystep" size="1" id="buystep">
	    <option value="0"<?=$r['buystep']==0?' selected':''?>>购物车 &gt; 联系方式+配送方式+支付方式 &gt; 确认订单 &gt; 提交订单</option>
		<option value="1"<?=$r['buystep']==1?' selected':''?>>购物车 &gt; 联系方式+配送方式+支付方式 &gt; 提交订单</option>
		<option value="2"<?=$r['buystep']==2?' selected':''?>>联系方式+配送方式+支付方式 &gt; 提交订单</option>
	    </select>	  </td>
    </tr>
	<tr bgcolor="#FFFFFF">
	  <td height="25">&nbsp;</td>
	  <td><input name="shoppsmust" type="checkbox" id="shoppsmust" value="1"<?=$r['shoppsmust']==1?' checked':''?>>
      显示配送方式
      <input name="shoppayfsmust" type="checkbox" id="shoppayfsmust" value="1"<?=$r['shoppayfsmust']==1?' checked':''?>>
      显示支付方式 <font color="#666666">(提交订单时不显示且为非必选项)</font></td>
    </tr>
	<tr bgcolor="#FFFFFF">
          <td height="25">提交订单权限</td>
          <td><select name="shopddgroupid" id="shopddgroupid">
              <option value="0"<?=$r['shopddgroupid']==0?' selected':''?>>游客</option>
			  <option value="1"<?=$r['shopddgroupid']==1?' selected':''?>>会员才能提交订单</option>
            </select></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">购物车最大商品数</td>
          <td><input name="buycarnum" type="text" id="buycarnum" value="<?=$r[buycarnum]?>">
            <font color="#666666">(0为不限，为1时购物车会采用替换原商品方式)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">单商品最大购买数</td>
          <td><input name="singlenum" type="text" id="singlenum" value="<?=$r[singlenum]?>">
            <font color="#666666">(0为不限，限制订单里单个商品最大购买数量)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">满多少金额免运费</td>
          <td><input name="freepstotal" type="text" id="freepstotal" value="<?=$r[freepstotal]?>">
            元
          <font color="#666666">(0为无免运费)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">购物车支持附加属性</td>
          <td><input type="radio" name="haveatt" value="1"<?=$r['haveatt']==1?' checked':''?>>
开启
  <input type="radio" name="haveatt" value="0"<?=$r['haveatt']==0?' checked':''?>>
关闭<font color="#666666">（加入商品可用“addatt”数组变量传递，例如：&amp;addatt[]=蓝色）</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">会员可自己取消订单的时间</td>
          <td><input name="dddeltime" type="text" id="dddeltime" value="<?=$r[dddeltime]?>">
            分钟 <font color="#666666">(超过设定时间会员自己不能删除订单，0为不可删除)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">库存减少设置</td>
          <td><select name="cutnumtype" id="cutnumtype">
            <option value="0"<?=$r[cutnumtype]==0?' selected':''?>>下订单时减少库存</option>
            <option value="1"<?=$r[cutnumtype]==1?' selected':''?>>下订单并支付时减少库存</option>
          </select>          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">未付款多少时间后还原库存</td>
          <td><input name="cutnumtime" type="text" id="cutnumtime" value="<?=$r[cutnumtime]?>">
            分钟 <font color="#666666">(0为不限，超过设定时间自动取消订单，并还源库存)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="25">是否提供发票</td>
          <td><input name="havefp" type="checkbox" id="havefp" value="1"<?=$r[havefp]==1?' checked':''?>>
            是,收取 
            <input name="fpnum" type="text" id="fpnum" value="<?=$r[fpnum]?>" size="6">
            % 的发票费</td>
    </tr>
        <tr bgcolor="#FFFFFF">
          <td height="25">发票名称<br>
          <br>
          <font color="#666666">(一行一个，比如：办公用品)</font></td>
          <td><textarea name="fpname" cols="38" rows="8" id="fpname"><?=ehtmlspecialchars($r[fpname])?></textarea></td>
        </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">订单必填项</td>
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="truename"<?=stristr($r['ddmust'],',truename,')?' checked':''?>>
            姓名</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="oicq"<?=stristr($r['ddmust'],',oicq,')?' checked':''?>>
            QQ</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="msn"<?=stristr($r['ddmust'],',msn,')?' checked':''?>>
            MSN</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="email"<?=stristr($r['ddmust'],',email,')?' checked':''?>>
            邮箱</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="mycall"<?=stristr($r['ddmust'],',mycall,')?' checked':''?>>
            固定电话</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="phone"<?=stristr($r['ddmust'],',phone,')?' checked':''?>>
            手机</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="address"<?=stristr($r['ddmust'],',address,')?' checked':''?>>
            联系地址</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="zip"<?=stristr($r['ddmust'],',zip,')?' checked':''?>>
邮编</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="signbuild"<?=stristr($r['ddmust'],',signbuild,')?' checked':''?>>
            标志建筑</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="besttime"<?=stristr($r['ddmust'],',besttime,')?' checked':''?>>
            送货最佳时间</td>
          </tr>
        <tr>
          <td><input name="ddmustf[]" type="checkbox" id="ddmustf[]" value="bz"<?=stristr($r['ddmust'],',bz,')?' checked':''?>> 
            备注</td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
