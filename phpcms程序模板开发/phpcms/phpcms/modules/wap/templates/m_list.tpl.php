<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left">SITEID</th>
            <th width=""><?php echo L('wap_sitename')?></th>
            <th width="20%"><?php echo L('status')?></th>
            <th width="15%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%"><?php echo $info['siteid']?></td>
	<td  width="" align="center"><a href="<?php echo APP_PATH?>index.php?m=wap&siteid=<?php echo $info['siteid']?>" target="_blank"><?php echo $info['sitename']?></a></td>
	<td width="20%" align="center"><a href="?m=wap&c=wap_admin&a=public_status&siteid=<?php echo $info['siteid']?>&status=<?php echo $info['status']==0 ? 1 : 0?>"><?php echo $info['status']==0 ? L('wap_close') : L('wap_open')?></a></td>
	<td width="15%" align="center">
	<a href="javascript:edit(<?php echo $info['siteid']?>, '<?php echo new_addslashes($info['sitename'])?>')"><?php echo L('edit')?></a> | <a href="?m=wap&c=wap_admin&a=type_manage&siteid=<?php echo $info['siteid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('wap_type_manage')?></a> | 
	<a href="javascript:confirmurl('?m=wap&c=wap_admin&a=delete&siteid=<?php echo $info['siteid']?>', '<?php echo L('wap_del_cofirm')?>')"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
 </div>

 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
<!--
	function edit(siteid, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=wap&c=wap_admin&a=edit&siteid='+siteid ,width:'400px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>