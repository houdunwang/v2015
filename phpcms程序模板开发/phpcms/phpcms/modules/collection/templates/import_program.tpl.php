<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<fieldset>
	<legend><?php echo L('the_new_publication_solutions')?></legend>
	<form name="myform" action="?" method="get" id="myform">
	
		<table width="100%" class="table_form">
			<tr>
			<td width="120"><?php echo L('category')?>：</td> 
			<td>
			<?php echo form::select_category('', '', 'name="catid"', L('please_choose'), 0, 0, 1)?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="m" value="collection">
	<input type="hidden" name="c" value="node">
	<input type="hidden" name="a" value="import_program_add">
	<input type="hidden" name="nodeid" value="<?php if(isset($nodeid)) echo $nodeid?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
	<input type="hidden" name="ids" value="<?php echo $ids?>">
	<input type="submit" id="dosubmit"  class="button" value="<?php echo L('submit')?>">
	</form>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('publish_the_list')?></legend>
<form name="myform" action="?" method="get" >
<div class="bk15"></div>
<?php
	foreach($program_list as $k=>$v) {
		echo form::radio(array($v['id']=>$cat[$v['catid']]['catname']), '', 'name="programid"', 150);
?>
<span style="margin-right:10px;"><a href="?m=collection&c=node&a=import_program_del&id=<?php echo $v['id']?>" style="color:#ccc"><?php echo L('delete')?></a></span>
<?php
	}

?>
</fieldset>
	<input type="hidden" name="m" value="collection">
	<input type="hidden" name="c" value="node">
	<input type="hidden" name="a" value="import_content">
	<input type="hidden" name="nodeid" value="<?php if(isset($nodeid)) echo $nodeid?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
	<input type="hidden" name="ids" value="<?php echo $ids?>">
<div class="btn">
<label for="check_box"><input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>"/>
</div>

</div>
</form>
</div>
<script type="text/javascript">
<!--
window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>