<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<form name="myform" id="myform" action="?m=member&c=member_group&a=delete" method="post" onsubmit="check();return false;">
<div class="pad-lr-10">
<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="30px"><input type="checkbox" value="" id="check_box" onclick="selectall('groupid[]');"></th>
			<th align="left">ID</th>
			<th><?php echo L('sort')?></th>
			<th><?php echo L('groupname')?></th>
			<th><?php echo L('issystem')?></th>
			<th><?php echo L('membernum')?></th>
			<th><?php echo L('starnum')?></th>
			<th><?php echo L('pointrange')?></th>
			<th><?php echo L('allowattachment')?></th>
			<th><?php echo L('allowpost')?></th>
			<th><?php echo L('member_group_publish_verify')?></th>
			<th><?php echo L('allowsearch')?></th>
			<th><?php echo L('allowupgrade')?></th>
			<th><?php echo L('allowsendmessage')?></th>
			<th><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($member_group_list as $k=>$v) {
?>
    <tr>
		<td align="left"><?php if(!$v['issystem']) {?><input type="checkbox" value="<?php echo $v['groupid']?>" name="groupid[]"><?php }?></td>
		<td align="left"><?php echo $v['groupid']?></td>
		<td align="center"><input type="text" name="sort[<?php echo $v['groupid']?>]" class="input-text" size="1" value="<?php echo $v['sort']?>"></th>
		<td align="center" title="<?php echo $v['description']?>"><?php echo $v['name']?></td>
		<td align="center"><?php echo $v['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['membernum']?></th>
		<td align="center"><?php echo $v['starnum']?></td>
		<td align="center"><?php echo $v['point']?></td>
		<td align="center"><?php echo $v['allowattachment'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['allowpost'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['allowpostverify'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['allowsearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['allowupgrade'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><?php echo $v['allowsendmessage'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><a href="javascript:edit(<?php echo $v['groupid']?>, '<?php echo $v['name']?>')">[<?php echo L('edit')?>]</a></td>
    </tr>
<?php
	}
?>
</tbody>
 </table>

<div class="btn"><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member_group&a=sort'" value="<?php echo L('sort')?>"/>
</div> 
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</form>
<div id="PC__contentHeight" style="display:none">160</div>
<script language="JavaScript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member_group')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member_group&a=edit&groupid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function check() {
	if(myform.action == '?m=member&c=member_group&a=delete') {
		var ids='';
		$("input[name='groupid[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			window.top.art.dialog({content:'<?php echo L('plsease_select').L('member_group')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
			return false;
		}
	}
	myform.submit();
}
//-->
</script>
</body>
</html>