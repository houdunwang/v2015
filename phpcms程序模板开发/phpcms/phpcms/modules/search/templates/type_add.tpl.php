<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L("input").L('type_name')?>",onfocus:"<?php echo L("input").L('type_name')?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('type_name')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('type_name').L('format_incorrect', '','member')?>"});
	})
//-->
</script>
<div class="pad-lr-10">
<form action="?m=search&c=search_type&a=add" method="post" id="myform">
	<table width="100%"  class="table_form">
	<tr>
    <th width="120"><?php echo L('select_module_name')?>：</th>
    <td class="y-bg"><?php echo form::select($module_data,$_GET['module'],'name="module" onchange="change_module(this.value)"')?></td>
  </tr>
  <?php if($_GET['module'] == 'content') {?>
  <tr id="modelid_display">
    <th width="120"><?php echo L('select_model_name')?>：</th>
    <td class="y-bg"><?php echo form::select($model_data,'','name="info[modelid]"')?></td>
  </tr>
  <?php }?>
  <?php if($_GET['module'] == 'yp') {?>
  <tr id="yp_modelid_display">
    <th width="120"><?php echo L('select_model_name')?>：</th>
    <td class="y-bg"><?php echo form::select($yp_model_data,'','name="info[yp_modelid]"')?></td>
  </tr>
  <?php }?>
  <tr>
    <th width="120"><?php echo L('type_name')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="info[name]" id="name" size="30" /></td>
  </tr>
    <tr>
    <th><?php echo L('description')?>：</th>
    <td class="y-bg"><textarea name="info[description]" maxlength="255" style="width:300px;height:60px;"></textarea></td>
  </tr>
</table>

<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function change_module(module) {
		redirect('?m=search&c=search_type&a=add&module='+module+'&pc_hash=<?php echo $_SESSION['pc_hash']?>');
}
//-->
</SCRIPT>
</body>
</html>