<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style>
<!--
#show_funcs_div{position:absolute ;background-color:#fff;border:#D0D0D0 solid 1px; border-top-style:none;display:none}
.show_funcs_div{height:200px;overflow-y:scroll;}
#show_funcs_div ul li{padding:3px 0 3px 5px;}
#show_funcs_div ul li:hover{background-color:#EEEEEE;cursor:hand;}
.funcs_div{background:#fff; width:160px; border:solid #D0D0D0 1px;}
.funcs{border:none;background:none}
-->
</style>

<div id="show_funcs_div" onmouseover="clearh()" onmouseout="hidden_funcs_div_1()">
<ul>
<?php if (isset($spider_funs) && is_array($spider_funs)) foreach ($spider_funs as $k=>$v):?>
<li onclick="insert_txt('<?php echo $k;?>')"><?php echo $v?>(<?php echo $k;?>)</li>
<?php endforeach;?>
</ul>
</div>
<div class="pad-lr-10">
<form name="myform" action="?m=collection&c=node&a=import_program_add&nodeid=<?php if(isset($nodeid)) echo $nodeid?>&type=<?php echo $type?>&ids=<?php echo $ids?>&catid=<?php echo $catid?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('the_new_publication_solutions')?></legend>
	
		<table width="100%" class="table_form">
			<tr>
			<td width="120"><?php echo L('category')?>：</td> 
			<td>
			<?php echo $cat['catname'];?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('the_withdrawal_of_the_summary')?>：</td> 
			<td>
			<label><input name="add_introduce" type="checkbox"  value="1"><?php echo L('if_the_contents_of_intercepted')?></label><input type="text" name="introcude_length" value="200" size="3"><?php echo L('characters_to_a_summary_of_contents')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('the_withdrawal_of_thumbnails')?>：</td> 
			<td>
			<label><input type='checkbox' name='auto_thumb' value="1"><?php echo L('whether_access_to_the_content_of')?></label><input type="text" name="auto_thumb_no" value="1" size="2" class=""><?php echo L('picture_a_caption_pictures')?>
			
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('import_article_state')?>：</td> 
			<td>
			<?php if(!empty($cat['setting']['workflowid'])) {echo form::radio(array('1'=>L('pendingtrial'), '99'=>L('fantaoboys')), '1', 'name="content_status"');} else {echo form::radio(array('99'=>L('fantaoboys')), '99', 'name="content_status"');}?>
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk10"></div>
<fieldset>
	<legend><?php echo L('corresponding_labels_and_a_database_ties') ?></legend>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('the_original_database_field')?></th>
			<th align="left"><?php echo L('explain')?></th>
			<th align="left"><?php echo L('label_field__collected_with_the_result_')?></th>
			<th align="left"><?php echo L('handler_functions')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($model as $k=>$v) {
		if (in_array($v['formtype'], array('catid', 'typeid', 'posids', 'groupid', 'readpoint','template'))) continue;
?>
    <tr>
		<td align="left"><?php echo $v['field']?></td>
		<td align="left"><?php echo $v['name']?></td>
		<td align="left"><input type="hidden" name="model_field[]" value="<?php echo $v['field']?>"><?php echo form::select($node_field, (in_array($v['field'], array('inputtime', 'updatetime')) ? 'time' : $v['field']), 'name="node_field[]"')?></td>
		<td align="left"><div class="funcs_div"><input type="text" name="funcs[]" class="funcs"><a href="javascript:void(0)" onclick="clearh();show_funcs(this);" onmouseout="hidden_funcs_div_1()"><img src="<?php echo IMG_PATH?>admin_img/toggle-collapse-dark.png"></a></div></td>
    </tr>
<?php
	}

?>
</tbody>
</table>
</fieldset>
<div class="btn">
 <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>


<script type="text/javascript">
<!--
var div_obj;
function show_funcs(obj) {
	div_obj = $(obj).parent('div');
	var pos = $(obj).parent('div').offset();
	$('#show_funcs_div').css('left',pos.left+'px').css('top',(pos.top+24)+'px').width($(obj).parent().width()).show();
}

var s = 0;
var h;
function hidden_funcs_div_2() {
	s++;
	if(s>=5) {
		$('#show_funcs_div').hide().css('left','0px').css('top','0px');
		clearInterval(h);
		s = 0;
	}
}
function clearh(){
	if(h)clearInterval(h);
}

function hidden_funcs_div_1() {
	h = setInterval("hidden_funcs_div_2()", 1);
}

function insert_txt(obj) {
	$(div_obj).children('input').val(obj);
}
//-->
</script>

</body>
</html>