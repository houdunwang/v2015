<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET?>" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo L('alert_message')?></title>
<style type="text/css">
<!--
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
.showMsg h5{background-image: url(<?php echo IMG_PATH?>msg_img/msg.png);background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:10px 12px 10px 45px; font-size:14px; height:100px; line-height:96px}
.showMsg .bottom{ background:#e4ecf7; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
.showMsg .ok,.showMsg .guery{background: url(<?php echo IMG_PATH?>msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
<script type="text/javaScript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="JavaScript" src="<?php echo JS_PATH?>admin_common.js"></script>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5><?php echo L('alert_message')?></h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;">
    	<?php echo $msg?>
    </div>
    <div class="bottom">
    <?php if($url_forward=='goback' || $url_forward=='') {?>
	<a href="javascript:history.back();" ><?php echo L('go_history')?></a>
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value=" 关闭 " onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>
	
	<?php } elseif($url_forward) { ?>
	<a href="<?php echo url($url_forward, 1)?>"><?php echo L('jump_message')?></a>
	<script language="javascript">setTimeout("redirect('<?php echo url($url_forward, 1)?>');",<?php echo $ms?>);</script> 
	<?php }?>
	<?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
        </div>
</div>

</body>
</html>