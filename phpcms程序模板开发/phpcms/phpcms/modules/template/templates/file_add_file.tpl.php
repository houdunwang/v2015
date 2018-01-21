<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=template&c=file&a=add_file&style=<?php echo $this->style?>&dir=<?php echo $dir?>" method="post" id="myform">
<div>
	<table width="100%"  class="table_form">
    <tr>
    <th width="80"><?php echo L('name')?>：</th>
    <td class="y-bg"><input type="text" name="name" id="name" /></td>
  </tr>
</table>
<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</div>

</form>
</div>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L("input").L('name').L('without_the_input_name_extension')?>",onfocus:"<?php echo L("input").L('name').L('without_the_input_name_extension')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('name')?>"}).regexValidator({regexp:"username",datatype:'enum',param:'i',onerror:"<?php echo L('name_datatype_error')?>"}).ajaxValidator({type : "get",url : "",data :"m=template&c=file&a=public_name&style=<?php echo $this->style?>&dir=<?php echo $dir?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('exists')?>",onwait : "<?php echo L('connecting')?>"});
	})
//-->
</script>
</body>
</html>