<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<form method="post" action="?m=vote&c=vote&a=setting">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form">
 
	<tr>
		<th width="200"><?php echo L('vote_style')?>：</th>
		<td>
		<?php echo form::select($template_list, $default_style, 'name="setting[default_style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?>
		 </td>
	</tr>
	
	<tr>
		<th><?php echo L('template')?>：</th>
		<td id="show_template">
		<?php echo form::select_template($default_style, 'vote', $vote_tp_template, 'name="setting[vote_tp_template]"', 'vote_tp');?>
		</td>
	</tr>
	
	<tr>
		<th><?php echo L('default_guest')?>：</th>
		<td><input type='radio' name='setting[allowguest]' value='1' <?php if($allowguest == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowguest]' value='0' <?php if($allowguest == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('default_enabled')?>：</th>
		<td><input type='radio' name='setting[enabled]' value='1' <?php if($enabled == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enabled]' value='0' <?php if($enabled == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('interval')?>：</th>
		<td>
		<input type="text" name="setting[interval]" value="<?php echo $interval;?>" size='5' /> <?php echo L('more_ip')?>，<font color=red>0</font> <?php echo L('one_ip')?>
		</td>
	</tr>
	<tr>
		<th><?php echo L('credit')?>：</th>
		<td>
		<input type="text" name="setting[credit]" value="<?php echo $credit?>" size='5' />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('confirm')?>" class="button">&nbsp;<input type="reset" value=" <?php echo L('reset')?> " class="button"></td>
	</tr>
</table>
</form>
</body>
</html>
<script language="javascript">
function load_file_list(id) {
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=vote&templates=vote_tp&name=setting&pc_hash='+pc_hash, function(data){$('#show_template').html(data.vote_tp_template);});
}
</script>