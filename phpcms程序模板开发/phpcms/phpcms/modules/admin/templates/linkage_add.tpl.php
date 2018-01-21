<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('linkage_name')?>",onfocus:"<?php echo L('linkage_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('linkage_name').L('not_empty')?>"});
  })
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=linkage&a=add" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td><?php echo L('linkage_name')?></td>
<td>
<input type="text" name="info[name]" value="<?php echo $name?>" class="input-text" id="name" size="30"></input>
</td>
</tr>

<tr>
<td><?php echo L('menu_description')?></td>
<td>
<textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:45px;width:300px;"><?php echo $description?></textarea>
</td>
</tr>

<tr>
<td><?php echo L('menu_style')?></td>
<td>
<input name="info[style]" value="0" checked="checked" type="radio">&nbsp;<?php echo L('drop_down_style')?>&nbsp;&nbsp;<input name="info[style]" value="1" type="radio">&nbsp;<?php echo L('pop_style')?>
</td>
</tr>

<tr>
<td><?php echo L('sites')?></td>
<td>
<?php echo form::select($sitelist,'','name="info[siteid]"',L('all_sites'))?>
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
