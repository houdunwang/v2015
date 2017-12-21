<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<form name="myform" action="?m=admin&c=position&a=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
             <th width="5%" align="left"><?php echo L('productid')?></th>
			 <th width="15%"><?php echo L('product_name')?></th>
			 <th width="30%"><?php echo L('product_description')?></th>
			 <th width="10%"><?php echo L('totalnum')?></th>
			 <th width="10%"><?php echo L('give_away')?></th>
             <th width="10%"><?php echo L('product_price').L('yuan')?></th>
             <th width="20%"><?php echo L('recharge_time')?></th>
            </tr>
        </thead>
    <tbody>
<?php 
if(is_array($payinfo_arr)) foreach($payinfo_arr as $info){
?>   
	<tr>
	<td width="5%"><?php echo $info['sms_pid']?></td>
	<td width="15%" align="center"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['name']);}else{ echo $info['name'];}?></td>
	<td width="10%" align="center"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['description']);}else{ echo $info['description'];}?></td>
	<td width="10%" align="center"><?php echo $info['totalnum']?></td>
	<td width="15%" align="center"><?php echo $info['give_away']?></td>
	<td width="10%" align="center"><?php echo $info['price']?></td>	
	<td width="20%" align="center"><?php echo format::date($info['recharge_time'],1)?></td>
	</tr>
<?php 

}
?>
    </tbody>
    </table>
  
    <div class="btn"></div>  </div>

 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>