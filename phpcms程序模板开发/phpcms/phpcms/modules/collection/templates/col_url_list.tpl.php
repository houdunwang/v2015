<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li class="on" id="tab_1"><?php echo L('url_list')?></li>
</ul>
<div class="content pad-10" id="show_div_1" style="height:auto">
<b><?php echo L('url_list')?></b>：<?php echo $url_list;?><br><br>
<?php echo L('in_all')?>： <?php echo $total?> <?php echo L('all_count_msg')?>：<?php echo $re;?><?php echo L('import_num_msg')?><?php echo $total-$re;?>
<br><br>
<?php if (is_array($url))foreach ($url as $v):?>
<?php echo $v['title'].'<br>'.$v['url'];?>
<hr size="1" />
<?php endforeach;?>

<?php if ($total_page > $page) {
	echo  "<script type='text/javascript'>location.href='?m=collection&c=node&a=col_url_list&page=".($page+1)."&nodeid=$nodeid&pc_hash=".$_SESSION['pc_hash']."'</script>";
} else {?>
	<script type="text/javascript">
	window.top.art.dialog({id:'test'}).close();
	window.top.art.dialog({id:'test',content:'<h2><?php echo L('collection_success')?></h2><span style="fotn-size:16px;"><?php echo L('following_operation')?></span><br /><ul style="fotn-size:14px;"><li><a href="?m=collection&c=node&a=col_content&nodeid=<?php echo $nodeid?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="right"  onclick="window.top.art.dialog({id:\'test\'}).close()"><?php echo L('following_operation_1')?></a></li><li><a href="?m=collection&c=node&a=manage&menuid=957&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="right" onclick="window.top.art.dialog({id:\'test\'}).close()"><?php echo L('following_operation_2')?></a></li></ul>',width:'400',height:'200'});
	
	</script>
<?php }?>
</div>
</div>
</div>
</body>
</html>