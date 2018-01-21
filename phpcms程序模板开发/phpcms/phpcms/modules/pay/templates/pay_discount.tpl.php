<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#discount").formValidator({onshow:"<?php echo L('disount_notice')?>",onfocus:"<?php echo L('empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('empty')?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=pay&c=payment&a=<?php echo $_GET['a']?>" method="post" id="myform">
<table width="100%" class="table_form">
<tr>
<td  width="80"><?php echo L('order_sn')?></td> 
<td><?php echo $trade_sn?></td>
</tr>
<tr>
<td><?php echo L('order_discount')?></td> 
<td><input type="text" name="discount" value="<?php echo $discount ? $discount : 0 ?>" class="input-text" id="discount" size="6"> <?php echo L('yuan')?>
</td>
</tr>
</table>
<input type="hidden"  name="id" value="<?php echo $id?>" />
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
</form>
</div></div>
</body>
</html>
<script type="text/javascript">

$(document).ready(function() {
	$("#paymethod input[type='radio']").click( function () {
		if($(this).val()== 0){
			$("#rate").removeClass('hidden');
			$("#fix").addClass('hidden');
			$("#rate input").val('0');
		} else {
			$("#fix").removeClass('hidden');
			$("#rate").addClass('hidden');
			$("#fix input").val('0');
		}	
	});
});
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>


