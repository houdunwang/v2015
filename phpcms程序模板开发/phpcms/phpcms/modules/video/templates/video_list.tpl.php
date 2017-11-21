<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="video" name="m">
<input type="hidden" value="video" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<select name="type" ><option value=""><?php echo L('please_select')?></option><option value="1" <?php if ($_GET['type']==1) {?>selected<?php }?>><?php echo L('video_id');?></option><option value="2" <?php if ($_GET['type']==2) {?>selected<?php }?>><?php echo L('video_title')?></option></select> <input type="text" value="<?php echo $_GET['q']?>" class="input-text" name="q"> 
<?php echo L('addtime')?>  <?php echo form::date('start_addtime',$_GET['start_addtime'])?><?php echo L('to')?>   <?php echo form::date('end_addtime',$_GET['end_addtime'])?> 
<?php echo form::select($trade_status,$status,'name="status"', L('all_status'))?> <label title="<?php echo L('site_upload');?>"><?php echo L('original');?> <input type="checkbox" name="userupload" value="1" id="userupload"<?php if($userupload){ ?> checked<?php }?>></label> &nbsp;&nbsp;
<input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
</div>
</form>
<form name="myform" id="myform" action="" method="post" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
			<th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="6%">ID</th>
            <th><?php echo L('thumb')?></th>
            <th><?php echo L('video_title')?></th>
            <th width="18%">vid</th>
            <th width="12%"><?php echo L('addtime')?></th>
            <th width="11%"><?php echo L('tags');?></th>
            <th width="8%"><?php echo L('status')?></th>
            <th width="16%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
		$status_arr = pc_base::load_config('ku6status_config');
?>   
	<tr>
	<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $info['videoid'];?>" type="checkbox"></td>
	<td align="center"><?php echo $info['videoid']?></td>
	<td align="center">
<img src="<?php echo $info['picpath'] ? $info['picpath'] : IMG_PATH.'admin_img/bfqicon1.jpg';?>" width="100px" />	
</td>
	<td><?php echo $info['title']?> <?php if($info['userupload']){?><img src="<?php echo IMG_PATH; ?>yc.jpg" height="16"><?php }?></td>
	<td align="center"><?php echo $info['vid'];?></td>
	<td align="center"><?php echo date('Y-m-d H:i', $info['addtime'])?></td>
	<td align="center"><?php echo $info['keywords']?></td>
	<td align="center" id="status_<?php echo $info['videoid']?>"><?php if($info['status']<0 || $info['status']==24) { ?><font color="#ff5c5c"><?php } elseif ($info['status']==21) {?><font color="#3a895d"><?php }?><?php echo $status_arr[$info['status']]?> <?php if($info['status']<0 || $info['status']==24 || $info['status']==21) { ?></font><?php }?></td>
	<td align="center"><a href="javascript:void(0);" onclick="check_status('<?php echo $info['videoid']?>')"><?php echo L('update_status')?></a> | <a href="javascript:void(0);" onclick="view_video('<?php echo $info['videoid']?>')"><?php echo L('view')?></a> | <a href="index.php?m=video&c=video&a=edit&vid=<?php echo $info['videoid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('edit');?></a><?php if($info['status']>=0 && $info['status']!=24) {?> | <a href="javascript:confirmurl('index.php?m=video&c=video&a=delete&vid=<?php echo $info['videoid']?>&menuid=<?php echo $_GET['menuid']?>', '<?php echo L('delete_this_video')?>')"><?php echo L('delete');?></a><?php }?></td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
<div class="btn text-l"><input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
	<label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?m=video&c=video&a=delete_all&dosubmit=1';return confirm_delete();"/>
</div>
 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
function view_video(id) {
	window.top.art.dialog({title:'', id:'view', iframe:'?m=video&c=video&a=public_view_video&id='+id ,width:'450px',height:'350px'});
}

function check_status(id) {
	$.get('index.php', {m:'video', c:'video', a:'public_check_status', id:id, time:Math.random()}, function (data){
		if (data==1) {
			show_msg('<?php echo L('please_choose_video')?>');
			return false;
		} else if (data==2) {
			show_msg('<?php echo L('not_exist_vidoe')?>');
			return false;
		} else if(data==3) {
			show_msg('<?php echo L('communication_failed')?>');
			return false;
		} else {
			var html = '';
			data =  eval('(' + data + ')');
			if (data.change) {
				if (data.status<0 || data.status==24){
					html = '<font color="#ff5c5c">'+data.statusname+'</font>';
				} else if (data.status==21) {
					html = '<font color="#3a895d">'+data.statusname+'</font>';
				} else {
					html = data.statusname;
				}
				$('#status_'+id).html(html);
				show_msg('<?php echo L('video_status_update_successful')?>');
			} else {
				show_msg('<?php echo L('video_status_not_change')?>');
			}
		}
	});
}

function confirm_delete(){
	if(confirm('确认删除吗？')) $('#myform').submit();
}

function show_msg(msg) {
	window.top.art.dialog({title:'', id:'msg', content:msg, width:'200px',height:'50px'});
}
//-->
</script>