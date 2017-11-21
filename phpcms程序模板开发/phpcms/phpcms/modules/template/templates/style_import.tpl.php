<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<form action="?m=template&c=style&a=import" method="post" id="myform" enctype="multipart/form-data">
<div>
	<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('mode')?>：</th>
    <td class="y-bg"><input type="radio" name="type" value="1" checked /> <?php echo L('upload_file')?> <input type="radio" name="type" value="2"/> <?php echo L('enter_coad')?></td>
  </tr>
  <tbody id="upfile">
  <tr>
    <th width="80"><?php echo L('upload_file')?>：</th>
    <td class="y-bg"><input type="file" class="input-text" name="file"/> <?php echo L('only_allowed_to_upload_txt_files')?></td>
  </tr>
  </tbody>
    <tbody id="code" style="display: none">
    <tr>
    <th width="80" valign="top"><?php echo L('enter_coad')?>：</th>
    <td class="y-bg"><textarea name="code" style="width:386px;height:178px;"></textarea></td>
  </tr>
    </tbody>
</table>
<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</div>
</form>
</div>
<script type="text/javascript">
<!--
$(function(){$("input[type='radio'][name='type']").click(function(){
	if ($(this).val()==1) {
		$('#upfile').show();
		$('#code').hide();
	} else{
		$('#code').show();
		$('#upfile').hide();
	}
})})
//-->
</script>
</body>
</html>