<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php 
$page_title=L('change_password');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formValidatorRegex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#password").formValidator({onshow:"<?php echo L('inputpassword')?>",onfocus:"<?php echo L('password_len_error')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"});
	$("#newpassword").formValidator({onshow:"<?php echo L('inputpassword')?>",onfocus:"<?php echo L('password_len_error')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"});
	$("#newpassword2").formValidator({onshow:"<?php echo L('means_code')?>",onfocus:"<?php echo L('the_two_passwords_are_not_the_same_admin_zh')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"}).compareValidator({desid:"newpassword",operateor:"=",onerror:"<?php echo L('the_two_passwords_are_not_the_same_admin_zh')?>"});
	
})
//-->
</script>
<div class="subnav">
<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('change_password')?></h2>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=password&a=init" method="post">
<table width="100%" class="table_form">
<tr>
<th width="100"><?php echo L('current_password')?>：</th>
<td><input type="password" class="input-text" name="password" id="password" value="" /></td>
</tr>
<tr>
<th width="100" align="right"><?php echo L('new_password')?>：</th>
<td><input type="password" class="input-text" name="newpassword"  id="newpassword" value="" /></td>
</tr>
<tr>
<th width="100" align="right"><?php echo L('bootos_x')?>：</th>
<td><input type="password" class="input-text" name="newpassword2" id="newpassword2" value="" /></td>
</tr>
</table>
<div class="bk15"></div>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />

</form>
</div>

</body>
</html>