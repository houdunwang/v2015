<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<form action="?m=release&c=index&a=del" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80"><input type="checkbox"  onclick="selectall('ids[]');" id="check_box" /></th>
		<th width="80">ID</th>
		<th width="80"><?php echo L('type')?></th>
		<th width="80"><?php echo L("site")?>ID</th>
		<th><?php echo L('path')?></th>
		<th><?php echo L('time')?></th>
		<?php foreach ($this->point as $v) :$r = $this->db->get_one(array('id'=>$v), 'name');?>
		<th><?php echo $r['name']?></th>
		<?php endforeach;?>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td width="80" align="center"><input type="checkbox" name="ids[]" value="<?php echo $v['id']?>" /></td>
<td width="80" align="center"><?php echo $v['id']?></td>
<td align="center"><?php switch($v['type']){case 'edit':case 'add':echo L('upload');break;case 'del':echo L('delete');break;}?></td>
<td align="center"><?php echo $v['siteid']?></td>
<td align="center"><?php echo $v['path'];?></td>
<td align="center"><?php echo format::date($v['times'], 1);?></td>
<?php $i=1;foreach ($this->point as $d) :?>
<td align="center"><?php switch($v['status'.$i]){case -1:echo '<div class="onError">'.L("failure").'</div>';break;case 0:echo '<div class="onShow">'.L('not_upload').'</div>';break; case 1:echo '<div class="onCorrect">'.L("success").'</div>';break;}?></td>
<?php $i++;endforeach;?>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
<div class="btn"><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="button" class="button" name="dosubmit" value="<?php echo L('sync_agin')?>" onclick="sync_agin()" />　<input type="button" class="button" name="dosubmit" value="<?php echo L('all').L('sync_agin')?>" onclick="window.top.art.dialog({id:'sync',iframe:'?m=release&c=index&a=init&statuses=-1&iniframe=1', title:'<?php echo L('sync_agin')?>', width:'700', height:'500', lock:true},'', function(){window.top.art.dialog({id:'sync'}).close();location.reload()});" /> <input type="submit" class="button" value="<?php echo L("delete")?>" /></div> 
</form>
</div>
</div>
<div id="pages"><?php echo $queue->pages?></div>
<script type="text/javascript">
<!--
function sync_agin() {
	var ids =  '';
	$("input[type='checkbox'][name='ids[]']:checked").each(function(i,n){ids += ids ? ','+$(n).val() : $(n).val();});
	if (ids)window.top.art.dialog({id:'sync',iframe:'?m=release&c=index&a=init&statuses=-1&iniframe=1&ids='+ids, title:'<?php echo L('sync_agin')?>', width:'700', height:'500', lock:true},'', function(){window.top.art.dialog({id:'sync'}).close();location.reload()});
}
//-->
</script>
</body>
</html>