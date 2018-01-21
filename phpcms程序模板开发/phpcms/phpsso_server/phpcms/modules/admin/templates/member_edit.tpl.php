<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('member_edit');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formValidatorRegex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password_len_error')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"});

	$("#email").formValidator({onshow:"<?php echo L('input')?>email",onfocus:"<?php echo L('notice_format')?>",oncorrect:"<?php echo L('right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"email<?php echo L('format_incorrect')?>"}).ajaxValidator({
			type : "get",
			url : "",
			data :"m=admin&c=member&a=ajax_email&uid=<?php echo $userinfo['uid']?>",
			datatype : "html",
			async:'true',
			success : function(data){	
				if( data == "1" ) {
					return true;
				} else {
					return false;
				}
			},
			buttons: $("#dosubmit"),
			onerror : "<?php echo L('email_already_exist')?>",
			onwait : "<?php echo L('connecting_please_wait')?>"
		}).defaultPassed();
})
//-->
</script>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('member_edit')?></h2>
	<div class="content-menu ib-a blue line-x">
		<a href="?m=admin&c=member&a=manage">
		<em><?php echo L('member_manage')?></em></a>
		<span>|</span>
		<a href="?m=admin&c=member&a=edit&uid=<?php echo $userinfo['uid']?>" class="on">
		<em><?php echo L('member_edit')?></em></a>
	</div>
</div>
<div class="pad-lr-10">
<form method=post action="?m=admin&c=member&a=edit" id="myform">
<table width="100%"  class="table_form">
<input type="hidden" name="uid" value="<?php echo $userinfo['uid']?>">
	<?php if($userinfo['avatar']) {?>
		<tr>
		<th><?php echo L('avatar')?>：</th>
		<td class="y-bg">
			<img src="<?php echo ps_getavatar($userinfo['uid']);?>">
			<input type="checkbox" name="avatar" id="avatar" class="input-text" value="1" ><label for="avatar"><?php echo L('delete').L('avatar')?></label>
		</td>
		</tr>
	<?php }?>
	<tr>
	<th width="80" ><?php echo L('username')?>：</th>
	<td class="y-bg"><?php echo $userinfo['username']?></td>
	</tr>
	<tr>
	<th><?php echo L('password')?>：</th>
	<td class="y-bg"><input type="password" class="input-text" name="password" id="password" value="" /></td>
	</tr>
	<tr>
	<th><?php echo L('email')?>：</th>
	<td class="y-bg"><input type="text" name="email" id="email" class="input-text" value="<?php echo $userinfo['email']?>" ></td>
	</tr>
</table>

<div class="bk15"></div>
   <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />


</form>
</div>
</body>
</html>
