<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?m=content&c=type_manage&a=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
	<tr>
	<th width="5%">ID</th>
	<th width="20%" align="left"><?php echo L('workflow_name');?></th>
	<th width="20%"><?php echo L('steps');?></th>
	<th width="10%"><?php echo L('workflow_diagram');?></th>
	<th width="*"><?php echo L('description');?></th>
	<th width="30%"><?php echo L('operations_manage');?></th>
	</tr>
        </thead>
    <tbody>
    

<?php
$steps[1] = L('steps_1');
$steps[2] = L('steps_2');
$steps[3] = L('steps_3');
$steps[4] = L('steps_4');
foreach($datas as $r) {
?>
<tr>
<td align="center"><?php echo $r['workflowid']?></td>
<td ><?php echo $r['workname']?></td>
<td align="center"><?php echo $steps[$r['steps']]?></td>
<td align="center"><a href="javascript:view('<?php echo $r['workflowid']?>','<?php echo $r['workname']?>')"><?php echo L('onclick_view');?></a></td>
<td ><?php echo $r['description']?></td>
<td align="center"><a href="javascript:edit('<?php echo $r['workflowid']?>','<?php echo $r['workname']?>')"><?php echo L('edit');?></a> | <a href="javascript:;" onclick="data_delete(this,'<?php echo $r['workflowid']?>','<?php echo L('confirm',array('message'=>$r['workname']));?>')"><?php echo L('delete')?></a> </td>
</tr>
<?php } ?>
	</tbody>
    </table>

 </div>
</div>
<div id="pages"><?php echo $pages;?></div>
</div>
</form>

<script type="text/javascript"> 
<!--
window.top.$('#display_center_id').css('display','none');
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_workflow');?>《'+name+'》',id:'edit',iframe:'?m=content&c=workflow&a=edit&workflowid='+id,width:'680',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function view(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('workflow_diagram');?>《'+name+'》',id:'edit',iframe:'?m=content&c=workflow&a=view&workflowid='+id,width:'580',height:'300'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function data_delete(obj,id,name){
	window.top.art.dialog({content:name, fixed:true, style:'confirm', id:'data_delete'}, 
	function(){
	$.get('?m=content&c=workflow&a=delete&workflowid='+id+'&pc_hash=<?php echo $_SESSION['pc_hash'];?>',function(data){
				if(data) {
					$(obj).parent().parent().fadeOut("slow");
				}
			}) 	
		 }, 
	function(){});
};
//-->
</script>
</body>
</html>
