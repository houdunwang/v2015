<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>

<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th><?php echo L('name')?></th>
		<th width="80"><?php echo L('type')?></th>
		<th><?php echo L('display_position')?></th>
		<th width="150"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php if($v['type']==1) {echo L('code');} else {echo L('table_style');}?></td>
<td align="center"><?php echo $v['pos']?></td>
<td align="center"><a href="javascript:block_update(<?php echo $v['id']?>, '<?php echo $v['name']?>')"><?php echo L('updates')?></a> | <a href="javascript:edit(<?php echo $v['id']?>, '<?php echo $v['name']?>')"><?php echo L('edit')?></a> | <a href="?m=block&c=block_admin&a=del&id=<?php echo $v['id']?>" onclick="return confirm('<?php echo L('confirm', array('message'=>$v['name']))?>')"><?php echo L('delete')?></a></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
<div id="closeParentTime" style="display:none"></div>
<script type="text/javascript">
<!--
if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&from=block&pc_hash=<?php echo $_SESSION['pc_hash'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}

function block_update(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?>《'+name+'》',id:'edit',iframe:'?m=block&c=block_admin&a=block_update&id='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?>《'+name+'》',id:'edit',iframe:'?m=block&c=block_admin&a=edit&id='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>
</body>
</html>