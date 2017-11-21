<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<div class="table-list">

<div class="explain-col">
<?php echo L('upgrade_notice');?>
</div>
<div class="bk15"></div>

<form name="myform" action="" method="get" id="myform">
<input type="hidden" name="s" value="1" />
<input type="hidden" name="cover" value="<?php echo $_GET['cover']?>" />
<input name="m" value="upgrade" type="hidden" />
<input name="c" value="index" type="hidden" />
<input name="a" value="init" type="hidden" />
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="300"><?php echo L('currentversion')?><?php if(empty($pathlist)) {?><?php echo L('lastversion')?><?php }?></th>
			<th align="left"><?php echo L('updatetime')?></th>
		</tr>
	</thead>
<tbody>
    <tr>
		<td align="left"><?php echo $current_version['pc_version'];?></td>
		<td align="left"><?php echo $current_version['pc_release'];?></td>
    </tr>

</tbody>
</table>
<?php if(!empty($pathlist)) {?>
<div class="bk15"></div>
<table width="100%" cellspacing="0">
<thead>
	<tr>
		<th align="left" width="300"><?php echo L('updatelist')?></th>
		<th align="left"><?php echo L('updatetime')?></th>
	</tr>
</thead>
<tbody>
	<?php foreach($pathlist as $v) { ?>
	<tr>
		<td><?php echo $v;?></td>
		<td><?php echo substr($v, 15, 8);?></td>
	</tr>
	<?php }?>
</tbody>
</table>
    <div class="bk15"></div>
	<label for="cover"><font color="red"><?php echo L('covertemplate')?></font></label><input name="cover" id="cover" type="checkbox" value=1>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('begin_upgrade')?>" class="button">
<?php }?>
</form>
</div>
</div>
</body>
</html>