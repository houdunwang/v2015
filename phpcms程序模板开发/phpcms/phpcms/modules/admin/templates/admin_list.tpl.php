<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="table-list">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%"><?php echo L('userid')?></th>
		<th width="10%" align="left" ><?php echo L('username')?></th>
		<th width="10%" align="left" ><?php echo L('userinrole')?></th>
		<th width="10%"  align="left" ><?php echo L('lastloginip')?></th>
		<th width="20%"  align="left" ><?php echo L('lastlogintime')?></th>
		<th width="15%"  align="left" ><?php echo L('email')?></th>
		<th width="10%"><?php echo L('realname')?></th>
		<th width="15%" ><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php $admin_founders = explode(',',pc_base::load_config('system','admin_founders'));?>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td width="10%" align="center"><?php echo $info['userid']?></td>
<td width="10%" ><?php echo $info['username']?></td>
<td width="10%" ><?php echo $roles[$info['roleid']]?></td>
<td width="10%" ><?php echo $info['lastloginip']?></td>
<td width="20%"  ><?php echo $info['lastlogintime'] ? date('Y-m-d H:i:s',$info['lastlogintime']) : ''?></td>
<td width="15%"><?php echo $info['email']?></td>
<td width="10%"  align="center"><?php echo $info['realname']?></td>
<td width="15%"  align="center">
<a href="javascript:edit(<?php echo $info['userid']?>, '<?php echo new_addslashes($info['username'])?>')"><?php echo L('edit')?></a> | 
<?php if(!in_array($info['userid'],$admin_founders)) {?>
<a href="javascript:confirmurl('?m=admin&c=admin_manage&a=delete&userid=<?php echo $info['userid']?>', '<?php echo L('admin_del_cofirm')?>')"><?php echo L('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo L('delete')?></font>
<?php } ?> | <a href="javascript:void(0)" onclick="card(<?php echo $info['userid']?>)"><?php echo L('ht_card')?></a>
</td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
 <div id="pages"> <?php echo $pages?></div>
</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">
<!--
	function edit(id, name) {
		window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=admin_manage&a=edit&userid='+id ,width:'500px',height:'400px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
	}

function card(id) {
	window.top.art.dialog({title:'<?php echo L('the_password_card')?>', id:'edit', iframe:'?m=admin&c=admin_manage&a=card&userid='+id ,width:'500px',height:'400px'}, 	'', function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>