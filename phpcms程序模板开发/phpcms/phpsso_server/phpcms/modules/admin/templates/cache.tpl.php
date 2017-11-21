<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('clean_cache');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('clean_cache')?></h2>

	<div class="content-menu ib-a blue line-x">
		<em>
		<?php echo L('cache_size')?>:<span id='filesize'><?php echo sizecount($applistinfo['filesize'])?></span> |
		<?php echo L('last_modify_time')?>:<span id='filemtime'><?php echo date('Y-m-d H:i:s', $applistinfo['filemtime'])?></span>
		</em>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript:clearcache('applist');" class="on">
		<em><?php echo L('clean_applist_cache')?></em></a>
	</div>
	
</div>
<div class="table-list pad-lr-10">

</div>

<script language="JavaScript">
<!--
function clearcache(type) {
	$.getJSON("?m=admin&c=cache&a=ajax_clear&radom="+Math.random(), {type:type},
	function(data){
		if (data) {
			$('#filesize').html('<font color=red>'+data.filesize+'</font>');
			$('#filemtime').html('<font color=red>'+data.filemtime+'</font>');
		}
		parent.showloading();
	});
}
//-->
</script>
</body>
</html>
