<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=admin&c=copyfrom&a=listorder" method="post">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="55" align="center"><?php echo L('listorder');?></th>
            <th><?php echo L('copyfrom_name');?></th>
            <th ><?php echo L('copyfrom_url')?></th> 
            <th ><?php echo L('copyfrom_logo')?></th> 
             <th width="120"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
<?php
foreach($datas as $r) {
?>
<tr>
<td align="center"><input type="text" name="listorders[<?php echo $r['id']?>]" value="<?php echo $r['listorder']?>" size="3" class='input-text-c'></td>
<td align="center"><?php echo $r['sitename']?></td>
<td align="center"><?php echo $r['siteurl']?></td>
<td align="center"><?php if($r['thumb']) {?><img src="<?php echo $r['thumb']?>"><?php }?></td>
<td align="center"><a href="javascript:edit('<?php echo $r['id']?>','<?php echo new_addslashes($r['sitename'])?>')"><?php echo L('edit');?></a> | <a href="javascript:;" onclick="data_delete(this,'<?php echo $r['id']?>','<?php echo L('confirm',array('message'=>new_addslashes($r['sitename'])));?>')"><?php echo L('delete')?></a> </td>
</tr>
<?php } ?>
</tbody>
 </table>
 <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
<div id="pages"><?php echo $pages?></div>

</div>

</form></div>
</body>
</html>
<script type="text/javascript"> 
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit');?>《'+name+'》',id:'edit',iframe:'?m=admin&c=copyfrom&a=edit&id='+id,width:'580',height:'240'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function data_delete(obj,id,name){
	window.top.art.dialog({content:name, fixed:true, style:'confirm', id:'data_delete'}, 
	function(){
	$.get('?m=admin&c=copyfrom&a=delete&id='+id+'&pc_hash='+pc_hash,function(data){
				if(data) {
					$(obj).parent().parent().fadeOut("slow");
				}
			}) 	
		 }, 
	function(){});
};
//-->
</script>