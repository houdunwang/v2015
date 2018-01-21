<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#title").formValidator({onshow:"<?php echo L('input').L('posid_title')?>",onfocus:"<?php echo L('posid_title').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('posid_title').L('not_empty')?>"});
	$("#url").formValidator({onshow:"<?php echo L('input').L('posid_url')?>",onfocus:"<?php echo L('posid_url').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('posid_url').L('not_empty')?>"});	
})
//-->
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=position&a=public_item_manage" method="post" id="myform">
<input type="hidden" name="posid" value="<?php echo $posid?>"></input>
<input type="hidden" name="modelid" value="<?php echo $modelid?>"></input>
<input type="hidden" name="id" value="<?php echo $id?>"></input>
<table width="100%" class="table_form">
<tr>
<td  width="100"><?php echo L('posid_title')?></td> 
<td><input type="text" name="info[title]" class="input-text" value="<?php echo $title?>" id="title" size="40"></input></td>
</tr>
<tr>
<td><?php echo L('posid_thumb')?></td> 
<td><?php echo form::images('info[thumb]','thumb',$thumb,'content')?> </td>
</tr>
<tr>
<td><?php echo L('posid_inputtime')?></td> 
<td><?php echo form::date('info[inputtime]', date('Y-m-d h:i:s',$inputtime), 1)?></td>
</tr>

<tr>
<td><?php echo L('posid_desc')?></td> 
<td>
<textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"><?php echo $description?></textarea>
</td>
</tr>
<tr>
<td><?php echo L('posid_syn')?></td> 
<td>
<input name="synedit"  value="0" type="radio" <?php echo $synedit==0 ? 'checked="checked"' : ''?>> <?php echo L('enable')?><input name="synedit" value="1" type="radio" <?php echo $synedit==1 ? 'checked="checked"' : ''?>> <?php echo L('close')?>        
</td>
</tr>

</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>


