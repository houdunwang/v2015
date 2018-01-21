<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('system_setting');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('system_setting')?></h2>
	<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=system&a=init"><em><?php echo L('register_setting')?></em></a><span>|</span> <a href="?m=admin&c=system&a=uc"><em><?php echo L('uc_setting')?></em></a><span>|</span><a href="?m=admin&c=system&a=sp4" class="on"><em><?php echo L('sp4_password_compatible')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=system&a=sp4" method="post" name="form_messagequeue_manage">
	<table width="100%" cellspacing="0" class="table_form">
	<tbody>
		<tr>
			<td colspan="2">
			<?php echo L('sp4_password_compatible')?></td>
		</tr>
		<tr>
			<th width="140"><?php echo L('enable')?></th>
			<td>
			<input type="radio" name="sp4use" value="1" <?php if(isset($data['sp4use']) && $data['sp4use']==1){echo 'checked';}?>/> <?php echo L('yes')?> <input type="radio" name="sp4use" value="0" <?php if(!isset($data['sp4use']) || !$data['sp4use']){echo 'checked';}?> /> <?php echo L('no')?></td>
		</tr>
		<tr>
			<th width="140">PASSWORD_KEY</th>
			<td>
			<input type="text" class="input-text" name="sp4_password_key" id="sp4_password_key" value="<?php if(isset($data['sp4_password_key'])){echo $data['sp4_password_key'];}?>" /><?php echo L('sp4_password_key')?></td>
		</tr>
	</tbody>
	</table>
    <div class="bk15"></div>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>

</body>
</html>