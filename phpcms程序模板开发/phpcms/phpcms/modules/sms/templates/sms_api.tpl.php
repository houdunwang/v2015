<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="explain-col search-form">
<?php if(CHARSET=="gbk") {
	echo iconv('utf-8','gbk',$this->smsapi->get_sms_help());
} else {
	echo $this->smsapi->get_sms_help();
}
?>
</div>

</div>
</div>

</body>
</html>