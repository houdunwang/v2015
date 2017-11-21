<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo CSS_PATH?>open_admin.css" rel="stylesheet" type="text/css" />
<div class="pad_10">
<div class="table-list">
<?php if($license && $_GET['license']) {?>
<div class="nr"><p><?php echo $plugin_data['license']?></p></div>
   <div class="btn ibtn txtc">
	<input type="button" onclick="location.href='<?php echo $submit_url?>'" value="<?php echo L('plugin_agree','','plugin')?>" class="button" name="install">   
	<input type="button" onclick="history.go(-1);" value="<?php echo L('plugin_disagree','','plugin')?>" class="button" name="cancel">   
   </div>
<?php } else { ?>
	<div class="fs14"><?php echo L('install_plugin','','plugin')?></div>
   <div class="btn ibtn ibtns">
   <div class="fs14 txtc"><?php echo L('install_plugin','','plugin')?></div>
	<input type="button" onclick="location.href='<?php echo $submit_url?>'" value="<?php echo L('plugin_install_app','','plugin')?>" class="button" name="install"> <input type="button" onclick="history.go(-1);" value="<?php echo L('plugin_uninstall_cancel','','plugin')?>" class="button" name="cancel">  
   </div>
<?php } ?>   
</div>
</div>
</div>

</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
