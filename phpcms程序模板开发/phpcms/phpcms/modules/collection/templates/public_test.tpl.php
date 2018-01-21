<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li class="on" id="tab_1"><?php echo L('url_list')?></li>
</ul>
<div class="content pad-10" id="show_div_1" style="height:auto">
<?php foreach ($url as $key=>$val):?>
<?php echo $val['title']?><br>
<div style="float:right"><a href="javascript:void(0)" onclick="show_content('<?php echo urlencode($val['url'])?>')"><span><?php echo L('view')?></span></a></div><?php echo $val['url']?>
<hr size="1" />
<?php endforeach;?>
</div>
</div>
</div>
<script type="text/javascript"> 
<!--
function show_content(url) {
	art.dialog({id:'test',content:'<?php echo L('loading')?>',width:'100',height:'30', lock:true});
	$.get("?m=collection&c=node&a=public_test_content&nodeid=<?php echo $nodeid?>&url="+url+'&pc_hash=<?php echo $_SESSION['pc_hash']?>', function(data){art.dialog({id:'test'}).close();
	art.dialog({title:'<?php echo L('content_view')?>',id:'test',content:'<textarea rows="26" cols="90">'+data+'</textarea>',width:'500',height:'400', lock:false});});
	
}
window.top.$('#display_center_id').css('display','none');
//-->
</script>

</body>
</html>