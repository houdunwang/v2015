<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('system_setting');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('system_setting')?></h2>
	<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=system&a=init"><em><?php echo L('register_setting')?></em></a><span>|</span> <a href="?m=admin&c=system&a=uc"  class="on"><em><?php echo L('uc_setting')?></em></a><span>|</span><a href="?m=admin&c=system&a=sp4"><em><?php echo L('sp4_password_compatible')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=system&a=uc" method="post" name="form_messagequeue_manage">
	<table width="100%" cellspacing="0" class="table_form">
	<tbody>
		<tr>
			<td colspan="2">
			<?php echo L('uc_notice')?></td>
		</tr>
		<tr>
			<th width="140"><?php echo L('enable')?></th>
			<td>
			<input type="radio" name="ucuse" value="1" <?php if(isset($data['ucuse']) && $data['ucuse']==1){echo 'checked';}?>/> <?php echo L('yes')?> <input type="radio" name="ucuse" value="0" <?php if(!isset($data['ucuse']) || !$data['ucuse']){echo 'checked';}?> /> <?php echo L('no')?></td>
		</tr>
		<tr>
			<th width="140"><?php echo L('uc_api_host')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_api]" id="uc_api" value="<?php if(isset($data['uc_api'])){echo $data['uc_api'];}?>" size="50"/><?php echo L('uc_host_notice')?></td>
		</tr>
		<tr>
			<th width="140">Ucenter api IP：</th>
			<td>
			<input type="text" class="input-text" name="data[uc_ip]" id="uc_ip" value="<?php if(isset($data['uc_ip'])){echo $data['uc_ip'];}?>" /><?php echo L('uc_ip_notice')?></td>
		</tr>
		<tr>
			<th><?php echo L('uc_db_host')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_dbhost]" id="uc_dbhost" value="<?php if(isset($data['uc_dbhost'])){echo $data['uc_dbhost'];}?>" /></td>
		</tr>
		
			<tr>
			<th><?php echo L('uc_db_username')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_dbuser]" id="uc_dbuser" value="<?php if(isset($data['uc_dbuser'])){echo $data['uc_dbuser'];}?>" /></td>
		</tr>
			<tr>
			<th><?php echo L('uc_db_password')?></th>
			<td>
			<input type="password" class="input-text" name="data[uc_dbpw]" id="uc_dbpw" value="<?php if(isset($data['uc_dbpw'])){echo $data['uc_dbpw'];}?>" /></td>
		</tr>
			<tr>
			<th><?php echo L('uc_dbname')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_dbname]" id="uc_dbname" value="<?php if(isset($data['uc_dbname'])){echo $data['uc_dbname'];}?>" /></td>
		</tr>
			<tr>
			<th><?php echo L('uc_db_pre')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_dbtablepre]" id="uc_dbtablepre" value="<?php if(isset($data['uc_dbtablepre'])){echo $data['uc_dbtablepre'];}?>" /> <input type="button" value="<?php echo L('uc_test_database')?>" class="button"  onclick="mysql_test()" /></td>
		</tr>
		</tr>
			<tr>
			<th><?php echo L('uc_db_charset')?></th>
			<td>
			<select name="data[uc_dbcharset]"  id="uc_dbcharset"  />
				<option value=""><?php echo L('please_select')?></option>
				<option value="gbk" <?php if(isset($data['uc_dbcharset']) && $data['uc_dbcharset'] == 'gbk'){echo 'selected';}?>>GBK</option>
				<option value="utf8"  <?php if(isset($data['uc_dbcharset']) && $data['uc_dbcharset'] == 'utf8'){echo 'selected';}?>>UTF-8</option>
			</select></td>
		</tr>
		</tr>
			<tr>
			<th><?php echo L('uc_appid')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_appid]" id="uc_appid" value="<?php if(isset($data['uc_appid'])){echo $data['uc_appid'];}?>" /></td>
		</tr>
		</tr>
			<tr>
			<th><?php echo L('uc_key')?></th>
			<td>
			<input type="text" class="input-text" name="data[uc_key]" id="uc_key" value="<?php if(isset($data['uc_key'])){echo $data['uc_key'];}?>" size="50"/></td>
		</tr>
	</tbody>
	</table>
    <div class="bk15"></div>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
<script type="text/javascript">
<!--
	function mysql_test() {
	$.get('?m=admin&c=system&a=myqsl_test', {host:$('#uc_dbhost').val(),username:$('#uc_dbuser').val(), password:$('#uc_dbpw').val()}, function(data){if(data==1){alert('<?php echo L('connect_success')?>')}else{alert('<?php echo L('connect_failed')?>')}});
}
//-->
</script>
</body>
</html>