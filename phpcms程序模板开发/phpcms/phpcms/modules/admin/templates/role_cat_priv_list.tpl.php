<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>

<form action="?m=admin&c=role&a=setting_cat_priv&roleid=<?php echo $roleid?>&siteid=<?php echo $siteid?>&op=2" method="post">
<div class="table-list" id="load_priv">
<table width="100%" class="table-list">
			  <thead>
				<tr>
				  <th width="25"><?php echo L('select_all')?></th><th align="left"><?php echo L('title_varchar')?></th><th width="25"><?php echo L('view')?></th><th width="25"><?php echo L('add')?></th><th width="25"><?php echo L('edit')?></th><th width="25"><?php echo L('delete')?></th><th width="25"><?php echo L('sort')?></th><th width="25"><?php echo L('push')?></th><th width="25"><?php echo L('move')?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php echo $categorys?>
			 </tbody>
			</table>
<div class="btn">
<input type="submit" value="<?php echo L('submit')?>" class="button">
</div>
</div>
</form>
<script type="text/javascript">
<!--
function select_all(name, obj) {
	if (obj.checked) {
		$("input[type='checkbox'][name='priv["+name+"][]']").attr('checked', 'checked');
	} else {
		$("input[type='checkbox'][name='priv["+name+"][]']").removeAttr('checked');
	}
}
//-->
</script>
</body>
</html>
