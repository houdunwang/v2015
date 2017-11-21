<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
<?php if($totalpage==0):?>
parent.progress(<?php echo $id?>, 100);
parent.$('#status_<?php echo $id?>').html('<?php echo L("done")?>');
<?php else:?>
<?php $progress = intval($page / $totalpage * 100);?>
parent.progress(<?php echo $id?>, <?php echo $progress?>);
parent.$('#status_<?php echo $id?>').html('<img src="<?php echo IMG_PATH?>msg_img/loading.gif"> <?php echo L("are_release_ing")?> <?php  echo $progress?>%');
<?php if ($page < $totalpage) : ?>
location.href='?m=release&c=index&a=public_sync&page=<?php echo $page+1;?>&total=<?php echo $total?>&id=<?php echo $id?>&statuses=<?php echo $statuses?>';
<?php else:?>
parent.$('#status_<?php echo $id?>').html('<?php echo L("done")?>');
<?php endif;endif;?>
//-->
</script>
</body>
</html>