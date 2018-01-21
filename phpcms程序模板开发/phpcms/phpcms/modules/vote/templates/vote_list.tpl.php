<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?m=vote&c=vote&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('subjectid[]');"></th>
			<th><?php echo L('title')?></th>
			<th width="40" align="center"><?php echo L('vote_num')?></th>
			<th width="68" align="center"><?php echo L('startdate')?></th>
			<th width="68" align="center"><?php echo L('enddate')?></th>
			<th width='68' align="center"><?php echo L('inputtime')?></th>
			<th width="180" align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center"><input type="checkbox"
			name="subjectid[]" value="<?php echo $info['subjectid']?>"></td>
		<td><a href="?m=vote&c=index&a=show&show_type=1&subjectid=<?php echo $info['subjectid']?>&siteid=<?php echo $info['siteid'];?>" title="<?php echo L('check_vote')?>" target="_blank"><?php echo $info['subject'];?></a> <font color=red><?php if($info['enabled']==0)echo L('lock'); ?></font></td>
		<td align="center"><font color=blue><?php echo $info['votenumber']?></font> </td>
		<td align="center"><?php echo $info['fromdate'];?></td>
		<td align="center"><?php echo $info['todate'];?></td>
		<td align="center"><?php echo date("Y-m-d",$info['addtime']);?></td>
		<td align="center"><a href='###'
			onclick="statistics(<?php echo $info['subjectid']?>, '<?php echo new_addslashes($info['subject'])?>')"> <?php echo L('statistics')?></a>
		| <a href="###"
			onclick="edit(<?php echo $info['subjectid']?>, '<?php echo new_addslashes($info['subject'])?>')"
			title="<?php echo L('edit')?>"><?php echo L('edit')?></a> | <a href="javascript:call(<?php echo new_addslashes($info['subjectid'])?>);void(0);"><?php echo L('call_js_code')?></a> | <a
			href='?m=vote&c=vote&a=delete&subjectid=<?php echo new_addslashes($info['subjectid'])?>'
			onClick="return confirm('<?php echo L('vote_confirm_del')?>')"><?php echo L('delete')?></a>
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
<div class="btn"><a href="#"
	onClick="javascript:$('input[type=checkbox]').attr('checked', true)"><?php echo L('selected_all')?></a>/<a
	href="#"
	onClick="javascript:$('input[type=checkbox]').attr('checked', false)"><?php echo L('cancel')?></a>
<input name="submit" type="submit" class="button"
	value="<?php echo L('remove_all_selected')?>"
	onClick="return confirm('<?php echo L('vote_confirm_del')?>')">&nbsp;&nbsp;</div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
 
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?m=vote&c=vote&a=edit&subjectid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function statistics(id, name) {
	window.top.art.dialog({id:'statistics'}).close();
	window.top.art.dialog({title:'<?php echo L('statistics')?> '+name+' ',id:'edit',iframe:'?m=vote&c=vote&a=statistics&subjectid='+id,width:'700',height:'350'}, function(){var d = window.top.art.dialog({id:'statistics'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'statistics'}).close()});
}

function call(id) {
	window.top.art.dialog({id:'call'}).close();
	window.top.art.dialog({title:'<?php echo L('vote')?><?php echo L('linkage_calling_code','','admin');?>', id:'call', iframe:'?m=vote&c=vote&a=public_call&subjectid='+id, width:'600px', height:'470px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
}

function checkuid() {
	var ids='';
	$("input[name='subjectid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('before_select_operation')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

</script>
</body>
</html>
