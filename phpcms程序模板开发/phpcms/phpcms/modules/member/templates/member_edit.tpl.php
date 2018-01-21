<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('passwords_not_match')?>"});
	$("#point").formValidator({tipid:"pointtip",onshow:"<?php echo L('input').L('point').L('point_notice')?>",onfocus:"<?php echo L('point').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('point').L('between_1_to_8_num')?>"});
	$("#email").formValidator({onshow:"<?php echo L('input').L('email')?>",onfocus:"<?php echo L('email').L('format_incorrect')?>",oncorrect:"<?php echo L('email').L('format_right')?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo L('email').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member&a=public_checkemail_ajax&phpssouid=<?php echo $memberinfo['phpssouid']?>",
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
		onerror : "<?php echo L('email_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
	$("#nickname").formValidator({onshow:"<?php echo L('input').L('nickname')?>",onfocus:"<?php echo L('nickname').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('nickname').L('between_2_to_20')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('nickname').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=index&a=public_checknickname_ajax&userid=<?php echo $memberinfo['userid'];?>",
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
		onerror : "<?php echo L('username').L('already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
  });
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=edit" method="post" id="myform">
	<input type="hidden" name="info[userid]" id="userid" value="<?php echo $memberinfo['userid']?>"></input>
	<input type="hidden" name="info[username]" value="<?php echo $memberinfo['username']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('username')?></td> 
			<td><?php echo $memberinfo['username']?><?php if($memberinfo['islock']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?><?php if($memberinfo['vip']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/vip.gif"><?php }?></td>
		</tr>
		<tr>
			<td><?php echo L('avatar')?></td> 
			<td><img src="<?php echo $memberinfo['avatar']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=90 width=90><input type="checkbox" name="delavatar" id="delavatar" class="input-text" value="1" ><label for="delavatar"><?php echo L('delete').L('avatar')?></label></td>
		</tr>
		<tr>
			<td><?php echo L('password')?></td> 
			<td><input type="password" name="info[password]" id="password" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('cofirmpwd')?></td> 
			<td><input type="password" name="info[pwdconfirm]" id="pwdconfirm" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('nickname')?></td> 
			<td><input type="text" name="info[nickname]" id="nickname" value="<?php echo $memberinfo['nickname']?>" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('email')?></td>
			<td>
			<input type="text" name="info[email]" value="<?php echo $memberinfo['email']?>" class="input-text" id="email" size="30"></input>
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
			<?php echo form::select($grouplist, $memberinfo['groupid'], 'name="info[groupid]"', '');?> <div class="onShow"><?php echo L('changegroup_notice')?></div>
			</td>
		</tr>
		<tr>
			<td><?php echo L('point')?></td>
			<td>
			<input type="text" name="info[point]" value="<?php echo $memberinfo['point']?>" class="input-text" id="point" size="10"></input>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_model')?></td>
			<td>
			<?php echo form::select($modellist, $modelid, 'name="info[modelid]" onchange="changemodel($(this).val())"', '');?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('vip')?></td>
			<td>
			<?php echo L('isvip')?> <input type="checkbox" name="info[vip]" value=1 <?php if($memberinfo['vip']){?>checked<?php }?>/>
			<?php echo L('overduedate')?> <?php echo $form_overdudate?>
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('more_configuration')?></legend>
	<table width="100%" class="table_form">
	<?php foreach($forminfos as $k=>$v) {?>
		<tr>
			<td width="80"><?php echo $v['name']?></td> 
			<td><?php echo $v['form']?></td>
		</tr>
	<?php }?>
	</table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
<script language="JavaScript">
<!--
	function changemodel(modelid) {
		redirect('?m=member&c=member&a=edit&userid=<?php echo $memberinfo[userid]?>&modelid='+modelid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>');
	}
//-->
</script>
</html>