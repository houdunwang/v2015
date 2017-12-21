<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="60">ID</th>
            <th><?php echo L('respective_modules');?></th>
            <th><?php echo L('rulename');?></th>
            <th><?php echo L('urlrule_ishtml');?></th>
            <th><?php echo L('urlrule_example');?></th>
            <th><?php echo L('urlrule_url');?></th>
			<th width="100"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
    <tr>
		<td align='center'><?php echo $r['urlruleid'];?></td>
		<td align="center"><?php echo $r['module'];?></td>
		<td align="center"><?php echo $r['file'];?></td>
		<td align="center"><?php echo $r['ishtml'] ? L('icon_unlock') : L('icon_locked');?></td>
		<td><?php echo $r['example'];?></td>
		<td><?php echo $r['urlrule'];?></td>
		<td align='center' ><a href="javascript:edit('<?php echo $r['urlruleid']?>')"><?php echo L('edit');?></a> | <a href="javascript:confirmurl('?m=admin&c=urlrule&a=delete&urlruleid=<?php echo $r['urlruleid'];?>&menuid=<?php echo $_GET['menuid'];?>','<?php echo L('confirm',array('message'=>$r['urlruleid']));?>')"><?php echo L('delete');?></a> </td>
	</tr>
	<?php } ?>
	</tbody>
    </table>
  
    <div id="pages"><?php echo $pages;?></div>
</div>
</div>
<script type="text/javascript"> 
<!--
function edit(id) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_urlrule');?>《'+id+'》',id:'edit',iframe:'?m=admin&c=urlrule&a=edit&urlruleid='+id,width:'750',height:'300'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>
</body>
</html>
