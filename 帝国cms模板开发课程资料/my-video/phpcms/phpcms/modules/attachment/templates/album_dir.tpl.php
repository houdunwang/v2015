<?php
defined('IN_PHPCMS') or exit('No permission resources.');
$show_header = $show_scroll = 1;
include $this->admin_tpl('header','attachment');
?>

<link href="<?php echo JS_PATH?>swfupload/swfupload.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo JS_PATH?>jquery.imgpreview.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var obj=$("#imgPreview a[rel]");
		if(obj.length>0) {
			$('#imgPreview a[rel]').imgPreview({
				srcAttr: 'rel',
			    imgCSS: { width: 200 }
			});
		}
	});	
</script>
<div class="pad-lr-10">
<div class="table-list">
<table width="100%" cellspacing="0" id="imgPreview">
<tr>
<td align="left"><?php echo L("local_dir")?>：<?php echo $local?></td>
</tr>
<?php if ($dir !='' && $dir != '.'):?>
<tr>
<td align="left"><a href="<?php echo '?m=attachment&c=attachments&a=album_dir&dir='.stripslashes(dirname($dir))?>"><img src="<?php echo IMG_PATH?>folder-closed.gif" /><?php echo L("parent_directory")?></td></a>
</tr>
<?php endif;?>
<?php 
if(is_array($list)):
	foreach($list as $v):
	$filename = basename($v);
?>
<tr>
<?php if (is_dir($v)) {
	echo '<td align="left"><img src="'.IMG_PATH.'folder-closed.gif" /> <a href="?m=attachment&c=attachments&a=album_dir&dir='.(isset($_GET['dir']) && !empty($_GET['dir']) ? stripslashes($_GET['dir']).'/' : '').$filename.'"><b>'.$filename.'</b></a></td>';
} else {
	echo '<td align="left" onclick="javascript:album_cancel(this)"><img src="'.file_icon($filename,'gif').'" /> <a href="javascript:;" rel="'.$url.$filename.'" title="'.$filename.'">'.$filename.'</a></td>';
}?>
</tr>
<?php 
	endforeach;
endif;
?>
</table>
</div>
</div>
</body>
<script type="text/javascript">
$(document).ready(function(){
	set_status_empty();
});	
function set_status_empty(){
	parent.window.$('#att-status').html('');
	parent.window.$('#att-name').html('');
}
function album_cancel(obj){
	var src = $(obj).children("a").attr("rel");
	var filename = $(obj).children("a").attr("title");
	if($(obj).hasClass('on')){
		$(obj).removeClass("on");
		var imgstr = parent.window.$("#att-status").html();
		var length = $("a[class='on']").children("a").length;
		var strs = filenames = '';
		for(var i=0;i<length;i++){
			strs += '|'+$("a[class='on']").children("a").eq(i).attr('rel');
			filenames += '|'+$("a[class='on']").children("a").eq(i).attr('title');
		}
		parent.window.$('#att-status').html(strs);
		parent.window.$('#att-name').html(filenames);
	} else {
		var num = parent.window.$('#att-status').html().split('|').length;
		var file_upload_limit = '<?php echo $file_upload_limit?>';
		$(obj).addClass("on");
		parent.window.$('#att-status').append('|'+src);
		parent.window.$('#att-name').append('|'+filename);
	}
}
</script>
</html>