<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">

<div class="content-menu ib-a blue line-x"><a href="javascript:;" class=on><em><?php echo L('remove');?></em></a> 
</div>
<div class="bk10"></div>
<form action="?m=content&c=content&a=remove" method="post" name="myform">
<div class="table-list">
<table width="100%" cellspacing="0">
<thead>
<tr>
<th align="center" width="50%"><?php echo L('from_where');?></th>
<th align="center" width="50%"><?php echo L('move_to_categorys');?></th>
</tr>
</thead>
<tbody  height="200" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6">
		<input type="radio" name="fromtype" value="0" checked id="fromtype_1" onclick="if(this.checked){$('#frombox_1').show();$('#frombox_2').hide();}">从指定ID：
		<input type="radio" name="fromtype" value="1"  id="fromtype_2" onclick="if(this.checked){$('#frombox_1').hide();$('#frombox_2').show();}">从指定栏目
		<div id="frombox_1" style="display:;">
		<textarea name="ids" style="height:280px;width:350px;"><?php echo $ids;?></textarea>
		<br/>
		<?php echo L('move_tips');?>
		</div>
		<div id="frombox_2" style="display:none;">
		<select name="fromid[]" id="fromid"  multiple  style="height:300px;width:350px;">
		<option value='0' style="background:#F1F3F5;color:blue;"><?php echo L('from_category');?></option>
		<?php echo $source_string;?>
		</select>
		<br>
		<font color="red">Tips:</font><?php echo L('ctrl_source_select');?>
		</div>
	</td>
    </tr>
	<tr> 
      <td align="center" rowspan="6"><br>
      <select name="tocatid" id="tocatid"  size="2"  style="height:300px;width:350px;">
<option value='0' style="background:#F1F3F5;color:blue;"><?php echo L('move_to_categorys');?></option>
<?php echo $string;?>
</select>
	</td>
    </tr>
	</tbody>

</table>

</div>
<div class="btn">
<input type="submit" class="button" value="<?php echo L('submit');?>" name="dosubmit"/>
</div>
</form>
</div>