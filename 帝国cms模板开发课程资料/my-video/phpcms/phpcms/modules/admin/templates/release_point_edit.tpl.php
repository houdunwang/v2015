<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L('input').L('release_point_name')?>",onfocus:"<?php echo L('input').L('release_point_name')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('release_point_name')?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=release_point&a=public_name&id=<?php echo $id?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('release_point_name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed();
		$("#host").formValidator({onshow:"<?php echo L('input').L('server_address')?>",onfocus:"<?php echo L('input').L('server_address')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('server_address')?>"});
		$("#port").formValidator({onshow:"<?php echo L('input').L('server_port')?>",onfocus:"<?php echo L('input').L('server_port')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('server_port')?>"}).regexValidator({datatype:'enum',regexp:'intege1',onerror:'<?php echo L('server_ports_must_be_integers')?>'});
		$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('input').L('username')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('username')?>"});
		$("#password").formValidator({onshow:"<?php echo L('input').L('password')?>",onfocus:"<?php echo L('input').L('password')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('password')?>"});
		
	})
//-->
</script>
<div class="pad-10">
<form action="?m=admin&c=release_point&a=edit&id=<?php echo $id?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('release_point_name')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="name" id="name" size="30" value="<?php echo $data['name']?>" /></td>
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('ftp_server')?></legend>
	<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('server_address')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="host" id="host" size="30" value="<?php echo $data['host']?>" /></td>
  </tr>
   <tr>
    <th width="80"><?php echo L("server_port")?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="port" id="port" size="30" value="<?php echo $data['port']?>" /></td>
  </tr>
  <tr>
    <th><?php echo L('username')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="username" id="username" size="30" value="<?php echo $data['username']?>" /></td>
  </tr>
    <tr>
    <th><?php echo L('password')?>：</th>
    <td class="y-bg"><input type="password" class="input-text" name="password" id="password" size="30"  value="<?php echo $data['password']?> "/></td>
  </tr>
    <tr>
    <th><?php echo L('path')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="path" id="path" size="30" value="<?php echo $data['path']?>" /></td>
  </tr>
      <tr>
    <th><?php echo L('passive_mode')?>：</th>
    <td class="y-bg"><label><input type="checkbox" class="inputcheckbox" name="pasv" id="pasv" value="1" size="30"<?php if ($data['pasv']){echo ' checked';}?> /><?php echo L('yes')?></label></td>
  </tr>
    <tr>
    <th><?php echo L('ssl_connection')?>：</th>
    <td class="y-bg"><label><input type="checkbox" class="inputcheckbox" name="ssl" id="ssl" value="1" size="30"<?php if ($data['ssl']){echo ' checked';}?> <?php if(!$this->ssl){ echo 'disabled';}?> /><?php echo L('yes')?></label> <?php if(!$this->ssl){ echo '<span style="color:red">'.L('your_server_will_not_support_the_ssl_connection').'</a>';}?></td>
  </tr>
    </tr>
    <tr>
    <th><?php echo L('test_connections')?>：</th>
    <td class="y-bg"><input type="button" class="button" onclick="ftp_test()" value="<?php echo L('test_connections')?>" /></td>
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</div>
</div>
<script type="text/javascript">
<!--
function ftp_test() {
	if(!$.formValidator.isOneValid('host')) {
		$('#host').focus();
		return false;
	}
	if(!$.formValidator.isOneValid('port')) {
		$('#port').focus();
		return false;
	}
	if(!$.formValidator.isOneValid('username')) {
		$('#username').focus();return false;
	}
	if(!$.formValidator.isOneValid('password')) {
		$('#password').focus();return false;
	}
	var host = $('#host').val();
	var port = $('#port').val();
	var username = $('#username').val();
	var password = $('#password').val();
	var pasv = $("input[type='checkbox'][name='pasv']:checked").val();
	var ssl = $("input[type='checkbox'][name='ssl']:checked").val();
	$.get("?",{m:'admin',c:'release_point',a:'public_test_ftp', host:host,port:port,username:username,password:password,pasv:pasv,ssl:ssl}, function(data){
		if (data==1){
			alert('<?php echo L('ftp_server_connections_success')?>');
		} else {
			alert(data);
		}
	})
}
//-->
</script>
</form>
</body>
</html>