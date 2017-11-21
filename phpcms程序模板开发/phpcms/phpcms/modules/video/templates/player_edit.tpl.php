<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript" src="<?php echo JS_PATH;?>video/swfobject.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>video/swfobject2.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
var js4swf = {
    onInit: function(list){
        // 初始化时调用, 若 list.length > 0 代表有可续传文件
        // [{file}, {file}]
		if(list.length > 0) {
		    var length = list.length-1;
			$('#list_name').html("<?php echo L('file');?>"+list[length].name+"<?php echo L('failed_uplaod_choose_again');?>");
		}
        this.showMessage('init', list);
    },
    onSelect: function(files){
        // 选中文件后调用, 返回文件列表
        // [{file}, {file}]
        this.showMessage('select', files);
    },
    onSid: function(evt){
        // 获得 sid 后返回, 更新 sid 用 (key, sid, name, type, size)
		$('#title').val(evt.name);
		var ku6vid = evt.vid;
		$.get('index.php', {m:'video', c:'vid', a:'check', vid:ku6vid});
        this.showMessage('sid', evt);
    },
    onStart: function(){
        // 开始上传 (选择文件后自动开始)
        this.showMessage('start');
    },
    onCancel: function(){
        // 上传取消事件

        this.showMessage('cancel');
    },
    onProgress: function(evt){
        // 上传进度事件 (bytesLoaded, bytesTotal, speed) m=1 时没有这事件
        this.showMessage('progress', evt);
    },
    onComplete: function(evt){
        // 上传完成事件 (包含文件信息和完成后返回数据(data))
		$('#vid').val(evt.vid);
		//document.getElementById('frm').submit();
        this.showMessage('complete', evt);
        
    },
    onWarn: function(evt){
        // 报错事件 (key, message)
        //this.showMessage('warn', evt);
		alert(evt.msg);
    },
    showMessage: function(){
        console.log(arguments);
    }
};
function checkform() {
	if($('#vid').val()=='0') {
		alert('<?php echo L('no_choose_video_or_uploading');?>');
		return false;
	}
	if($('#title').val()=='') {
		alert('<?php echo L('please_input_title');?>');
		$('#title').focus();
		return false;
	}
}
//-->
</SCRIPT>
<script type="text/javascript">
var flashvars = { m: "1", u: "<?php echo $flash_info['userid'];?>", ctime: "<?php echo $flash_info['passport_ctime'];?>", sig:"<?php echo $flash_info['passport_sig'];?>", c: "vms", t: "1", n: "js4swf", k: "190000" ,ms:"39",s: "8000000"};
var params = { allowScriptAccess: "always" , wmode: "transparent"};
var attributes = { };
//swfobject.embedSWF("http://player.ku6cdn.com/default/podcast/upload/201104261840/ku6uploader.swf", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
swfobject.embedSWF("<?php echo $flash_info['flashurl'];?>", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
</script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#title").formValidator({onshow:"<?php echo L('input').L('video_title');?>",onfocus:"<?php echo L('video_title_not_empty');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('video_title_not_empty');?>"});
	$("#description").formValidator({onshow:"<?php echo L('input').L('video_description');?>",onfocus:"<?php echo L('video_description_not_empty');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('video_description_not_empty');?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=video&c=video&a=<?php echo $_GET['a']?>" method="post" id="myform" enctype="multipart/form-data" onsubmit="return checkform()"><input type="hidden" name="userupload" value="1">
<table width="100%" class="table_form">
	<tr>
		<td width="120"><?php echo L('choose_videoes');?></td> 
		<td><div id="ku6uploader"></div><BR><span id="list_name" style="color:red"></span></td>
	</tr>
	<tr>
		<td width="120"><?php echo L('title');?></td> 
		<td><input type="text" name="title" size="40" value="" id="title"><span id="balance"><span></td>
	</tr>
	<tr>
		<td width="120"><?php echo L('video_description')?></td> 
		<td><textarea id="description" name="description" rows="5" cols="50"></textarea></td>
	</tr>
	<tr>
		<td width="120"><?php echo L('tags');?></td> 
		<td><input type="text" id="keywords" name="keywords"  size="30" value=""> <?php echo L('separated_by_spaces');?></td>
	</tr>
</table>
<div class="bk15"></div>
<input type="hidden" name="vid" id="vid" value="0">
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>
</body>
</html>
<script type="text/javascript">

$(document).ready(function() {
	$("#paymethod input[type='radio']").click( function () {
		if($(this).val()== 0){
			$("#rate").removeClass('hidden');
			$("#fix").addClass('hidden');
			$("#rate input").val('0');
		} else {
			$("#fix").removeClass('hidden');
			$("#rate").addClass('hidden');
			$("#fix input").val('0');
		}	
	});
});
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>