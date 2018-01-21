<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript">
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#word").formValidator({onshow:"<?php echo L('input').L('keylink');?>",onfocus:"<?php echo L('input').L('keylink');?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('keylink');?>"}).regexValidator({regexp:"notempty",datatype:"enum",param:'i',onerror:"<?php echo L('en_tips_type');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=keylink&a=public_name&keylinkid=<?php echo $keylinkid?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('keylink').L('exists');?>",onwait : "<?php echo L('connecting');?>"}).defaultPassed(); 
		$("#url").formValidator({onshow:"<?php echo L('input_siteurl');?>",onfocus:"<?php echo L('input_siteurl');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_siteurl');?>"}).regexValidator({regexp:"^http:",onerror:"<?php echo L('copyfrom_url_tips');?>"});
		
	})
</script>

<div class="pad_10">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<form action="?m=admin&c=keylink&a=edit&keylinkid=<?php echo $keylinkid?>" method="post" name="myform" id="myform">
 	<tr> 
      <th width="25%"><?php echo L('keylink_name');?> :</th>
      <td><input type="text" name="info[word]" id="word" size="20" value="<?php echo $word?>"></td>
    </tr>
    
    <tr> 
      <th><?php echo L('keylink_url');?> :</th>
      <td><input type="text" name="info[url]" id="url" size="30" value="<?php echo $url ?>" ></td>
    </tr>
	<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('submit')?> " class="dialog"> 
	</form>
</table>
</div>
</body>
</html>