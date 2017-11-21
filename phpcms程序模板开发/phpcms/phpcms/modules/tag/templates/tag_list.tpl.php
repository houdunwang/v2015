<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="table-list">
<form action="" method="get">
<input type="hidden" name="m" value="tag" />
<input type="hidden" name="c" value="tag" />
<input type="hidden" name="a" value="del" />
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
		<th><?php echo L('name')?></th>
		<th><?php echo L('stdcall')?></th>
		<th><?php echo L('stdcode')?></th>
		<th width="150"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td width="80" align="center"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php switch($v['type']){case 0:echo L('model_configuration');break;case 1:echo L('custom_sql');break;case 2:echo L('block');}?></td>
<td align="center"><textarea ondblclick="copy_text(this)" style="width: 400px;height:30px" /><?php echo new_html_special_chars($v['tag'])?></textarea></td>
<td align="center"><a href="javascript:edit(<?php echo $v['id']?>, '<?php echo new_html_special_chars(new_addslashes($v['name']))?>')"><?php echo L('edit')?></a> | <a href="?m=tag&c=tag&a=del&id=<?php echo $v['id']?>" onclick="return confirm('<?php echo new_html_special_chars(new_addslashes(L('confirm', array('message'=>$v['name']))))?>')"><?php echo L('delete')?></a></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_deleted')?>')"/>
</div>
</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
<script type="text/javascript">
<!--
function edit(id, name) {
	
	window.top.art.dialog({title:'<?php echo L('editing_data_sources_call')?>《'+name+'》',id:'edit',iframe:'?m=tag&c=tag&a=edit&id='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function copy_text(matter){

	matter.select();

	js1=matter.createTextRange();

	js1.execCommand("Copy");

	alert('<?php echo L('copy_code');?>');

	}

//-->
</script>
</body>
</html>