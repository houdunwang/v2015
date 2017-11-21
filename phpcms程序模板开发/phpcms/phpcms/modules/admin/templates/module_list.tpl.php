<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="220" align="center"><?php echo L('modulename')?></th>
			<th width='220' align="center"><?php echo L('modulepath')?></th>
			<th width="14%" align="center"><?php echo L('versions')?></th>
			<th width='10%' align="center"><?php echo L('installdate')?></th>
			<th width="10%" align="center"><?php echo L('updatetime')?></th>
			<th width="12%" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if (is_array($directory)){
	foreach ($directory as $d){
		if (array_key_exists($d, $modules)) {
?>   
	<tr>
	<td align="center" width="220"><?php echo $modules[$d]['name']?></td>
	<td width="220" align="center"><?php echo $d?></td>
	<td align="center"><?php echo $modules[$d]['version']?></td>
	<td align="center"><?php echo $modules[$d]['installdate']?></td>
	<td align="center"><?php echo $modules[$d]['updatedate']?></td>
	<td align="center"> 
	<?php if ($modules[$d]['iscore']) {?><span style="color: #999"><?php echo L('ban')?></span><?php } else {?><a href="javascript:void(0);" onclick="if(confirm('<?php echo L('confirm', array('message'=>$modules[$d]['name']))?>')){uninstall('<?php echo $d?>');return false;}"><font color="red"><?php echo L('unload')?></font></a><?php }?>
	</td>
	</tr>
<?php 
	} else {  
		$moduel = $isinstall = $modulename = '';
		if (file_exists(PC_PATH.'modules'.DIRECTORY_SEPARATOR.$d.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config.inc.php')) {
			require PC_PATH.'modules'.DIRECTORY_SEPARATOR.$d.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config.inc.php';
			$isinstall = L('install');
		} else {
			$module = L('unknown');
			$isinstall = L('no_install');
		}
?>
	<tr class="on">
	<td align="center" width="220"><?php echo $modulename?></td>
	<td width="220" align="center"><?php echo $d?></td>
	<td align="center"><?php echo L('unknown')?></td>
	<td align="center"><?php echo L('unknown')?></td>
	<td align="center"><?php echo L('uninstall_now')?></td>
	<td align="center">
	<?php if ($isinstall!=L('no_install')) {?> <a href="javascript:install('<?php echo $d?>');void(0);"><font color="#009933"><?php echo $isinstall?></font><?php } else {?><font color="#009933"><?php echo $isinstall?></font><?php }?></a>
	</td>
	</tr>
<?php 
		}
	}
}
?>
</tbody>
    </table>
    </div>
 <div id="pages"><?php echo $pages?></div>
</div>
<script type="text/javascript">
<!--

	function install(id) {
		window.top.art.dialog({id:'install'}).close();
		window.top.art.dialog({title:'<?php echo L('module_istall')?>', id:'install', iframe:'?m=admin&c=module&a=install&module='+id, width:'500px', height:'260px'}, function(){var d = window.top.art.dialog({id:'install'}).data.iframe;// 使用内置接口获取iframe对象
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'install'}).close()});
	}

function uninstall(id) {
	window.top.art.dialog({id:'install'}).close();
	window.top.art.dialog({title:'<?php echo L('module_unistall', '', 'admin')?>', id:'install', iframe:'?m=admin&c=module&a=uninstall&module='+id, width:'500px', height:'260px'}, function(){var d = window.top.art.dialog({id:'install'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'install'}).close()});
}

//-->
</script>
</body>
</html>