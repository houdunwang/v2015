<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#rolename").formValidator({onshow:"<?php echo L('input').L('role_name')?>",onfocus:"<?php echo L('role_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('role_name').L('not_empty')?>"});
})
//-->
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=role&a=edit" method="post" id="myform">
<input type="hidden" name="roleid" value="<?php echo $roleid?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td><?php echo L('role_name')?></td> 
<td><input type="text" name="info[rolename]" value="<?php echo $rolename?>" class="input-text" id="rolename"></input></td>
</tr>
<tr>
<td><?php echo L('role_description')?></td>
<td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:500px;"><?php echo $description?></textarea></td>
</tr>
<tr>
<td><?php echo L('enabled')?></td>
<td><input type="radio" name="info[disabled]" value="0" <?php echo ($disabled=='0')?' checked':''?>> <?php echo L('enable')?>  <label><input type="radio" name="info[disabled]" value="1" <?php echo ($disabled=='1')?' checked':''?>><?php echo L('ban')?></td>
</tr>
<tr>
<td><?php echo L('listorder')?></td>
<td><input type="text" name="info[listorder]" size="3" value="<?php echo $listorder?>" class="input-text"></input></td>
</tr>
</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</form>
</div>
</div>
</body>
</html>


