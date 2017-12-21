<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php 
$page_title = L('modification_succeed');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password_len_error')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"});
})
//-->
</script>
<div class="subnav">
<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('admin_manage')?></h2>
<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=administrator&a=init"><em><?php echo L('listadmins')?></em></a><span>|</span> <a href="?m=admin&c=administrator&a=add"><em><?php echo L('add_admin')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=administrator&a=edit&id=<?php echo $id?>" method="post" id="myform">
<table width="100%"  class="table_form">
<tr>
<th width="80" ><?php echo L('username')?>：</th>
<td class="y-bg"><?php echo $data['username']?></td>
</tr>
<tr>
<th><?php echo L('password')?>：</th>
<td class="y-bg"><input type="password" class="input-text" name="password" value="" id="password" /></td>
</tr>
<tr>
<th><?php echo L('subminiature_tube')?>：</th>
<td class="y-bg"><input type="checkbox" name="issuper" value="1" <?php if ($data['issuper']) {echo 'checked';}?> /> <?php echo L('yes')?></td>
</tr>
</table>
<div class="bk15"></div>
	<input type="hidden" name="admin_manage_code" value="<?php echo $admin_manage_code?>" id="admin_manage_code"></input>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>

</body>
</html>