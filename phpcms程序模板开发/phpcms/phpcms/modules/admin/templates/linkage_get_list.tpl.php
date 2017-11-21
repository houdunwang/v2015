<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%">ID</th>
		<th width="20%" align="left" ><?php echo L('linkage_name')?></th>
		<th width="30%" align="left" ><?php echo L('linkage_desc')?></th>
		</tr>
        </thead>
        <tbody>
		<?php 
		if(is_array($infos)){
			foreach($infos as $info){
		?>
		<tr onclick="return_id(<?php echo $info['linkageid']?>)" title="<?php echo L('click_select')?>" class="cu">
		<td width="10%" align="center"><?php echo $info['linkageid']?></td>
		<td width="20%" ><?php echo $info['name']?></td>
		<td width="30%" ><?php echo $info['description']?></td>
		</tr>
		<?php 
			}
		}
		?>
</tbody>
</table>
</div>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function return_id(linkageid) {
	window.parent.$('#linkageid').val(linkageid);window.parent.art.dialog({id:'selectid'}).close();
}
//-->
</SCRIPT>
</body>
</html>