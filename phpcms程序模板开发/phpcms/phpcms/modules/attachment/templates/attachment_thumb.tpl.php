<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
.attachment-list{ width:480px}
.attachment-list .cu{dispaly:block;float:right; background:url(statics/images/admin_img/cross.png) no-repeat 0px 100%;width:20px; height:16px; overflow:hidden;}
.attachment-list li{ width:120px; padding:0 20px 10px; float:left}
</style>
<div class="pad-10">
<ul class="attachment-list">
	<?php foreach($thumbs as $thumb) {
    ?>
    <li>
            <img src="<?php echo $thumb['thumb_url']?>" alt="<?php echo $thumb['width']?> X <?php echo $thumb['height']?>" width="120" />
            <span class="cu" title="<?php echo L('delete')?>" onclick="thumb_delete('<?php echo urlencode($thumb['thumb_filepath'])?>',this)"></span>
            <?php echo $thumb['width']?> X <?php echo $thumb['height']?>
    </li>
    <?php } ?>
</ul>
</div>
<script type="text/javascript">
<!--
function thumb_delete(filepath,obj){
	 window.top.art.dialog({content:'<?php echo L('del_confirm')?>', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=attachment&c=manage&a=pullic_delthumbs&filepath='+filepath+'&pc_hash=<?php echo $_SESSION[pc_hash]?>',function(data){
				if(data == 1) $(obj).parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
//-->
</script>
</html>