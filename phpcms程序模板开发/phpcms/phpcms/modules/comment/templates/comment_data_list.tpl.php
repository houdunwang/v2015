<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

 <div class="comment_button"><a href="?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid=<?php echo $commentid?>&hot=0"<?php if (empty($hot)) {?> class="on"<?php }?>>最新</a> <a href="?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid=<?php echo $commentid?>&hot=1"<?php if ($hot==1) {?> class="on"<?php }?>>最热</a></div> 	
 <div class="btn"><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label></div>
 
 <form action="?" method="get">
 <input type="hidden" name="m" value="comment">
  <input type="hidden" name="c" value="check">
   <input type="hidden" name="a" value="ajax_checks">
    <input type="hidden" name="type" value="-1">
    <input type="hidden" name="form" value="1">
    <input type="hidden" name="commentid" value="<?php echo $commentid?>">
<div class="comment">
<?php if(is_array($list)) foreach($list as $v) :
?>
<div  id="tbody_<?php echo $v['id']?>">
<h5 class="title fn" ><span class="rt"><input  class="button"  type="button" value="<?php echo L('delete')?>" onclick="check(<?php echo $v['id']?>, -1, '<?php echo $v['commentid']?>')" />
</span><input type="checkbox" name="id[]" value="<?php echo $v['id']?>"><?php echo direction($v['direction'])?> <?php echo $v['username']?> (<?php echo $v['ip']?>) <?php echo L('chez')?> <?php echo format::date($v['creat_at'], 1)?> <?php echo L('release')?> <?php echo L('support')?>：<?php echo $v['support']?></h5>
    <div class="content">
    	<pre><?php echo $v['content']?></pre>
    </div>
    <div class="bk20 hr mb8"></div>
</div>
<?php endforeach;?>
</div>
 <div class="btn"><label for="check_box"><input type="checkbox"  onclick="selectall('id[]');" id="check_box" style="width:0px;height: 0px;" /><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" onclick="return confirm('<?php echo L('are_you_sure_you_want_to_delete')?>')" class="button" value="<?php echo L('delete')?>" /></div>
 </form>
<div id="pages"><?php echo $pages;?></div>
</div>
<script type="text/javascript">
<?php if(!isset($_GET['show_center_id'])) {?> window.top.$('#display_center_id').css('display','none');<?php }?>
function check(id, type, commentid) {
	if(type == -1 && !confirm('<?php echo L('are_you_sure_you_want_to_delete')?>')) {
		return false;
	}
	$.get('?m=comment&c=check&a=ajax_checks&id='+id+'&type='+type+'&commentid='+commentid+'&pc_hash='+pc_hash+'&'+Math.random(), function(data){if(data!=1){if(data==0){alert('<?php echo L('illegal_parameters')?>')}else{alert(data)}}else{$('#tbody_'+id).remove();}});
}
</script>
</body>
</html>