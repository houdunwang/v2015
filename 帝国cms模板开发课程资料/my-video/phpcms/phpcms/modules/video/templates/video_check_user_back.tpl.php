<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	 $("#email").formValidator({onshow:"请输入E-mail",onfocus:"请输入E-mail",oncorrect:"E-mail格式正确"}).regexValidator({regexp:"email",datatype:"enum",onerror:"E-mail格式错误"});
})
//-->
</script>
<div class="pad-10">
<div class="explain-col search-form">
<font color="#cc0000"><?php echo L('1、当前域名已经登记，请输入初始完善资料时填写的EMAIL，进行验证码验证！<br> 2、你也可以直接填写对应的配置信息，进行提交！');?></font>
</div>

<div class="common-form">
<form name="myform" action="?m=video&c=video&a=check_user_back&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('开通方式1：邮箱验证');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('email');?></td> 
		<td>
		<input name="email"  type="text" id="email"  size="40" value="">
		<input type="button" onclick="send_code()" value="<?php echo L('发送验证码')?>" class="button" name="sendcode" id="sendcode"> 
		</td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('验证码');?><div id="all"></div>  </td> 
		<td><input type="text" name="code" size="40" value="" id="code"></td>
	</tr> 
	<tr>
		<td  width="120"></td> 
		<td><input name="dosubmit_new" type="submit" value=" <?php echo L('submit')?> " class="button" id="dosubmit_new"></td>
	</tr> 
</table>
</fieldset>

</form>

<!--填写skey_sn-->
<br>
<form name="myform2" action="?m=video&c=video&a=setting&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform2">
<fieldset>
	<legend><?php echo L('开通方式2：配置完善');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('vms_sn');?></td> 
		<td><input name="setting[sn]"  type="text" id="sn"  size="40" value=""> </td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('vms_skey');?></td> 
		<td><input type="text" name="setting[skey]" size="40" value="" id="skey"></td>
	</tr> 
	<tr>
		<td  width="120"><?php echo L('video_api_url');?> </td> 
		<td><?php echo APP_PATH;?>api.php?op=video_api</td>
	</tr>
	<tr>
		<td  width="120"></td> 
		<td><input name="dosubmit" type="submit" value=" <?php echo L('submit')?> " class="button" id="dosubmit">
</td>
	</tr> 
</table>
</fieldset>

</form>
</div>
<script type="text/javascript">
<!--
function send_code() {
	var email = $("#email").val(); 
	var pc_hash = "<?php echo $_GET['pc_hash'];?>";
	if(email==''){
		alert('email 不能为空！');return false;
	}
	$.get('?m=video&c=video&a=send_code&pc_hash='+pc_hash,{ email:email,random:Math.random()}, function(data){
		if(data==1) { 
			$("#sendcode").attr("disabled", true);
			$("#sendcode").val('验证码已发送!');
			alert('验证码发送成功，请查收！'); 
		}else{
  			alert("验证码发送失败，请检测邮箱是否正确！");
		}
	}); 
} 
//-->
</script>
</body>
</html>