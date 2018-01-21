<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('communicate_info');
include $this->admin_tpl('header');
?>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('communicate_info')?></h2>
</div>
<form action="?m=admin&c=messagequeue&a=delete" method="post" name="form_messagequeue_manage">
<div class="table-list pad-lr-10">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
	            <th width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
	            <th><?php echo L('operation')?></th>
	            <th><?php echo L('notice_data')?></th>
	            <th><?php echo L('notice_num')?></th>
	            <th><?php echo L('notice_dateline')?></th>
				<?php
					if(is_array($applist)) {
					foreach($applist as $k=>$v) {
				?>
				<th><?php echo $v['name']?></th>
				<?php
					}
					}	
				?> 
            </tr>
        </thead>
    <tbody>
<?php
foreach($messagequeue as $k=>$v) {
?>
	<tr>
		<td align="center" width="40"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
		<td align="center"><?php echo L($v['operation'])?></td>
		<td align="center" title="<?php echo $v['noticedata']?>"><?php echo L('view')?></td>
		<td align="center"><span id="totalnum"><?php echo $v['totalnum']?></span></td>
		<td align="center"><?php echo date('Y-m-d H:i:s', $v['dateline']);?></td>
		
		<?php
			if(is_array($applist)) {
			foreach($applist as $app_k=>$app_v) {
		?>
		<td align="center" id='status_<?php echo $v['id'].'_'.$app_k;?>'>
		<!--<script type="text/javascript">$(function(){notice(<?php echo $v['id']?>, <?php echo $app_k?>)})</script>-->
		<?php echo isset($v['appstatus'][$app_k]) && $v['appstatus'][$app_k]==1 ? '<div  class="onCorrect">'.L('notice_success').'</div>' : '<a href="javascript:renotice('.$v['id'].', '.$app_k.');" class="onError">'.L('notice_fail').'</a>'?>
			
		</td>
		<?php
			}}
		?>
		
	</tr>
<?php
}	
?>   </tbody>
    </table>
    <div class="btn">
	<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
	<input type="button" class="button" value="<?php echo L('delete')?>" onclick="this.form.submit();"/>
	</div>
    <div id="pages">
    <?php echo $pages?>
    </div>
</div>
</form>

<script language="JavaScript">
<!--
function renotice(noticeid, appid) {
	$.post('?m=admin&c=messagequeue&a=renotice'+'&'+Math.random(), {noticeid:noticeid, appid:appid},
	function(data){
		$('#totalnum').html(parseInt($('#totalnum').html())+1);
		if (data==1) {
			$('#status_'+noticeid+'_'+appid).html('<?php echo '<div  class="onCorrect">'.L('notice_success').'</div>'?>');
		}
		parent.showloading();
	});
}

function notice(noticeid, appid) {
	$.post('?m=admin&c=messagequeue&a=notice&noticeid='+noticeid+'&appid='+appid+'&'+Math.random(),function(data){
		if(data == 1) {
			$('#status_'+noticeid+'_'+appid).html('<?php echo '<div  class="onCorrect">'.L('notice_success').'</div>'?>');
		}
	});
}

//-->

</script>

</body>
</html>