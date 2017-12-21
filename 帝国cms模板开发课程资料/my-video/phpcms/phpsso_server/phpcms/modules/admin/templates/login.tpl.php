<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo L('phpsso')?></title>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<style type="text/css">
*{margin:0;padding:0;border:0; vertical-align:middle}
body{background:#3a6ea5;}
img{ vertical-align:middle}
.login_box{width:580px;height:320px;position:absolute;top:50%;left:50%;margin-left:-290px;margin-top:-160px;}
.login_box_top{background:url(<?php echo IMG_PATH?>login_box_top.gif) no-repeat;width:580px;height:13px; overflow:hidden}
.login_box_mid{background:url(<?php echo IMG_PATH?>login_box_mid.gif) repeat-y;width:580px;height:289px;}
.login_box_bot{background:url(<?php echo IMG_PATH?>login_box_bot.gif) no-repeat;width:580px;height:13px;}
.login_logo{float:left;display:inline; background:url(<?php echo IMG_PATH?>login_logo.gif) no-repeat;width:97px;height:67px;margin:30px 20px 0px 60px;}
.logo_content{float:left;width:360px;overflow:hidden;margin-top:36px;}
.logo_content .tit{ margin:0 0 30px}
.logo_content p{color:#464646;}
.login_input{background:url(<?php echo IMG_PATH?>login_input.gif) no-repeat;height:19px;border:1px solid #ccc;padding:2px 0px 2px 4px;font-family: Arial, Helvetica, sans-serif}
.login_list li{margin-bottom:10px;display:inline;font-size:14px;width:360px;float:left; line-height:24px}
.login_list li label{display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline; width:55px; font-family:"宋体"; font-size:14px; }
.login_button{ background:url(<?php echo IMG_PATH?>login_button.gif) no-repeat;width:60px;height:28px;border:none; text-align:center; cursor:pointer;font-size:14px;margin-left:55px;}
</style>
</head>
<body>
<div class="login_box">
<div class="login_box_top"></div>
<div class="login_box_mid">
<div class="login_logo"></div>
<div class="logo_content">
<div class="tit"><img src="<?php echo IMG_PATH?>guanli_center.gif" /></div>
<form action="?m=admin&c=login&a=logind" method="post">
<input type="hidden" name="forward" value="<?php echo urlencode($_GET['forward'])?>" />
<ul class="login_list">
<li><label><?php echo L('username')?></label><input type="text" class="login_input" name="username" id="username" size="24" /></li>
<li><label><?php echo L('password')?></label><input type="password" class="login_input" name="password" id="password" size="24"/></li>
<li><label><?php echo L('checkcode')?></label><input name="code" type="text" class="login_input" size="4" /><span>&nbsp;<?php echo form::checkcode('code_img', '4', '14', 84, 24)?></span></li>
<li><input type="submit" class="login_button"  value="<?php echo L('loging')?>"/></li>
</ul>
</form>
</div>
<script type="text/javascript">
$(function(){
	$('#username').focus();	
})
</script>
</div>
<div class="login_box_bot"></div>
</div>

</body>
</html>