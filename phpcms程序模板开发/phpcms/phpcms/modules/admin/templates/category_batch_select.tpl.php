<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
<div class="bk10"></div>

<div class="table-list">
<table width="100%" cellspacing="0">

<form action="?m=admin&c=category&a=batch_edit" method="post" name="myform">
<tbody  height="200" class="nHover td-line">
	<tr> 
      <td align="left" rowspan="6">
	<?php echo L('category_batch_edit');?> <font color="red"><?php echo L('category_manage');?></font>
	<input type="radio" name="type" value="0" <?php if($type==0) echo 'checked';?>><BR><BR>
	<?php echo L('category_batch_edit');?> <?php echo L('category_type_page');?><input type="radio" name="type" value="1"  <?php if($type==1) echo 'checked';?>>
	</td>
    </tr>
	<tr> 
      <td align="center" rowspan="6">
<select name='catids[]' id='catids'  multiple="multiple"  style="height:300px;width:400px" title="<?php echo L('push_ctrl_to_select','','content');?>">
<?php echo $string;?>
</select></td>
      <td>
	  <input type="hidden" value="<?php echo $type;?>">
	  <input type="submit" value="<?php echo L('submit');?>" class="button">
	  </td>
    </tr>

	</tbody>
	</form>
</table>

</div>
</div>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>