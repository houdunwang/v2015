<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});

	$("#modelname").formValidator({onshow:"<?php echo L('input').L('model_name')?>",onfocus:"<?php echo L('model_name').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('model_name').L('between_2_to_20')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('model_name').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member_model&a=public_checkmodelname_ajax&oldmodelname=<?php echo $modelinfo['name']?>",
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
		onerror : "<?php echo L('modelname_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member_model&a=edit" method="post" id="myform">
<input type="hidden" name="info[modelid]" value="<?php echo $_GET['modelid']?>">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('model_name')?></td> 
			<td><input type="text" name="info[modelname]"  class="input-text" id="modelname" size="30" value="<?php echo $modelinfo['name']?>"></input></td>
		</tr>
		<tr>
			<td><?php echo L('table_name')?></td>
			<td>
			<?php echo $this->db->db_tablepre.$modelinfo['tablename']?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('model_description')?></td>
			<td>
			<input type="text" name="info[description]" value="<?php echo $modelinfo['description']?>" class="input-text" id="description" size="80"></input>
			</td>
		</tr>
		<tr>
			<td><?php echo L('deny_model')?></td>
			<td>
				<input type="checkbox" value="1" name="info[disabled]" <?php if($modelinfo['disabled']) {?>checked<?php }?>>
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