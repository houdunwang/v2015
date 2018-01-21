<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L('input').L('name')?>",onfocus:"<?php echo L('input').L('name')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('name')?>"}).ajaxValidator({type : "get",url : "",data :"m=tag&c=tag&a=public_name",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('name').L('exists')?>",onwait : "<?php echo L('connecting')?>"});
		$("#cache").formValidator({onshow:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",onfocus:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L("cache_time_can_only_be_positive")?>"});
		$("#num").formValidator({onshow:"<?php echo L('input').L("num")?>",onfocus:"<?php echo L('input').L("num")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L('that_shows_only_positive_numbers')?>"});
		$("#return").formValidator({onshow:"<?php echo L('return_value')?>",onfocus:"<?php echo L('return_value')?>",empty:true});
		show_action('position');
	})
	
	function show_action(obj) {
		$('.pc_action_list').hide();
		$('#action_'+obj).show();
	}
//-->
</script>

<div class="pad-10">
<form action="?m=tag&c=tag&a=add&ac=<?php echo $ac?>" method="post" id="myform">
<div>
<fieldset>
	<legend><?php echo L('tag_call_setting')?></legend>
	<table width="100%"  class="table_form">
    <tr>
		<th width="80"><?php echo L('stdcall')?>：</th>
		<td class="y-bg"><?php echo form::radio(array('0'=>L('model_configuration'), '1'=>L('custom_sql'), '2'=> L('block')), $type ? $type : 0, 'name="type" onclick="location.href=\''.get_url().'&type=\'+this.value"')?></td>
	</tr>
  <?php if ($type==0) :?>
    <tr>
		<th><?php echo L('select_model')?>：</th>
		<td class="y-bg"><?php echo form::select($modules, $module, 'name="module" id="module" onchange="location.href=\''.get_url().'&module=\'+this.value"')?><script type="text/javascript">$(function(){$("#module").formValidator({onshow:"<?php echo L('please_select_model')?>",onfocus:"<?php echo L('please_select_model')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_select_model')?>'});});</script></td>
	</tr>
  <?php if ($module):?>
    <tr>
		<th><?php echo L('selectingoperation')?>：</th>
		<td class="y-bg"><?php echo form::radio($html['action'], $action, 'name="action" onclick="location.href=\''.get_url().'&action=\'+this.value"')?></td>
	  </tr>
	  <?php endif;?>
	  <?php if(isset($html[$action]) && is_array($html[$action]) && $action)foreach($html[$action] as $k=>$v):?>
		  <tr>
		<th><?php echo $v['name']?>：</th>
		<td class="y-bg"><?php echo creat_form($k, $v, '', $module)?></td>
	</tr>
	<?php if(isset($v['ajax']['name'])  && !empty($v['ajax']['name'])) {?>
  	  <tr>
  	  	<th width="80"><?php echo $v['ajax']['name']?>：<?php if(isset($_GET[$v['ajax']['id']]) && !empty($_GET[$v['ajax']['id']])) echo '<script type="text/javascript">$.get(\'?m=template&c=file&a=public_ajax_get\', { html: \''.$_GET[$k].'\', id:\''.$v['ajax']['id'].'\', value:\''.$_GET[$v['ajax']['id']].'\', action: \''.$v['ajax']['action'].'\', op: \''.$module.'\', style: \'default\'}, function(data) {$(\'#'.$k.'_td\').html(data)});</script>'?></th>
  	  	<td class="y-bg"><input type="text" size="20" value="<?php echo $_GET[$v['ajax']['id']]?>" id="<?php echo $v['ajax']['id']?>" name="<?php echo $v['ajax']['id']?>" class="input-text"><span id="<?php echo $k?>_td"></span></td>
  	 </tr>
  <?php }?>
  <?php endforeach;?>
  <?php elseif ($type==1) :?>
    <tr>
		<th valign="top"><?php echo L('custom_sql')?>：</th>
		<td class="y-bg"><textarea name="data" id="data" style="width:386px;height:178px;"></textarea><script type="text/javascript">$(function(){$("#data").formValidator({onshow:"<?php echo L('please_enter_a_sql')?>",onfocus:"<?php echo L('please_enter_a_sql')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_enter_a_sql')?>'});});</script></td>
  </tr>
  <tr>
		<th valign="top"><?php echo L('over_dbsource')?>：</th>
		<td class="y-bg"><?php echo form::select($dbsource, $db_source, 'name="dbsource" id="dbsource" ')?><script type="text/javascript">$(function(){$("#dbsource").formValidator({onshow:"<?php echo L('please_select_dbsource')?>",onfocus:"<?php echo L('please_select_dbsource')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_select_dbsource')?>'});});</script></td>
  </tr>
  <?php else :?>
  <tr>
		<th valign="top"><?php echo L('block').L('name')?>：</th>
		<td class="y-bg"><input type="text" name="block" size="25" id="block"><script type="text/javascript">$(function(){$("#block").formValidator({onshow:"<?php echo L('please_input_block_name')?>",onfocus:"<?php echo L('please_input_block_name')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_input_block_name')?>'});});</script></td>
  </tr>
  <?php endif;?>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('vlan')?></legend>
	<table width="100%"  class="table_form">
	<tr>
		<th width="80"><?php echo L('name')?>：</th>
		<td class="y-bg"><input type="text" class="input-text" name="name" id="name" size="30" /></td>
	</tr>
	<tr>
		<th width="80"><?php echo L('ispage')?>：</th>
		<td class="y-bg"><input type="text" name="page" value="" id='page'/> <?php echo L('common_variables')?>:<a href="javascript:void(0);" onclick="javascript:$('#page').val('$_GET[page]');"><font color="red">$_GET[page]</font></a>、<a href="javascript:void(0);" onclick="javascript:$('#page').val('$page');"><font color="red">$page</font></a>，<?php echo L('no_input_no_page')?></td>
	</tr>
    <tr>
		<th width="80"><?php echo L('num')?>：</th>
		<td class="y-bg"><input type="text" name="num" id="num" size="30" /></td>
	</tr>
	<tr>
		<th width="80"><?php echo L('data_return')?>：</th>
		<td class="y-bg"><input type="text" name="return" id="return" size="30" value="" /> </td>
	</tr>
	<tr>
		<th width="80"><?php echo L('cache_times')?>：</th>
		<td class="y-bg"><input type="text" name="cache" id="cache" size="30" value="" /> </td>
	</tr>

</table>
</fieldset>
<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="" />
</div>
</div>
</form>
<script type="text/javascript">
<!--
	function showcode(obj) {
	if (obj==3){
		$('#template_code').show();
	} else {
		$('#template_code').hide();
	}
}
//-->
</script>
</body>
</html>