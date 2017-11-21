<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('credit_manage');
include $this->admin_tpl('header');
?>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('credit_add')?></h2>
	<div class="content-menu ib-a blue line-x">
		<a href="?m=admin&c=credit&a=manage">
		<em><?php echo L('credit_manage')?></em></a>
		<span>|</span>
		<a href="?m=admin&c=credit&a=add" class="on">
		<em><?php echo L('credit_add')?></em></a>
	</div>
</div>
<div class="pad-lr-10">
<form method=post action="?m=admin&c=credit&a=add">
<table width="100%"  class="table_form">
	<tr>
	<th width="80" ><?php echo L('change_position')?>：</th>
	<td class="y-bg">
		<select name="fromid" style="width:160px" onchange="showcredit('from', this.value)">
			<option value='0' ><?php echo L('pleace_select')?></option>
			<?php foreach($applist as $v) {?>
			<option value='<?php echo $v['appid']?>' ><?php echo $v['name']?></option>
			<?php }?>
		</select>
		<span id="from"></span>
		>
		<select name="toid" style="width:160px" onchange="showcredit('to', this.value)">
			<option value='0' ><?php echo L('pleace_select')?></option>
			<?php foreach($applist as $v) {?>
			<option value='<?php echo $v['appid']?>' ><?php echo $v['name']?></option>
			<?php }?>
		</select>
		<span id="to"></span>
		</td>
	</tr>
	<tr>
	<th><?php echo L('change_rate')?>：</th>
	<td class="y-bg"><input type="text" class="input-text" name="fromrate" value="" /> :
		<input type="text" class="input-text" name="torate" value="" /></td>
	</tr>
</table>

<div class="bk15"></div>
   <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />

</form>
</div>
<script language="JavaScript">
<!--
	function showcredit(pos, val) {
		$.post('?m=admin&c=credit&a=creditlist&appid='+val+'&'+Math.random(),function(data){
			$("#"+pos+"").html("<select name="+pos+">"+data+"</select>");
		});
	}
//-->
</script>
</body>
</html>