<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>

<div style="padding: 10px 0px 0px 10px;"><?php echo L('click_copy_code')?>：
&nbsp;<br><textarea ondblclick="copy_text(this)" style="width: 96%;height:300px" /><?php echo stripslashes ($tag)?></textarea><div>

<script type="text/javascript">
<!--
function copy_text(matter){
	matter.select();
	js1=matter.createTextRange();

	js1.execCommand("Copy");

	alert('<?php echo L('copy_code');?>');
}
//-->
</script>