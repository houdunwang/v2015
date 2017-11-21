<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'})}});
		$("#name").formValidator({onshow:"<?php echo L('input').L('name')?>",onfocus:"<?php echo L('input').L('name')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('name')?>"}).ajaxValidator({type : "get",url : "",data :"m=dbsource&c=data&a=public_name&id=<?php echo $id?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed();


		$("#cache").formValidator({onshow:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",onfocus:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L("cache_time_can_only_be_positive")?>"});
		$("#num").formValidator({onshow:"<?php echo L('input').L("num")?>",onfocus:"<?php echo L('input').L("num")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L('that_shows_only_positive_numbers')?>"});
	})
//-->
</script>
<div class="pad-10">
<form action="?m=dbsource&c=data&a=edit&id=<?php echo $id?>" method="post" id="myform">
<div>
<fieldset>
	<legend><?php echo L('the_configuration_data_source')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="80"><?php echo L('stdcall')?>：</th>
    <td class="y-bg"><?php echo form::radio(array('0'=>L('model_configuration'), '1'=>L('custom_sql')), $type ? $type : 0, 'name="type" onclick="location.href=\''.get_url().'&type=\'+this.value"')?></td>
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
    <td class="y-bg"><?php echo creat_form($k, $v, $form_data[$k])?></td>
  </tr>
  <?php endforeach;?>
  <?php else :?>
    <tr>
    <th valign="top"><?php echo L('custom_sql')?>：</th>
    <td class="y-bg"><textarea name="data" id="data" style="width:386px;height:178px;"><?php if($edit_data['type']==1)echo $edit_data['data']?></textarea><script type="text/javascript">$(function(){$("#data").formValidator({onshow:"<?php echo L('please_enter_a_sql')?>",onfocus:"<?php echo L('please_enter_a_sql')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_enter_a_sql')?>'});});</script></td>
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
    <td class="y-bg"><input type="text" class="input-text" name="name" id="name" size="30" value="<?php echo new_html_special_chars($edit_data['name'])?>" /></td>
  </tr>
  <tr>
    <th><?php echo L('output_mode')?>：</th>
    <td class="y-bg"><?php echo form::radio(array('1'=>'json', '2'=>'xml', '3'=>'js'), $edit_data['dis_type'], 'name="dis_type" onclick="showcode(this.value)"')?></td>
  </tr>
  <tbody id="template_code" <?php if($edit_data['dis_type'] != 3) echo 'style="display:none"'?>>
    <tr>
    <th valign="top"><?php echo L('template')?>：</th>
    <td class="y-bg"><textarea name="template" id="template" style="width:386px;height:178px;"><?php if(!empty($edit_data['template'])) { echo $edit_data['template'];} else {echo '{loop $data $k $v}
    <!-- '.L('valgrind').' -->
{/loop}';}?></textarea></td>
  </tr>
  </tbody>
  <tr>
    <th width="80"><?php echo L('buffer_time')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="cache" id="cache" size="30" value="<?php echo $edit_data['cache']?>"  /></td>
  </tr>
  <tr>
    <th width="80"><?php echo L('num')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="num" id="num" size="30" value="<?php echo $edit_data['num']?>"  /></td>
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