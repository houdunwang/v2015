<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#word").formValidator({onshow:"<?php echo L('input').L('keylink');?>",onfocus:"<?php echo L('input').L('keylink');?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('keylink');?>"}).regexValidator({regexp:"notempty",datatype:"enum",param:'i',onerror:"<?php echo L('en_tips_type');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=keylink&a=public_name",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('keylink').L('exists');?>",onwait : "<?php echo L('connecting');?>"}); 
		$("#url").formValidator({onshow:"<?php echo L('input_siteurl');?>",onfocus:"<?php echo L('input_siteurl');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_siteurl');?>"}).regexValidator({regexp:"^http:",onerror:"<?php echo L('copyfrom_url_tips');?>"});
	})
//-->
</script>
<div class="pad_10">
<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
<form action="?m=admin&c=keylink&a=add" method="post" name="myform" id="myform">
	<tr> 
      <th width="25%"><?php echo L('keylink_name');?> :</th>
      <td><input type="text" name="info[word]" id="word" size="20"></td>
    </tr>
	<tr> 
      <th><?php echo L('keylink_url');?> :</th>
      <td><input type="text" name="info[url]" value="http://www." size="30" id="url"></td>
    </tr> 
	  <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
 	</form>
</table> 
</div>
</body>
</html>