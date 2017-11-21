<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#title").formValidator({onshow:"<?php echo L('input').L('video_title');?>",onfocus:"<?php echo L('video_title_not_empty');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('video_title_not_empty');?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=video&c=video&a=edit&vid=<?php echo $info['videoid']?>" method="post" id="myform">
<table width="100%" class="table_form">
<tr>
<td width="120"><?php echo L('title');?></td> 
<td><input type="text" name="title" size="40" value="<?php echo $info['title'];?>" id="title"><span id="balance"><span></td>
</tr>
<tr>
<td width="120"><?php echo L('video_description')?></td> 
<td><textarea id="description" name="description" rows="5" cols="50"><?php echo $info['description']?></textarea></td>
</tr>
<tr>
<td width="120"><?php echo L('tags');?></td> 
<td><input type="text" id="keywords" name="keywords"  size="30" value="<?php echo $info['keywords']?>"> <?php echo L('separated_by_spaces');?></td>
</tr>
</table>
<div class="bk15"></div>
<input type="hidden" name="vid" id="vid" value="<?php echo $info['vid'];?>">
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