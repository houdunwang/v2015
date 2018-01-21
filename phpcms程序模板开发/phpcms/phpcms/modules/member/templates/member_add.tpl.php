<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});

	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('username').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('username').L('between_2_to_20')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('username').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member&a=public_checkname_ajax",
		datatype : "html",
		async:'false',
		success : function(data){
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('deny_register').L('or').L('user_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo L('input').L('password')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({onshow:"<?php echo L('input').L('cofirmpwd')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
	$("#point").formValidator({tipid:"pointtip",onshow:"<?php echo L('input').L('point').L('point_notice')?>",onfocus:"<?php echo L('point').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('point').L('between_1_to_8_num')?>"});
	$("#email").formValidator({onshow:"<?php echo L('input').L('email')?>",onfocus:"<?php echo L('email').L('format_incorrect')?>",oncorrect:"<?php echo L('email').L('format_right')?>"}).inputValidator({min:2,max:32,onerror:"<?php echo L('email').L('between_2_to_32')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo L('email').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member&a=public_checkemail_ajax",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('deny_register').L('or').L('email_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#nickname").formValidator({onshow:"<?php echo L('input').L('nickname')?>",onfocus:"<?php echo L('nickname').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('nickname').L('between_2_to_20')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('nickname').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=index&a=public_checknickname_ajax",
		datatype : "html",
		async:'false',
		success : function(data){
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('already_exist').L('already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('username')?></td> 
			<td><input type="text" name="info[username]"  class="input-text" id="username"></input></td>
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
			<td><?php echo L('nickname')?></td> 
			<td><input type="text" name="info[nickname]" id="nickname" value="" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('email')?></td>
			<td>
			<input type="text" name="info[email]" value="" class="input-text" id="email" size="30"></input>
			</td>
		</tr>
		<tr>
			<td><?php echo L('mp')?></td>
			<td>
			<input type="text" name="info[mobile]" value="<?php echo $memberinfo['mobile']?>" class="input-text" id="mobile" size="15"></input>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td>
			<td>
			<?php echo form::select($grouplist, '2', 'name="info[groupid]"', '');?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('point')?></td>
			<td>
			<input type="text" name="info[point]" value="" class="input-text" id="point" size="10"></input>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_model')?></td>
			<td>
			<?php echo form::select($modellist, '44', 'name="info[modelid]"', '');?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('vip')?></td>
			<td>
			<?php echo L('isvip')?> <input type="checkbox" name="info[vip]" value=1 />
			<?php echo L('overduedate')?> <?php echo form::date('info[overduedate]', '', 1)?>
			</td>
		</tr>
	</table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
</html>