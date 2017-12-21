<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('system_setting');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('system_setting')?></h2>
	<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=system&a=init" class="on"><em><?php echo L('register_setting')?></em></a><span>|</span> <a href="?m=admin&c=system&a=uc"><em><?php echo L('uc_setting')?></em></a><span>|</span><a href="?m=admin&c=system&a=sp4"><em><?php echo L('sp4_password_compatible')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=system&a=init" method="post" name="form_messagequeue_manage">
	<table width="100%" cellspacing="0" class="table_form">
	<tbody>
		<tr>
			<th width="120"><?php echo L('denyed_username')?></th>
			<td>
			<textarea name="denyusername" style="height:160px; width:30%"><?php foreach($setting['denyusername'] as $v) {?><?php echo $v."\r\n";?><?php }?></textarea><?php echo L('denyed_username_setting')?></td>
		</tr>

		<tr>
			<th><?php echo L('denyed_email')?></th>
			<td>
			<textarea name="denyemail" style="height:160px; width:30%"><?php foreach($setting['denyemail'] as $v) {?><?php echo $v."\r\n";?><?php }?></textarea><?php echo L('denyed_email_setting')?></td>
		</tr>

	</tbody>
	</table>
    <div class="bk15"></div>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>

</body>
</html>