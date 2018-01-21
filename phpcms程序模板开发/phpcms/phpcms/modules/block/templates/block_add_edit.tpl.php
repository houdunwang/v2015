<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'})}});
		$("#name").formValidator({onshow:"<?php echo L('input').L('name')?>",onfocus:"<?php echo L('input').L('name')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('name')?>"}).ajaxValidator({type : "get",url : "",data :"m=block&c=block_admin&a=public_name&id=<?php if(isset($id) && !empty($id))echo $id;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('name').L('exists')?>",onwait : "<?php echo L('connecting')?>"})<?php if(ROUTE_A=='edit')echo '.defaultPassed()';?>;


	})
//-->
</script>
<div class="pad-10">
<form action="?m=block&c=block_admin&a=<?php echo ROUTE_A?>&pos=<?php echo $_GET['pos']?>&id=<?php if(isset($id) && !empty($id))echo $id;?>" method="post" id="myform">
<div>
<fieldset>
	<legend><?php echo L('block_configuration')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="80"><?php echo L('name')?>：</th>
    <td class="y-bg"><input type="text" name="name" id="name" size="30" value="<?php echo isset($data['name']) ?  $data['name'] : '';?>" /></td>
  	</tr>
    <tr>
    <th width="80"><?php echo L('display_position')?>：</th>
    <td class="y-bg"> <?php echo isset($data['pos']) ?  $data['pos'] : $_GET['pos'];?></td>
  	</tr>
  	<tr>
    <th width="80"><?php echo L('type')?>：</th>
    <td class="y-bg"><?php echo form::radio(array('1'=>L('code'), '2'=>L('table_style')), (isset($data['type']) ? $data['type'] : 1), 'name="type"'.(ROUTE_A=='edit' ? ' disabled = "disabled"' : ''))?></td>
  	</tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('permission_configuration')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="80"><?php echo L('role')?>：</th>
    <td class="y-bg"><?php echo form::checkbox($administrator, (isset($priv_list) ? implode(',', $priv_list) : ''), 'name="priv[]"')?></td>
  	</tr>
</table>
</fieldset>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="" />
</div>
</div>
</form>
</body>
</html>