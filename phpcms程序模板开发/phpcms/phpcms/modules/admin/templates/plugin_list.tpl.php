<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<form name="myform" action="?m=admin&c=plugin&a=listorder" method="post">
<div class="pad_10">
<?php if(pc_base::load_config('system','plugin_debug')) { ?>
<div class="explain-col"><?php echo L('plugin_debug_tips','','plugin')?></div>
<div class="bk10"></div>
<?php } ?>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"><?php echo L('plugin_listorder','','plugin')?></th>
            <th width="25%" align="left"><?php echo L('plugin_list_name','','plugin')?></th>
            <th width="10%">URL</th>
            <th width="10%"><?php echo L('plugin_list_version','','plugin')?></th>
            <th width="15%"><?php echo L('plugin_list_copy','','plugin')?></th>
            <th width="10%"><?php echo L('plugin_list_dir','','plugin')?></th>
            <th width=""><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($pluginfo)){
	foreach($pluginfo as $info){
	$iframe = '';
	if($info['iframe']) $iframe = string2array($info['iframe']);
?>   
	<tr>
	<td width="10%" align="center">
	<input name='listorders[<?php echo $info['pluginid']?>]' type='text' size='2' value='<?php echo $info['listorder']?>' class="input-text-c">
	</td>
	<td width="25%"><?php if(!$info[appid] && pc_base::load_config('system','plugin_debug')) { ?><img src="<?php echo IMG_PATH?>admin_img/plugin_debug.png" title="Developing"><?php } ?>
	<a href="?m=admin&c=plugin&a=config&pluginid=<?php echo $info['pluginid']?>&menuid=<?php echo $_GET['menuid']?>">
	<?php echo intval($info['disable']) ? '<font color="green">'.$info['name'].'</font>': '<font color="grey">'.$info['name'].'</font>'?></a><?php if($iframe['url']) { ?><a href="plugin.php?id=<?php echo $info['identification']?>" target="_blank"><img src="<?php echo IMG_PATH?>admin_img/link.png" title="iframe"></a><?php } ?>
	</td>
	<td  width="10%" align="center"><?php if($info['url']) {?><a href="<?php echo $info['url']?>" target="_blank"><?php echo L('plugin_visit')?></a><?php } elseif($iframe['url']) {?><a href="plugin.php?id=<?php echo $info['identification']?>" target="_blank"><?php echo L('plugin_visit')?></a><?php }?></td>
	<td  width="10%" align="center"><?php echo $info['version']?></td>
	<td  width="15%" align="center"><?php echo $info['copyright']?></td>
	<td width="10%" align="center"><?php echo $info['dir']?></td>
	<td width="" align="center">
	<a href="?m=admin&c=plugin&a=config&pluginid=<?php echo $info['pluginid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('plugin_config')?></a>
	<a href="?m=admin&c=plugin&a=status&pluginid=<?php echo $info['pluginid']?>&disable=<?php echo intval($info['disable']) ? 0 : 1?>"><?php echo intval($info['disable']) ? L('plugin_close') : L('plugin_open')?></a> <a href="?m=admin&c=plugin&a=delete&pluginid=<?php echo $info['pluginid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('plugin_uninstall')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
  
   <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div> </div>

</div>
</div>
</form>
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