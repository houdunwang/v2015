<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<div class="explain-col search-form">
<?php if($config_flag) {
	echo "<img src='".IMG_PATH."icon/right.png' width='64' height='64'> ".L('配置正确，您可以正常使用视频聚合平台了！');
} else {
?>
<font color="#cc0000"><?php echo "<img src='".IMG_PATH."icon/error.png' width='64' height='64'> ".L('subscribe_notic');?></font>
<?php }?>
</div>
<div class="common-form">
<form name="myform" action="?m=video&c=video&a=setting&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('pass_settings');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('vms_sn');?></td> 
		<td><input name="setting[sn]"  type="text" id="sn"  size="40" value="<?php echo $this->setting['sn'];?>"> </td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('vms_skey');?></td> 
		<td><input type="text" name="setting[skey]" size="40" value="<?php echo $this->setting['skey']?>" id="skey"></td>
	</tr> 
	<tr>
		<td  width="120"><?php echo L('default_video_to_cat');?> </td> 
		<td> <?php echo $category_list;?></td>
	</tr>
	
	<tr>
		<td  width="120"><?php echo L('video_api_url');?> </td> 
		<td><?php echo APP_PATH;?>api.php?op=video_api  (聚合平台的回调地址)</td>
	</tr>
</table>
</fieldset>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>

</body>
</html>