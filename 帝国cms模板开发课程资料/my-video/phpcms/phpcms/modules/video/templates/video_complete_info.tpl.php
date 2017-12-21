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
	$("#companyname").formValidator({onshow:"<?php echo L('input').L('公司名称');?>",onfocus:"<?php echo L('公司名称不能空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('公司名称不能为空');?>"});
	$("#address").formValidator({onshow:"<?php echo L('input').L('公司地址');?>",onfocus:"<?php echo L('联系地址不能空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('联系地址不能为空');?>"});
	$("#telephone").formValidator({onshow:"<?php echo L('input').L('联系电话');?>",onfocus:"<?php echo L('联系电话不能空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('联系电话不能为空');?>"});
	$("#contact_name").formValidator({onshow:"<?php echo L('input').L('联系人');?>",onfocus:"<?php echo L('联系人不能空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('联系人不能为空');?>"});
	$("#contact_telephone").formValidator({onshow:"<?php echo L('input').L('联系方式 ');?>",onfocus:"<?php echo L('联系方式不能为空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('联系方式不能为空');?>"});
	$("#contact_mobile").formValidator({onshow:"<?php echo L('input').L('手机不能为空');?>",onfocus:"<?php echo L('手机不能为空');?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('手机不能为空');?>"});
	$("#email").formValidator({onshow:"请输入E-mail",onfocus:"请输入E-mail",oncorrect:"E-mail格式正确"}).regexValidator({regexp:"email",datatype:"enum",onerror:"E-mail格式错误"});
})
//-->
</script>
<div class="pad-10">
<div class="explain-col search-form">
<?php echo L('subscribe_notic');?>
</div>
<div class="common-form">
<form name="myform" action="?m=video&c=video&a=complete_info&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform">
<input type="hidden" name="info[uid]" id="uid" value="<?php echo $uid;?>">
<input type="hidden" name="info[snid]" id="snid" value="<?php echo $snid;?>">
<fieldset>
	<legend><?php echo L('单位资料');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('公司名称');?></td> 
		<td><input name="info[companyname]"  type="text" id="companyname"  size="40" value="<?php echo $complete_info['companyname'];?>"> </td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('电话');?></td> 
		<td><input type="text" name="info[telephone]" size="20" value="<?php echo $complete_info['telephone'];?>" id="telephone"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('联系地址');?> </td> 
		<td><input type="text" name="info[address]" size="40" value="<?php echo $complete_info['address'];?>" id="address"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('网址');?> </td> 
		<td> <input type="text" name="info[website]" size="40" value="<?php echo $complete_info['website'];?>" id="website"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('业务简介');?> </td> 
		<td> <textarea name="info[description]" id="description" style="width:400px;height:46px;"><?php echo $complete_info['description'];?></textarea></td>
	</tr> 
</table>
</fieldset>
<br>
<fieldset>
	<legend><?php echo L('联系人资料');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('联系人');?></td> 
		<td><input name="info[contact_name]"  type="text" id="contact_name"  size="40" value="<?php echo $complete_info['contact_name'];?>"> </td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('联系电话');?></td> 
		<td><input type="text" name="info[contact_telephone]" size="40" value="<?php echo $complete_info['contact_telephone'];?>" id="contact_telephone"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('电子信箱');?></td> 
		<td><input type="text" name="info[email]" size="40" value="<?php echo $complete_info['email'];?>" id="email"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('手机');?> </td> 
		<td><input type="text" name="info[mobile]" size="20" value="<?php echo $complete_info['mobile'];?>" id="mobile"></td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('QQ');?> </td> 
		<td> <input type="text" name="info[qq]" size="20" value="<?php echo $complete_info['qq'];?>" id="qq"></td>
	</tr> 
</table>
</fieldset>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>

</body>
</html>