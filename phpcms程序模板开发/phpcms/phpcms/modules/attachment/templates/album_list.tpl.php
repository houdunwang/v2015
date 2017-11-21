<?php 
	$show_header = $show_validator = $show_scroll = 1; 
	include $this->admin_tpl('header', 'attachment');
?>
<link href="<?php echo JS_PATH?>swfupload/swfupload.css" rel="stylesheet" type="text/css" />
<form name="myform" action="" method="get" >
<input type="hidden" value="attachment" name="m">
<input type="hidden" value="attachments" name="c">
<input type="hidden" value="album_load" name="a">
<input type="hidden" value="<?php echo $file_upload_limit?>" name="info[file_upload_limit]">
<div class="lh26" style="padding:10px 0 0">
<label><?php echo L('name')?></label>
<input type="text" value="" class="input-text" name="info[filename]"> 
<label><?php echo L('date')?></label>
<?php echo form::date('info[uploadtime]')?>
<input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
</div>
</form>
<div class="bk20 hr"></div>
<ul class="attachment-list"  id="fsUploadProgress">
<?php foreach($infos as $r) {?>
<li>
	<div class="img-wrap">
		<a href="javascript:;" onclick="javascript:album_cancel(this,'<?php echo $r['aid']?>','<?php echo $this->upload_url.$r['filepath']?>')"><div class="icon"></div><img src="<?php echo $r['src']?>" width="<?php echo $r['width']?>" path="<?php echo $this->upload_url.$r['filepath']?>" title="<?php echo $r['filename']?>"/></a>
	</div>
</li>
<?php } ?>
</ul>
 <div id="pages" class="text-c"> <?php echo $pages?></div>
<script type="text/javascript">
$(document).ready(function(){
	set_status_empty();
});	
function set_status_empty(){
	parent.window.$('#att-status').html('');
	parent.window.$('#att-name').html('');
}
function album_cancel(obj,id,source){
	var src = $(obj).children("img").attr("path");
	var filename = $(obj).children("img").attr("title");
	if($(obj).hasClass('on')){
		$(obj).removeClass("on");
		var imgstr = parent.window.$("#att-status").html();
		var length = $("a[class='on']").children("img").length;
		var strs = filenames = '';
		$.get('index.php?m=attachment&c=attachments&a=swfupload_json_del&aid='+id+'&src='+source);
		for(var i=0;i<length;i++){
			strs += '|'+$("a[class='on']").children("img").eq(i).attr('path');
			filenames += '|'+$("a[class='on']").children("img").eq(i).attr('title');
		}
		parent.window.$('#att-status').html(strs);
		parent.window.$('#att-name').html(filenames);
	} else {
		var num = parent.window.$('#att-status').html().split('|').length;
		var file_upload_limit = '<?php echo $file_upload_limit?>';
		if(num > file_upload_limit) {alert('不能选择超过'+file_upload_limit+'个附件'); return false;}
		$(obj).addClass("on");
		$.get('index.php?m=attachment&c=attachments&a=swfupload_json&aid='+id+'&src='+source);
		parent.window.$('#att-status').append('|'+src);
		parent.window.$('#att-name').append('|'+filename);
	}
}
</script>