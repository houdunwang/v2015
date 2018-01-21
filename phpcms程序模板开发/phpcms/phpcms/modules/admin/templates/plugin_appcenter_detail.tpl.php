<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo CSS_PATH?>appcenter.css" rel="stylesheet" type="text/css" />
<div class="pad_10">
<table width="90%" cellspacing="0" cellpadding="0" border="0" class="tb4col">
  <thead>
    <tr>
      <td colspan="4" align="left" bgcolor="#F2F9FF" class="thd"><?php if($recommed) {?><div class="r"><img src="<?php echo IMG_PATH?>zt.jpg" width="50" height="40"/> </div><?php }?>
        <img src="<?php echo $thumb ? $thumb : IMG_PATH.'zz_bg.jpg'?>" width="40" height="40" class="imgbh"/>
        <h5><?php echo $appname?></h5>
        <p><?php echo $description?></p></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="left" width="50%" class="clj"><h6><?php echo L('plugin_pub','','plugin')?></h6>

		<?php if(empty($iframe)) {?>
        <a href="<?php echo $downurl?>" title="<?php echo $appname?>"><?php echo L('plugin_click_download','','plugin')?></a>
		<?php }?>
		<a href="index.php?m=admin&c=plugin&a=install_online&id=<?php echo $id?>"><?php echo L('install_online','','plugin')?></a></td>

      <td align="left" width="50%"><strong><?php echo L('plugin_reg_time','','plugin')?></strong><?php echo date('Y-m-d H:i:s',$inputtime)?><br />
        <strong><?php echo L('plugin_copyright','','plugin')?></strong><?php echo $username?> </td>
    </tr>
    <tr>
      <td colspan="2" align="left"><?php echo L('plugin_copyright_info','','plugin')?></td>
    </tr>
  </tbody>
</table>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
<!--
	function add(id, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'add', iframe:'?m=pay&c=payment&a=add&code='+id ,width:'700',height:'500'}, 	function(){var d = window.top.art.dialog({id:'add'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});
}	
	function edit(id, name) {
		window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=pay&c=payment&a=edit&id='+id ,width:'700',height:'500'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>