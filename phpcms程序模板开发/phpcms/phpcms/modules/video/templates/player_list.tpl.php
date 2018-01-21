<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">

<form name="myform" id="myform" action="" method="post" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th><?php echo L('player_name')?></th>
            <th><?php echo L('thumb')?></th>
			 <th >style</th>
            <th ><?php echo L('default_player')?></th>
            <th ><?php echo L('auto_play')?></th>
            <th ><?php echo L('auto_replay')?></th>
            <th ><?php echo L('show_player_share');?></th>
            <th ><?php echo L('show_player_elite')?></th>
            <th ><?php echo L('show_sound')?></th>

            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
		
?>   
	<tr>
	<td align="center"><?php echo $info['playername']?><br><br><font color="#ff9900"><?php echo $info['channelname']?></font> </td>
	<td align="center"><img src="<?php echo $info['thumb']?>" width="200" height="160"></td>
	<td align="center"><input type="text" value="<?php echo $info['style']?>" style="width:<?php echo strlen($info['style'])*8;?>px"></td>
	<td align="center" ><img flag='flag<?php echo $info['channelid']?>' onclick="setPlayer('default',this,'<?php echo $info['style']?>',<?php echo $info['channelid']?>);" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['default']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['default']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	<td align="center"><img onclick="setPlayer('auto',this,'<?php echo $info['style']?>');" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['auto']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['auto']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	<td align="center"><img onclick="setPlayer('replay',this,'<?php echo $info['style']?>');" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['replay']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['replay']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	<td align="center"><img onclick="setPlayer('share',this,'<?php echo $info['style']?>');" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['share']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['share']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	<td align="center"><img onclick="setPlayer('show_elite',this,'<?php echo $info['style']?>');" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['show_elite']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['show_elite']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	<td align="center"><img onclick="setPlayer('ssv',this,'<?php echo $info['style']?>');" class="cu" title="<?php echo L('click_setting');?>" src="<?php if($info['ssv']==1) {echo IMG_PATH.'icon/select_icon.png';} elseif($info['ssv']==0) {echo IMG_PATH.'icon/delete.png';} else {echo IMG_PATH.'icon/remove.png';}?>" ></td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>

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
function setPlayer(field,obj,style,channelid) {
	if($(obj).attr('src')=='<?php echo IMG_PATH;?>icon/remove.png') {
		alert('<?php echo L('not_support_attribute');?>');
		return false;
	}
	$.post("?m=video&c=player&a=edit&pc_hash=<?php echo $_GET['pc_hash'];?>",
	{ field: field,dosubmit:1,style:style},
  function(data){
		 $("img[flag='flag"+channelid+"']").each(function() {
  			$(this).attr('src','<?php echo IMG_PATH;?>icon/delete.png');
		});
		if(data=='1') {
			$(obj).attr('src','<?php echo IMG_PATH;?>icon/select_icon.png');
		} else if(data=='0') {
			$(obj).attr('src','<?php echo IMG_PATH;?>icon/delete.png');
		} else {
			alert('<?php echo L('operation_failure');?>');
		}
   }
);
	


}
//-->
</script>