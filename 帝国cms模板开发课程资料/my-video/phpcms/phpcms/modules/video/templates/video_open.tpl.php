<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<div class="explain-col search-form">
<?php echo L('subscribe_notic');?>
</div>
<link href="<?php echo CSS_PATH?>snda_css/snda_login.css" rel="stylesheet" type="text/css" />
<!--增加盛大通行证登录-->
<div id="content">
<div class="wrapper">
<div id="login">
<ul>
<li class="passport">
<div class="title hideText">
<?php echo L('login_to_snda');?>
</div>
<iframe id="ifrmLogin" scrolling="no" frameborder="0" src="http://login.sdo.com/sdo/Login/LoginFrame.php?CSSURL=http://juhe.phpcms.cn/skins/default/register/sdo.css&amp;returnURL=http%3A%2F%2Fjuhe.phpcms.cn%2Fregister%2Findex%2Flog_get_ticket%2Fuser_back%2F<?php echo $user_back;?>%2Fpc_hash%2F<?php echo $_GET['pc_hash'];?>%2F&amp;appId=329&amp;areaId=-1&target=iframe">
</iframe>
<div class="links">
<a href="http://login.sdo.com/sdo/LoginEx/forget_pwd.php" target="_blank"><?php echo L('forget_password');?></a> &nbsp; | &nbsp; <a href="http://register.sdo.com" target="_blank"><?php echo L('reg_to_snda');?> &gt;</a>
</div>
</li>
<li class="account">
<div class="title hideText">
<?php echo L('reg_to_snda');?>
</div> 
</li>
</ul>
</div>
<div id="register">
<div class="title hideText">
<?php echo L('reg_new_member');?>
</div>
<div class="btn-register blockTextLink">
<a href="?m=video&c=video&a=complete_info&pc_hash=<?php echo $_GET['pc_hash'];?>"><?php echo L('complete_info_open');?> &gt;</a>
</div>
</div>
<div class="clear">
</div>
<div id="layer-forgot" class="layer">
<div class="btn-close" onclick="login.hide_layer();">
</div>
<div class="text">
老账号和子帐号找回密码，<br>
请 &nbsp; <a href="#" id="online">联系在线客服</a>
</div>
</div>
</div>
</div>


</body>
</html>