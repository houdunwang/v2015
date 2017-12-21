<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php 
$page_title = L('application_edit');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formValidatorRegex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#name").formValidator({onshow:"<?php echo L('input').L('application_name')?>",onfocus:"<?php echo L('input').L('application_name')?>"}).inputValidator({min:1,max:20,onerror:"<?php echo L('input').L('application_name')?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=applications&a=ajax_name&id=<?php echo $appid?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('application_name').L('exist')?>",onwait : "<?php echo L('connecting_please_wait')?>"}).defaultPassed();

	$("#url").formValidator({onshow:'<?php echo L('application_url_msg')?>',onfocus:'<?php echo L('application_url_msg')?>',tipcss:{width:'400px'}}).inputValidator({min:1,max:255,onerror:'<?php echo L('application_url_msg')?>'}).inputValidator({min:1,max:255,onerror:'<?php echo L('application_url_msg')?>'}).regexValidator({regexp:"http:\/\/(.+)\/$",onerror:'<?php echo L('application_url_msg')?>'}).ajaxValidator({type : "get",url : "",data :"m=admin&c=applications&a=ajax_url&id=<?php echo $appid?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('application_url').L('exist')?>",onwait : "<?php echo L('connecting_please_wait')?>"}).defaultPassed();

	$("#authkey").formValidator({onshow:'<?php echo L('input').L('authkey')?>',onfocus:'<?php echo L('input').L('authkey')?>'}).inputValidator({min:1,max:255,onerror:'<?php echo L('input').L('authkey')?>'});

})
//-->
</script>
<div class="subnav">
<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('application_manage')?></h2>
<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=applications&a=init"><em><?php echo L('application_list')?></em></a><span>|</span> <a href="?m=admin&c=applications&a=add"><em><?php echo L('application_add')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=applications&a=edit&appid=<?php echo $appid?>" method="post" id="myform">
<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('application_name')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="name" value="<?php echo $data['name']?>" id="name" /></td>
  </tr><tr>
    <th><?php echo L('application_url')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="url"  value="<?php echo $data['url']?>" id="url" size="50"/> </td>
  </tr>
  <tr>
    <th><?php echo L('authkey')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="authkey" id="authkey"  value="<?php echo $data['authkey']?>" size="50"/> <input type="button" class="button" name="dosubmit" value="<?php echo L('automatic_generation')?>" onclick="creat_authkey()" /></td>
  </tr>
   <tr>
    <th><?php echo L('type')?>：</th>
    <td class="y-bg"><select name="type" onchange="change_apifile(this.value)">
	<option value="phpcms_v9"<?php if ($data['type']=='phpcms_v9'){echo ' selected';}?>>phpcms_v9</option>
    <option value="phpcms_2008_sp4"<?php if ($data['type']=='phpcms_2008_sp4'){echo ' selected';}?>>phpcms_2008_sp4</option>
    <option value="other"<?php if ($data['type']=='other'){echo ' selected';}?>><?php echo L('other')?></option>
    </select></td>
  </tr>
   <tr>
    <th><?php echo L('application_ip')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="ip" value="<?php echo $data['ip']?>" /> <?php echo L('application_ip_msg')?></td>
  </tr>
   <tr>
    <th><?php echo L('application_apifilename')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="apifilename" id="apifilename" value="<?php echo $data['apifilename']?>" size="50"/></td>
  </tr>
   <tr>
    <th><?php echo L('application_charset')?>：</th>
    <td class="y-bg"><select name="charset">
    <option value="gbk"<?php if ($data['charset']=='gbk'){echo ' selected';}?>>GBK</option>
    <option value="utf-8"<?php if ($data['charset']=='utf-8'){echo ' selected';}?>>utf-8</option>
    </select></td>
  </tr>
    <tr>
    <th><?php echo L('application_synlogin')?>：</th>
    <td class="y-bg"><input type="checkbox" name="synlogin" value="1"<?php if ($data['synlogin']){echo ' checked';}?> /> <?php echo L('yes')?></td>
  </tr>
</table>
<div class="bk15"></div>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" />

</form>

</div>
<script type="text/javascript">
function creat_authkey() {
	var  x="0123456789qwertyuioplkjhgfdsazxcvbnm";
	var  tmp="";
	for(var  i=0;i< 32;i++)  {
	  tmp  +=  x.charAt(Math.ceil(Math.random()*100000000)%x.length);
	}
	$('#authkey').val(tmp);
}

function change_apifile(value) {
	if (value=='phpcms'  && $('#apifilename').val() == '') {
		$('#apifilename').val('?m=api&c=phpsso');
	}
}
</script>

</body>
</html>