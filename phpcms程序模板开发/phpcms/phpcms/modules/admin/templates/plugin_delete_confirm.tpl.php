<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo CSS_PATH?>open_admin.css" rel="stylesheet" type="text/css" />
<div class="pad_10">
<div class="table-list">
	<div class="fs14"><?php echo L('uninstall_plugin','','plugin')?> - <?php echo $plugin_data['name']?></div>
   <div class="btn ibtn ibtns">
		<div class="fs14 txtc"><?php echo L('uninstall_plugin','','plugin')?></div>
        <form name="myform" action="?m=admin&c=plugin&a=delete" method="post">
		<input type="submit" class="button" name="dosubmit" value="<?php echo L('plugin_uninstall_confirm','','plugin')?>">   
		<input type="hidden" value="<?php echo $pluginid?>" name="pluginid">
		<input type="hidden" value="<?php echo $_SESSION['pc_hash']?>" name="pc_hash">
		</form>

		<input type="button" onclick="history.go(-1);" value="<?php echo L('plugin_uninstall_cancel','','plugin')?>" class="button" name="cancel">   
   </div>    
</div>
</div>
</div>

</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
