<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;
include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('username').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('username').L('between_2_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=admin&c=admin_manage&a=public_checkname_ajx",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('user_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo L('input').L('password')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({onshow:"<?php echo L('input').L('cofirmpwd')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
	$("#email").formValidator({onshow:"<?php echo L('input').L('email')?>",onfocus:"<?php echo L('email').L('format_incorrect')?>",oncorrect:"<?php echo L('email').L('format_right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo L('email').L('format_incorrect')?>"});
})
//-->
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=admin_manage&a=add" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo L('username')?></td> 
<td><input type="test" name="info[username]"  class="input-text" id="username"></input></td>
</tr>
<tr>
<td><?php echo L('password')?></td> 
<td><input type="password" name="info[password]" class="input-text" id="password" value=""></input></td>
</tr>
<tr>
<td><?php echo L('cofirmpwd')?></td> 
<td><input type="password" name="info[pwdconfirm]" class="input-text" id="pwdconfirm" value=""></input></td>
</tr>
<tr>
<td><?php echo L('email')?></td>
<td>
<input type="text" name="info[email]" value="" class="input-text" id="email" size="30"></input>
</td>
</tr>
<tr>
<td><?php echo L('realname')?></td>
<td>
<input type="text" name="info[realname]" value="" class="input-text" id="realname"></input>
</td>
</tr>
<tr>
<td><?php echo L('userinrole')?></td>
<td>
<select name="info[roleid]">
<?php 
foreach($roles as $role)
{
?>
<option value="<?php echo $role['roleid']?>" <?php echo (($role['roleid']==$roleid) ? 'selected' : '')?>><?php echo $role['rolename']?></option>
<?php 
}	
?>
</select>
</td>
</tr>
</table>
    <div class="bk15"></div>
    <input type="hidden" name="info[admin_manage_code]" value="<?php echo $admin_manage_code?>" id="admin_manage_code"></input>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</form>
</div>
</div>
</body>
</html>

