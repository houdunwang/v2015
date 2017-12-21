<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
<div class="content-menu ib-a blue line-x">
<?php if($super_admin) {?>
<a href='?m=content&c=content&a=public_checkall&menuid=822' class="on"><em><?php echo L('all_check_list');?></em></a>
<?php } else {
	echo L('check_status');
}
for ($j=0;$j<5;$j++) {
?>
<span>|</span><a href='?m=content&c=content&a=public_checkall&menuid=822&status=<?php echo $j;?>' class="<?php if($status==$j) echo 'on';?>"><em><?php echo L('workflow_'.$j);?></em></a>
<?php }?>
</div>
</div>
<div class="pad-10">

<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
            <th width="60">ID</th>
			<th><?php echo L('title');?></th>
            <th><?php echo L('select_model_name');?></th>
            <th width="90"><?php echo L('current_steps');?></th>
            <th width="50"><?php echo L('steps');?></th>
            <th width="90"><?php echo L('belong_category');?></th>
            <th width="118"><?php echo L('contribute_time');?></th>
            <th width="130"><?php echo L('username');?></th>
			<th width="50"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	$model_cache = getcache('model','commons');
	foreach ($datas as $r) {
		$arr_checkid = explode('-',$r['checkid']);

		$workflowid = $this->categorys[$r['catid']]['workflowid'];
		if($stepid = $workflows[$workflowid]['steps']) {
			$stepname = L('steps_'.$stepid);
		} else {
			$stepname = '';
		}
		$modelname = $model_cache[$arr_checkid[2]]['name'];
		$flowname = L('workflow_'.$r['status']);
	?>
        <tr>
		<td align='center' ><?php echo $arr_checkid[1];?></td>
		<td align='left' ><a href="javascript:;" onclick='change_color(this);window.open("?m=content&c=content&a=public_preview&steps=<?php echo $r['status']?>&catid=<?php echo $r['catid'];?>&id=<?php echo $arr_checkid[1];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>","manage")'><?php echo $r['title'];?></a></td>
		<td align='center' ><?php echo $modelname;?></td>
		<td align='center' ><?php echo $flowname;?></td>
		<td align='center' ><?php echo $stepname;?></td>
		<td align='center' ><a href="?m=content&c=content&a=init&menuid=822&catid=<?php echo $r['catid'];?>"><?php echo $this->categorys[$r['catid']]['catname'];?></a></td>
		<td align='center' ><?php echo format::date($r['inputtime'],1);?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center' ><a href="javascript:;" onclick='change_color(this);window.open("?m=content&c=content&a=public_preview&steps=<?php echo $r['status']?>&catid=<?php echo $r['catid'];?>&id=<?php echo $arr_checkid[1];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>","manage")'><?php echo L('c_check');?></a></td>
	</tr>
     <?php }?>
</tbody>
     </table>
 <div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript"> 
<!--
window.top.$("#current_pos_attr").html('<?php echo L('checkall_content');?>');
function change_color(obj) {
	$(obj).css('color','red');
}
//-->
</script>
</body>
</html>