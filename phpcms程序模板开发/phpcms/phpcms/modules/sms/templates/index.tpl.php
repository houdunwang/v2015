<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="smsform" action="" method="get" >
<input type="hidden" value="sms" name="m">
<input type="hidden" value="sms" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<?php echo get_smsnotice();?>
</div>
</form>
<div class="btn text-l">
<?php if(!empty($this->smsapi->userid)) {?>
<span class="font-fixh green"><?php echo L('account')?></span> ： <span class="font-fixh"><?php echo $this->smsapi->userid?></span> ， <span class="font-fixh green"><?php echo L('smsnumber')?></span> ： </span><span class="font-fixh"><?php echo $smsinfo_arr['surplus']?></span> <span class="font-fixh green"><?php echo L('item')?></span>

<?php } else {?>
<span class="font-fixh green">未绑定平台账户，请点击<a href="index.php?m=sms&c=sms&a=sms_setting&menuid=1539&pc_hash=<?php echo $_GET['pc_hash'];?>"><span class="font-fixh">平台设置</span></a>绑定。</span>
<?php }?>
</div><br>

<div class="btn text-l">
<span class="font-fixh green">当前服务器IP为 ： <span class="font-fixh"><?php echo $_SERVER["SERVER_ADDR"];?></span> <?php if(!empty($smsinfo_arr['allow_send_ip']) &&!in_array($_SERVER["SERVER_ADDR"],$smsinfo_arr['allow_send_ip'])) echo '当前服务器所在IP不允许发送短信';?>
</div>
<br>
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="5%" align="center"><?php echo L('product_id')?></th>
            <th width="20%" align="left"><?php echo L('product_name')?></th>
            <th width="30%" align="left"><?php echo L('product_description')?></th>
            <th width="10%" align="left"><?php echo L('totalnum')?></th>
            <th width="10%" align="left"><?php echo L('give_away')?></th>
            <th width="10%" align="left"><?php echo L('product_price').L('yuan')?></th>
            <th width="10%" align="left"><?php echo L('buy')?></th>
            </tr>
        </thead>
    <tbody>

<?php if(is_array($smsprice_arr)) foreach($smsprice_arr as $k=>$v) {?>
	<tr>
	<td width="10%" align="center"><?php echo $v['productid']?></td>

	<td width="10%" align="left"><?php echo $v['name']?></td>
	<td width="10%" align="left"><?php echo $v['description']?></td>
	<td width="10%" align="left"><?php echo $v['totalnum']?></td>
	<td width="10%" align="left"><?php echo $v['give_away']?></td>
	<td width="10%" align="left"><?php echo $v['price']?></td>
	<td width="10%" align="left"><a href="<?php echo $this->smsapi->get_buyurl($v['productid']);?>" target="_blank"><?php echo L('buy')?></a></td>
	</tr>
<?php }?>
    </tbody>
    </table>
<div class="explain-col search-form">
开启会员注册短信验证方法：后台->用户->会员模块配置->手机强制验证方式 选择 <font color="red">是</font>
</div>
</div>
</div>
<br>

<br>
<br>
<br>
</body>
</html>