<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php 
$page_title = L('add_admin');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('username').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('username').L('between_6_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=admin&c=administrator&a=ajax_username",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('user_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo L('inputpassword')?>",onfocus:"<?php echo L('password_len_error')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password_len_error')?>"});
})
//-->
</script>
<div class="subnav">
<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('admin_manage')?></h2>
<div class="content-menu ib-a blue line-x"><a href="?m=admin&c=administrator&a=init"><em><?php echo L('listadmins')?></em></a><span>|</span> <a href="?m=admin&c=administrator&a=add"  class="on"><em><?php echo L('add_admin')?></em></a></div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=administrator&a=add" method="post" id="myform">
<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('username')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="username" id="username" /></td>
  </tr><tr>
    <th><?php echo L('password')?>：</th>
    <td class="y-bg"><input type="password" class="input-text" name="password" id="password" /></td>
  </tr>
  <tr>
    <th><?php echo L('subminiature_tube')?>：</th>
    <td class="y-bg"><input type="checkbox" name="issuper" value="1" /> <?php echo L('yes')?></td>
  </tr>
</table>
<div class="bk15"></div>
	<input type="hidden" name="admin_manage_code" value="<?php echo $admin_manage_code?>" id="admin_manage_code"></input>
    <input type="submit" class="button" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
</body>
</html>