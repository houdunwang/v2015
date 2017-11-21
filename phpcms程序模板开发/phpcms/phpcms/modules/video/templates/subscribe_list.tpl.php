<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="searchform" id="searchform" action="" method="get" >
<input type="hidden" value="video" name="m">
<input type="hidden" value="video" name="c">
<input type="hidden" <?php if (($type == 1)) { ?>value="subscribe_list"<?php } else { ?>value="subscribe_uservideo"<?php } ?> id="sub_function" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<?php echo form::radio(array('1'=>L('channel_subscribe'), '2'=>L('user_subscribe')), $type, 'name="type"', '', 'choose')?>&nbsp;&nbsp;
<label id="selected_instruction"><?php if ($type == 2) { echo L('input_userid'); } else { echo L('choose_channel'); }?></label>
<?php if ($type == 2) { echo form::select($ku6_channels, $sub['channelid'], 'name="sub[channelid]" id="channelid" style="display:none"', L('please_choose_channel')); } else {echo form::select($ku6_channels, $sub['channelid'], 'name="sub[channelid]" id="channelid"', L('please_choose_channel'));}?>
<input type="text" id="userid" name="sub[userid]" <?php if($type == 1) { ?> style="display:none;" <?php }?>>
<label id="return_result" style="display:none; color:red"></label>
<?php echo L('subscribe_storage_section');?><?php echo $category_list;?>
<?php echo L('subscribe_postions');?><span id="posid"></span>
<input type="submit" value=" <?php echo L('add');?> " class="button" id="add_sub" name="dosubmit">
</div>
</form>
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="6%">ID</th>
            <th id="change_instruction"><?php  if ($type == 1) { echo L('channel'); } else { echo L('instruction_usersub'); }?></th>
            <th width="26%"><?php echo L('storage_cat');?></th>
            <th width="26%"><?php echo L('storage_pos');?></th>
            <th width="10%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody id="channel_sub_list" <?php if($type == 2) { ?> style="display:none;" <?php }?>>
  <?php 
if(is_array($subscribes)){
	foreach($subscribes as $info){
?>   
	<tr>
	<td align="center"><?php echo $info['sid']?></td>
	<td align="center"><?php echo $info['channelid'];?> </td>
	<td align="center"><?php echo $CATEGORYS[$info['catid']]['catname'];?></td>
	<td align="center"><?php echo $position[$info['posid']]['name']?> </a>
	<td align="center"> 
 	<a href="javascript:confirmurl('index.php?m=video&c=video&a=sub_del&id=<?php echo $info['sid']?>&meunid=<?php echo $_GET['menuid']?>&type=1', '是否删除?')"><?php echo L('delete');?></a></td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    <tbody id="user_sub_list" <?php if($type == 1) { ?> style="display:none;" <?php }?>>
  <?php 
if(is_array($usersubscribes)){
	foreach($usersubscribes as $val){
?>   
	<tr>
	<td align="center"><?php echo $val['sid']?></td>
	<td align="center"><?php echo $val['sub_userid'];?> </td>
	<td align="center"><?php echo $CATEGORYS[$val['catid']]['catname'];?></td>
	<td align="center"><?php echo $position[$val['posid']]['name']?> </a>
	<td align="center"> 
 	<a href="javascript:confirmurl('index.php?m=video&c=video&a=user_sub_del&id=<?php echo $val['sid']?>&meunid=<?php echo $_GET['menuid']?>&type=2', '是否删除?')"><?php echo L('delete');?></a></td>
	</tr>
<?php 
	}
}
?>
    </tbody>    
    </table>
<div class="btn text-r">

</div>
 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function(e) {
	$("#userid").blur( function() { 
		var userid = $("#userid").val();
		if (userid == '') {
 			alert('<?php echo L('please_input_userid')?>');
 			return false;
		}
		var hash = '<?php echo $_GET['pc_hash']?>';
		$('#return_result').show();
		$('#return_result').html('<img src="<?php echo IMG_PATH.'msg_img/loading.gif';?>">');
		$.get("index.php", {m:'video', c:'video', a:'ajax_getuseridvideo', userid:userid , tm:Math.random(), pc_hash:hash}, function (data) {
			if (data == 1) {
				$('#return_result').css('color', '');
				$('#return_result').addClass("onCorrect");
				$('#return_result').html('<?php echo L('input_right')?>');
				$('#add_sub').removeAttr('disabled');
			} else if (data == 2) {
				$('#return_result').css('color', 'red');
				$('#return_result').removeClass("onCorrect");
				$('#return_result').html('<?php echo L('user_already_sub')?>');
				$('#add_sub').attr('disabled', 'true');
			} else if (data == 3) {
				$('#return_result').css('color', 'red');
				$('#return_result').removeClass("onCorrect");
				$('#return_result').html('<?php echo L('user_sub_nomore_than3')?>');
				$('#add_sub').attr('disabled', 'true');				
			} else {
				$('#return_result').css('color', 'red');
				$('#return_result').removeClass("onCorrect");
				$('#return_result').html('<?php echo L('user_no_video')?>');
				$('#add_sub').attr('disabled', 'true');
			}
		} );
	}); 
    $('#choose_1').click(function(){
    	$('#change_instruction').html('<?php echo L('channel');?>');
    	$('#user_sub_list').hide(); 
    	$('#channel_sub_list').show();        
    	$('#userid').val('');
    	$('#sub_function').val('subscribe_list');
    	$('#selected_instruction').html('<?php echo L('choose_channel');?>');
    	$('#userid').hide();
    	$('#channelid').show();
	});
    $('#choose_2').click(function(){
    	$('#change_instruction').html('<?php echo L('instruction_usersub');?>');
    	$('#channel_sub_list').hide();        
    	$('#user_sub_list').show();     	
    	$('#sub_function').val('subscribe_uservideo');
    	$('#selected_instruction').html('<?php echo L('input_userid');?>');
    	$('#channelid').hide();
    	$('#userid').show();
	});
});
function select_pos(obj) {
	var catid = obj.value;
	if (catid == 0) {
		return false;
	}
	var hash = '<?php echo $_GET['pc_hash']?>';
	$('#posid').html('<img src="<?php echo IMG_PATH.'msg_img/loading.gif';?>">');
	$.get("index.php", {m:'video', c:'video', a:'public_get_pos', catid:catid, tm:Math.random(), pc_hash:hash}, function (data) {
		if (data) {
			$('#posid').html(data);
		} else {
			alert('<?php echo L('check_choose_cat')?>');
		}
	} );
}

$('#searchform').submit(function (){
	if ($('#channelid').val()=='' && $('#userid').val()=='') {
		alert('<?php echo L('check_choose_cha_');?>');
		return false;
	}
	if ($('#catid').val()=='') {
		alert('<?php echo L('check_choose_cat_');?>');
		return false;
	} 
	return true;
});
//-->
</script>