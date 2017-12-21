<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#subject").formValidator({onshow:"<?php echo L('input','',admin).L('subject')?>",onfocus:"<?php echo L('input','',admin).L('subject')?>"}).inputValidator({min:1,onerror:"<?php echo L('input','',admin).L('subject')?>"});
	$("#content").formValidator({onshow:"<?php echo L('input','',admin).L('content')?>",onfocus:"<?php echo L('input','',admin).L('content')?>"}).inputValidator({min:1,onerror:"<?php echo L('input','',admin).L('content')?>"});
	 
	})
//-->
</script>

<div class="pad_10">
<form action="?m=message&c=message&a=message_send" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	<tr>
		<th width="80"><?php echo L('sendto')?>：</th>
		<td>
		<input name="info[type]" type="radio" value="1" checked="checked" style="border:0" onclick="$('#groupid').show();$('#roleid').hide()" class="radio_style">
	<?php echo L('group')?>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	
	<tr>
		<th width="80"><?php echo L('group')?>：</th>
		<td>
		
		<select name="info[groupid]" id="groupid">
		<?php
		  $i=0;
		  foreach($member_group_infos as $groupid=>$member_group){
		  $i++;
		?>
		<option value="<?php echo $member_group['groupid'];?>"><?php echo $member_group['name'];?></option>
		<?php }?>
		</select>
		
		<select name="info[roleid]" id="roleid" style="display:none"  >
		<?php
		  $j=0;
		  foreach($role_infos as $roleid=>$role){
		  $j++;
		?>
		<option value="<?php echo $role['roleid'];?>"><?php echo $role['rolename'];?></option>
		<?php }?>
		
		
		</select>
		
		</td>
	</tr>
	
	<tr>
		<th width="80"><?php echo L('subject')?>：</th>
		<td><input type="text" name="info[subject]" id="subject"
			size="30" class="input-text"></td>
	</tr>  
 
	<tr>
		<th><?php echo L('content')?>：</th>
		<td><textarea name="info[content]" id="content" cols="50"
			rows="6"></textarea></td>
	</tr> 
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">

</table>
</form>
</div>
</body>
</html> 