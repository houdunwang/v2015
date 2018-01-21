<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="bk15"></div>
<link href="<?php echo CSS_PATH?>progress_bar.css" rel="stylesheet" type="text/css" />
<div class="pad-lr-10">
<div id="msg"><?php echo L("peed_your_server")?></div>
<?php 
$i = 0;
foreach ($this->point as $v) :
$r = $this->db->get_one(array('id'=>$v), 'name');
echo '<b>'.$r['name'].'</b><span class="progress_status" id="status_'.$i.'"><img src="'.IMG_PATH.'msg_img/loading.gif"> '.L("are_release_ing").' </span>';
?>
<div class="progress_bar"><div id="progress_bar_<?php echo $i?>" class="p_bar"></div></div>
<iframe id="iframe_<?php echo $i?>" src="" width="0" height="0"></iframe>
<script type="text/javascript">$(function(){setTimeout("iframe(<?php echo $i?>, '?m=release&c=index&a=public_sync&id=<?php echo $i?>&ids=<?php echo $ids?>&statuses=<?php echo $statuses?>')", 1000)})</script>
<br>
<?php $i++;endforeach;?>
<h5><?php echo L("remind")?></h5>
<ul>
<li><?php echo L("remind_message")?></li>
</ul>
</div>

<script type="text/javascript">
<!--
window.top.$('#display_center_id').css('display','none');
function progress(id, val) {
	var width = $('#progress_bar_'+id).parent('div').width();
	var block = width/100*val;
	$('#progress_bar_'+id).width(block);
}
function iframe(id, url) {
	$('#iframe_'+id).attr('src', url);
}
//-->
</script>
</body>
</html>