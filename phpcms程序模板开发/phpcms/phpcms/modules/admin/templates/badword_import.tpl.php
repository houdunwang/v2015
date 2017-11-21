<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<form action="?m=admin&c=badword&a=import" method="post" name="myform">
 	<tr> 
      <th width="10%"> <?php echo L('badword_name')?> </th>
      <td width="200"><textarea name="info" cols="50" rows="6" require="true" datatype="limit" ></textarea> </td>
    </tr>
   
    <tr> 
      <th> <?php echo L('badword_name')?> <?php echo L('badword_require')?>: </th>
      <td>
<?php echo L('badword_import_infos')?>
 </td>
    </tr> 
    
 
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?m=admin&c=badword&a=import"> 
	  <input type="submit" name="dosubmit" value=" <?php echo L('submit')?> " class="button"> 
      &nbsp; <input type="reset" name="reset" value=" <?php echo L('clear')?> " class="button">
	  </td>
    </tr>
	</form>
</table> 
</div>
</body>
</html>