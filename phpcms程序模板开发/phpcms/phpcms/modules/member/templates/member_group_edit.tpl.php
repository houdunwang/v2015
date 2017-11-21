<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('groupname')?>",onfocus:"<?php echo L('groupname').L('between_2_to_8')?>"}).inputValidator({min:2,max:15,onerror:"<?php echo L('groupname').L('between_2_to_8')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('groupname').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member_group&a=public_checkname_ajax",
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
		onerror : "<?php echo L('groupname_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
	$("#group_point").formValidator({tipid:"pointtip",onshow:"<?php echo L('input').L('point')?>",onfocus:"<?php echo L('point').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('point').L('between_1_to_8_num')?>"});
	$("#group_starnum").formValidator({tipid:"starnumtip",onshow:"<?php echo L('input').L('starnum')?>",onfocus:"<?php echo L('starnum').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('starnum').L('between_1_to_8_num')?>"});
	$("#maxmessagenum").formValidator({tipid:"maxmessagenumtip",onshow:"<?php echo L('input').L('maxmessagenum')?>",onfocus:"<?php echo L('maxmessagenum').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('maxmessagenum').L('between_1_to_8_num')?>"});
	$("#allowpostnum").formValidator({tipid:"allowpostnumip",onshow:"<?php echo L('input').L('allowpostnum')?>",onfocus:"<?php echo L('allowpostnum').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('allowpostnum').L('between_1_to_8_num')?>"});

});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member_group&a=edit" method="post" id="myform">
<input type="hidden" name="info[groupid]"value="<?php echo $groupinfo['groupid']?>">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('member_group_name')?></td> 
			<td><?php if(in_array($groupid, array(1,7,8))) { echo $groupinfo['name'];} else {?><input type="text" name="info[name]"  class="input-text" id="name" value="<?php echo $groupinfo['name']?>"><?php }?></td>
		</tr>
		<tr>
			<td><?php echo L('member_group_creditrange')?></td> 
			<td>
			<input type="text" name="info[point]" class="input-text" id="group_point" value="<?php echo $groupinfo['point']?>" size="6"></td>
		</tr>
		<tr>
			<td><?php echo L('member_group_starnum')?></td> 
			<td><input type="text" name="info[starnum]" class="input-text" id="group_starnum" value="<?php echo $groupinfo['starnum']?>"  size="6"></td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('more_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td><?php echo L('member_group_permission')?></td> 
			<td>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowpost]" <?php if($groupinfo['allowpost']){?>checked<?php }?> />
					<?php echo L('member_group_publish')?>
				</span>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowpostverify]" <?php if($groupinfo['allowpostverify']){?>checked<?php }?>>
					<?php echo L('member_group_publish_verify')?>
				</span>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowupgrade]" <?php if($groupinfo['allowupgrade']){?>checked<?php }?> />
					<?php echo L('member_group_upgrade')?> 
				</span>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowsendmessage]" <?php if($groupinfo['allowsendmessage']){?>checked<?php }?>>
					<?php echo L('member_group_sendmessage')?> 
				</span>
				<?php
				if($groupinfo['groupid']!=8) {?>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowattachment]" <?php if($groupinfo['allowattachment']){?>checked<?php }?>>
					<?php echo L('allowattachment')?> 
				</span>
				<?php }?>
				<span class="ik lf" style="width:120px;">
					<input type="checkbox" name="info[allowsearch]" <?php if($groupinfo['allowsearch']){?>checked<?php }?>>
					<?php echo L('allowsearch')?> 
				</span>
			</td>

		</tr>

		<tr>
			<td width="80"><?php echo L('member_group_upgradeprice')?></td> 
			<td>
				<span class="ik lf" style="width:120px;">
					<?php echo L('member_group_dayprice')?>：
					<input type="text" name="info[price_d]" class="input-text" value="<?php echo $groupinfo['price_d']?>" size="6">	
				</span>
				<span class="ik lf" style="width:120px;">
					<?php echo L('member_group_monthprice')?>：
					<input type="text" name="info[price_m]" class="input-text" value="<?php echo $groupinfo['price_m']?>" size="6">
				</span>
				<span class="ik lf" style="width:120px;">
					<?php echo L('member_group_yearprice')?>：
					<input type="text" name="info[price_y]" class="input-text" value="<?php echo $groupinfo['price_y']?>" size="6">
				</span>
			</td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_maxmessagenum')?></td> 
			<td><input type="text" name="info[allowmessage]" class="input-text" id="maxmessagenum" value="<?php echo $groupinfo['allowmessage']?>" size="8"></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_username_color')?></td> 
			<td><input type="text" name="info[usernamecolor]" class="input-text" id="usernamecolor" size="8" value="<?php echo $groupinfo['usernamecolor']?>" ></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('allowpostnum')?></td> 
			<td><input type="text" name="info[allowpostnum]" class="input-text" id="allowpostnum" size="8" value="<?php echo $groupinfo['allowpostnum']?>"> <?php echo L('zero_nolimit')?></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_icon')?></td> 
			<td><input type="text" name="info[icon]" class="input-text" id="icon" value="<?php echo $groupinfo['icon']?>" size="40"></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_description')?></td> 
			<td><input type="text" name="info[description]" class="input-text" value="<?php echo $groupinfo['description']?>" size="60"></td>
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