<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('member_add');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formValidatorRegex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('between_6_to_20')?>"}).inputValidator({min:4,max:20,onerror:"<?php echo L('between_6_to_20')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('username').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=admin&c=member&a=ajax_username",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" ) {
                return true;
			}
            else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('user_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});

	$("#password").formValidator({onshow:"<?php echo L('inputpassword')?>",onfocus:"<?php echo L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('between_6_to_20')?>"});
	$("#email").formValidator({onshow:"<?php echo L('input')?>email",onfocus:"email<?php echo L('format_incorrect')?>",oncorrect:"<?php echo L('right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"email<?php echo L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=admin&c=member&a=ajax_email",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" ) {
                return true;
			}
            else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('email_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
})
//-->
</script>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('member_add')?></h2>
	<div class="content-menu ib-a blue line-x">
		<a href="?m=admin&c=member&a=manage">
		<em><?php echo L('member_manage')?></em></a>
		<span>|</span>
		<a href="?m=admin&c=member&a=add" class="on">
		<em><?php echo L('member_add')?></em></a>
	</div>
</div>
<div class="pad-lr-10">
<form method=post action="?m=admin&c=member&a=add" id='myform'>
<table width="100%"  class="table_form">
	<tr>
	<th width="80" ><?php echo L('username')?>：</th>
	<td class="y-bg"><input type="text" name="username" id="username" class="input-text"></td>
	</tr>
	<tr>
	<th><?php echo L('password')?>：</th>
	<td class="y-bg"><input type="password" class="input-text" name="password" id="password" value="" /></td>
	</tr>
	<tr>
	<th><?php echo L('email')?>：</th>
	<td class="y-bg"><input type="text" name="email" id="email" class="input-text" ></td>
	</tr>
</table>

<div class="bk15"></div>
   <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />

</form>
</div>
</body>
</html>
