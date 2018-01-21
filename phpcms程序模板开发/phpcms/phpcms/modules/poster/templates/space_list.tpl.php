<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
    <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:window.top.art.dialog({id:'setting',iframe:'?m=poster&c=space&a=setting', title:'<?php echo L('module_setting')?>', width:'540', height:'320'}, function(){var d = window.top.art.dialog({id:'setting'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'setting'}).close()});void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>
<div class="pad-lr-10">
<form name="myform" action="?m=poster&c=space&a=delete" method="post" id="myform">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="6%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('spaceid[]');"></th>
			<th><?php echo L('boardtype')?></th>
			<th width="12%" align="center"><?php echo L('ads_type')?></th>
			<th width='10%' align="center"><?php echo L('size_format')?></th>
			<th width="10%" align="center"><?php echo L('ads_num')?></th>
			<th align="center" width="13%"><?php echo L('description')?></th>
			<th width="28%" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="spaceid[]" value="<?php echo $info['spaceid']?>">
	</td>
	<td><?php echo $info['name']?></td>
	<td align="center"><?php echo $TYPES[$info['type']]?></td>
	<td align="center"><?php echo $info['width']?>*<?php echo $info['height']?></td>
	<td align="center"><?php echo $info['items']?></td>
	<td align="center"><?php echo $info['description']?></td>
	<td align="center">
	<a href="?m=poster&c=space&a=public_preview&spaceid=<?php echo $info['spaceid']?>" target="_blank"><?php echo L('preview')?></a> | <a href="javascript:call(<?php echo $info['spaceid']?>);void(0);"><?php echo L('get_code')?></a> | <a href='?m=poster&c=poster&a=init&spaceid=<?php echo $info['spaceid']?>&menuid=<?php echo $_GET['menuid']?>' ><?php echo L('ad_list')?></a> | 
	<a href="###" onclick="edit(<?php echo $info['spaceid']?>, '<?php echo addslashes(new_html_special_chars($info['name']))?>')" title="<?php echo L('edit')?>" ><?php echo L('edit')?></a> | 
	<a href='?m=poster&c=space&a=delete&spaceid=<?php echo $info['spaceid']?>' onClick="return confirm('<?php echo L('confirm', array('message' => addslashes(new_html_special_chars($info['name']))))?>')"><?php echo L('delete')?></a>
	| <a href="index.php?m=poster&c=poster&a=add&spaceid=<?php echo $info['spaceid']?>&menuid=<?php echo $_GET['menuid']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>">添加广告</a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="return confirm('<?php echo L('confirm', array('message' => L('selected')))?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
<!--

	function edit(id, name){
	window.top.art.dialog({title:'<?php echo L('edit_space')?>--'+name, id:'testIframe'+id, iframe:'?m=poster&c=space&a=edit&spaceid='+id ,width:'540px',height:'320px'}, 	function(){var d = window.top.art.dialog({id:'testIframe'+id}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'testIframe'+id}).close()});
	};

	function call(id) {
		window.top.art.dialog({id:'call'}).close();
		window.top.art.dialog({title:'<?php echo L('get_code')?>', id:'call', iframe:'?m=poster&c=space&a=public_call&sid='+id, width:'600px', height:'470px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
	}

//-->
</script>
</body>
</html>