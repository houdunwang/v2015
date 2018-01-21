<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$('#groupid').formValidator({onshow:"<?php echo L('please_select').L('member_group');?>",onfocus:"<?php echo L('please_select').L('member_group');?>",defaultvalue:"0"}).inputValidator({min:1,onerror:"<?php echo L('please_select').L('member_group');?>"});
  });
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=move" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('username')?></td> 
			<td>
				<?php foreach($userarr as $v) {?>
					<input type="checkbox" name="userid[]" value="<?php echo $v['userid']?>" checked />
					<?php echo $v['username']?> 
				<?php }?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td> 
			<td>
				<?php echo form::select($grouplist, $_GET['groupid'], 'id="groupid" name="groupid"', L('please_select'))?>
			</td>
		</tr>
	</table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
</html>