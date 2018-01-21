<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php 
$page_title=L('application_manage');
include $this->admin_tpl('header');
?>
<div class="subnav">
<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('application_manage')?></h2>
<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=applications&a=init" class="on"><em><?php echo L('application_list')?></em></a><span>|</span> <a href="?m=admin&c=applications&a=add"><em><?php echo L('application_add')?></em></a></div>
</div>

<div class="table-list pad-lr-10">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
				<th width="30">ID</th>
				<th><?php echo L('application_name')?></th>
				<th><?php echo L('type')?></th>
				<th><?php echo L('charset')?></th>
				<th><?php echo L('synlogin')?></th>
				<th><?php echo L('apifilename')?></th>
				<th><?php echo L('communications_status')?></th>
				<th><?php echo L('operation')?></th>
			</tr>
        </thead>
    </table>
    <table width="100%" cellspacing="0" class="wrap">
    <?php foreach ($list as $v):?>
        <tr>
			<td align="center"><?php echo $v['appid']?></td>
			<td align="center"><?php echo $v['name']?></td>
			<td align="center"><?php echo $v['type']?></td>
			<td align="center"><?php echo $v['charset']?></td>
			<td align="center"><?php echo $v['synlogin']?></td>
			<td align="center"><?php echo $v['apifilename']?></td>
			<td align="center"><span id="status_<?php echo $v['appid']?>"><?php echo L('testing_communication')?></span><script type="text/javascript">$(function(){check_status(<?php echo $v['appid']?>)})</script></td>
			<td align="center"><a href="?m=admin&c=applications&a=edit&appid=<?php echo $v['appid']?>">[<?php echo L('edit')?>]</a>&nbsp;|&nbsp;<a href="?m=admin&c=applications&a=del&appid=<?php echo $v['appid']?>" onclick="return confirm('<?php echo L('sure_delete')?>')">[<?php echo L('delete')?>]</a></td>
		</tr>
      <?php endforeach;?>
    </table>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
<script type="text/javascript">
<!--
	function check_status(id) {
		$.get('?m=admin&c=applications&a=check_status&appid='+id+'&'+Math.random(),function(data){
			if(data == 1) {
				$('#status_'+id).html('<?php echo '<div class="onCorrect">'.L('communication_success').'</div>'?>');
			} else {
				$('#status_'+id).html('<?php echo '<div class="onError">'.L('communication_failure').'</div>'?>');
			}
			});
	}
//-->
</script>
</body>
</html>