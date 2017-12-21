<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
<div class="bk10"></div>

<div class="table-list">
<form action="?m=content&c=content&a=clear_data" method="post" name="myform">
<table width="100%" cellspacing="0">
  <input type="hidden" name="dosubmit" value="1"> 
<thead>
<tr>
<th align="center" colspan="2"><?php echo L('please_choose_talbes')?></th>
</tr>
</thead>
<tr>
	<td align="center" width="100"><input name="tables[]" type="checkbox" value="category" class="input-text-c input-text"></td>
	<td><?php echo L('category');?></td>
</tr>
<tr>
	<td align="center"><input name="tables[]" id="model" type="checkbox" value="content" class="input-text-c input-text"></td>
	<td><?php echo L('models')?></td>
</tr>
<tr id="models" class="hidden">
	<td align="center"></td>
	<td><?php foreach($model_arr as $m) {?><label><input type="checkbox" name="model[]" value="<?php echo $m['modelid'];?>" > <?php echo $m['name']?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php }?></td>
</tr>
<tr>
	<td align="center" width="100"><input name="tables[]" type="checkbox" value="video_store" class="input-text-c input-text"></td>
	<td><?php echo L('video_library')?></td>
</tr>
<tr>
	<td align="center" width="100"><input name="tables[]" type="checkbox" value="comment" class="input-text-c input-text"></td>
	<td><?php echo L('comment')?>（<span style="color:#d55"><?php echo L('can_not_recovered')?></span>）</td>
</tr>
<tr>
	<td align="center"></td>
	<td><input type="submit" class="button" value="<?php echo L('clear')?>" ></td>
</tr>
</table>
</form>
</div>
</div>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
	function change_model(modelid) {
		window.location.href='?m=content&c=create_html&a=category&modelid='+modelid+'&pc_hash='+pc_hash;
	}

	$('#model').click(function (){
		if ($('#models').attr('class') == 'hidden'){
			$("[name='model[]']").each(function (i) {
				$(this).attr('checked', true);
			});
			$('#models').removeClass('hidden');
		} else {
			$("[name='model[]']").each(function (i) {
				$(this).attr('checked', false);
			});
			$('#models').addClass('hidden');
		}

	})
//-->
</script>