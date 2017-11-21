<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<form method="post" action="?m=poster&c=space&a=setting" id="myform" name="myform">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form">
	<tr>
		<th width="130"><?php echo L('ads_show_time')?></th>
		<td><input type='radio' name='setting[enablehits]' value='1' <?php if($enablehits == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablehits]' value='0' <?php if($enablehits == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('upload_file_ext')?>：</th>
		<td><input name='setting[ext]' type='text' id='ext' value='<?php echo $ext?>' size='40' maxlength='70'></td>
	</tr>
	<tr>
		<th><?php echo L('file_size')?>：</th>
		<td><input name='setting[maxsize]' type='text' id='maxsize' value='<?php echo $maxsize?>' size='12'> M</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('ok')?> ">&nbsp;<input type="reset" class="dialog" value=" <?php echo L('clear')?> "></td>
	</tr>
</table>
</form>
</body>
</html>
