<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=link&c=link&a=check_register" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('linkid[]');"></th>
 			<th><?php echo L('link_name')?></th>
 			<th width="20%" align="center"><?php echo L('url')?></th> 
			<th width="12%" align="center"><?php echo L('logo')?></th> 
			<th width="20%" align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" width="35"><input type="checkbox"
			name="linkid[]" value="<?php echo $info['linkid']?>"></td>
 		<td><a href="<?php echo $info['url'];?>" title="<?php echo L('go_website')?>" target="_blank"><?php echo $info['name']?></a></td>
		<th width="20%" align="center"><a href="<?php echo $info['url']?>" target="_blank"><?php echo $info['url']?></a></th>
		<td align="center" width="12%"><?php if($info['linktype']==1){?><?php if($info['passed']=='1'){?><img src="<?php echo $info['logo'];?>" width=83 height=31><?php } else echo $info['logo'];}?></td>
		 <td align="center" width="20%"><a href="###"
			onclick="edit(<?php echo $info['linkid']?>, '<?php echo new_addslashes($info['name'])?>')"
			title="<?php echo L('edit')?>"><?php echo L('edit')?></a> |  <a
			href='?m=link&c=link&a=delete&linkid=<?php echo $info['linkid']?>'
			onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes($info['name'])))?>')"><?php echo L('delete')?></a> 
		
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
<input name="dosubmit" type="submit" class="button"
	value="<?php echo L('pass_check')?>"
	onClick="return confirm('<?php echo L('pass_or_not')?>')">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=link&c=link&a=delete'" value="<?php echo L('delete')?>"/> </div>
<div id="pages"><?php echo $this->pages?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?m=link&c=link&a=edit&linkid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='linkid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
</script>
