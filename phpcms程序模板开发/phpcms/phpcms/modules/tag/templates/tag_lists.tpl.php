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
		<th><?php echo L('name')?></th>
		<th><?php echo L('stdcall')?></th>
		<th><?php echo L('stdcode')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php switch($v['type']){case 0:echo L('model_configuration');break;case 1:echo L('custom_sql');break;case 2:echo L('block');}?></td>
<td align="center"><textarea ondblclick="copy_text(this)" style="width: 400px;height:30px" /><?php echo new_html_special_chars($v['tag'])?></textarea></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>

</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
<script type="text/javascript">
<!--

function copy_text(matter){

	//var d = window.top.art.dialog({id:'edit_file'}).data.iframe;
	//d.call(matter);
	//window.top.art.dialog({id:'list'}).close();
	matter.select();
	js1=matter.createTextRange();
	js1.execCommand("Copy");
	alert('<?php echo L('copy_code');?>');
}

//-->
</script>
</body>
</html>