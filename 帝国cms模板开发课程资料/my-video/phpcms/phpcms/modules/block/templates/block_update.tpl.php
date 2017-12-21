<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
$authkey = upload_key('1,jpg|jpeg|gif|bmp|png,1,200,200');
?>
<?php if ($data['type'] == 2) :?>
<style>
.arrowhead,.arrowhead-b{background: url(<?php echo IMG_PATH?>icon/arrowhead.png) no-repeat; height:15px; width:16px;}
.arrowhead-b{background-position: left -28px;}
.thumb{float: left;width: 100px; height: 90px}
a.close{background: url(<?php echo IMG_PATH?>cross.png) no-repeat left -46px; display:block; width:16px;height:16px;display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;}
.forms{display:none;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<?php endif;?>

<div class="pad-10">
<form action="?m=block&c=block_admin&a=block_update&id=<?php echo $id?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('block_data')?></legend>
<table width="100%"  class="table_form" id="table_form">
<?php if ($data['type'] == 1) :?>
  <tr>
    <td class="y-bg"><textarea cols="80" id="data" name="data" rows="10"><?php echo new_html_special_chars($data['data'])?></textarea>
<?php echo form::editor('data','full','','','',1)?></td>
  </tr>
<?php else:?>
<?php if(is_array($data['data'])) foreach($data['data'] as $key=>$val):?>
  <tr>
    <td>
    <div class="contents" id="content_<?php echo $key?>"><a href="<?php echo $val['url']?>" target="blank"><b><?php echo $val['title']?></b></a><br /><div style="color:#ccc;"><?php if($val['thumb']):?><img src="<?php echo $val['thumb']?>" class="thumb" /><?php endif;?><?php echo $val['desc']?></div></div>
    <div class="forms" id="form_<?php echo $key?>">
    <?php echo L('title')?>：<input type="text" id="title_<?php echo $key?>" name="title[]" class="input-text" value="<?php echo $val['title']?>" > <?php echo L('link')?>：<input type="text" id="url_<?php echo $key?>" name="url[]"  class="input-text" value="<?php echo $val['url']?>" > <?php echo L('thumb')?>：<input type="hidden" name="thumb[]" id="thumb_<?php echo $key?>"  value="<?php echo $val['thumb']?>" > <a href="javascript:void(0)" onclick="flashupload('thumb_images', '<?php echo L('attachment_upload')?>','thumb_<?php echo $key?>',submit_images,'1,jpg|jpeg|gif|bmp|png,1','block', '', '<?php echo upload_key('1,jpg|jpeg|gif|bmp|png,1')?>')"><?php echo L('pic_upload')?></a> <a href="javascript:void(0)" onclick="$('#thumb_<?php echo $key?>').val('')"><?php echo L('delete_image')?></a><br /><?php echo L('desc')?>：<textarea id="desc_<?php echo $key?>" name="desc[]" rows="10" cols="80"><?php echo str_replace(array(chr(13), chr(43)), array('<br />', '&nbsp;'), $val['desc'])?></textarea><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo L('submit')?>" class="button" onclick="form_submit(<?php echo $key?>)" />
    </div>
    </td>
    <td width="80"><a href="javascript:void(0);" class="arrowhead" onclick="moveUp(this);" title="<?php echo L('up')?>"></a><a href="javascript:void(0);" onclick="moveDown(this);" class="arrowhead-b"  title="<?php echo L('down')?>"></a><a href="javascript:void(0)" onclick="edit_form(<?php echo $key?>)"><img src="<?php echo IMG_PATH?>icon/m_2.png" alt="<?php echo L('edit')?>" /></a><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();" class="close" title="<?php echo L('delete')?>"></a></td>
  </tr>
<?php endforeach;endif;?>
</table>
<div class="bk15"></div>
<input type="button" value="<?php echo L('preview')?>" class="button" onclick="block_view(<?php echo $id?>)" />
<input type="button" value="<?php echo L('history')?>" class="button" onclick="show_history()" />
<input type="button" value="<?php echo L('search_content')?>" class="button" onclick="search_content()">
<?php if ($data['type'] == 2) :?><?php echo L('datatable')?>: <input type="text" id="linenum" size="2" value="1" /><input type="button" value="<?php echo L('submit')?>" class="button" onclick="add_line()" />   
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('pieces_template')?></legend>
	<table width="100%"  class="table_form">
	<tr>
	<Td><textarea name="template" id="template" style="width:100%;height:120px;"><?php if ($data['template']) :echo new_html_special_chars($data['template']); else:?>{$name}
<ul>
{loop $data $i $r}
<li style="clear:both">
<a href="{$r[url]}">{$r[title]}</a><br />
<div style="color:#ccc;">{if $r[thumb]}<img src="{$r[thumb]}" style="float:left">{/if}{$r[desc]}
</div>
{/loop}
</li>
</ul><?php endif;?>
</textarea></Td>
	<td width="120"><span style="height:25px"><input type="button"  class="button" value="{loop }" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{loop $data $n $r}')" /></span>
	<span style="height:25px"><input type="button" class="button" value="{/loop}" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{/loop}')" /></span><br />
	<span style="height:25px"><input type="button"  class="button" value="<?php echo L('name')?>" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{$name}')" /></span>
	<span style="height:25px"><input type="button"  class="button" value="<?php echo L('title')?>" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{$r[title]}')" /></span><br />
	<span style="height:25px"><input type="button"  class="button" value="URL" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{$r[url]}')" /></span>
	<span style="height:25px"><input type="button"  class="button" value="<?php echo L('thumb')?>" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{$r[thumb]}')" /></span><br />
	<span style="height:25px"><input type="button"   class="button" value="<?php echo L('desc')?>" title="<?php echo L('insert')?>" style="width:50px" onClick="javascript:insertText('{$r[desc]}')" /></span>
	</td>
	</tr>
	</table>
</fieldset>
 <?php endif;?>
 
 <div class="bk15"></div>
 <a name="history_div"></a>
<fieldset id="history" style="display:none">
	<legend><?php echo L('history')?></legend>
	 <div class="bk15"></div>
	<div class="table-list">
	    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="120"><?php echo L('time')?></th>
		<th align="left"><?php echo L('admin')?></th>
		<th  align="left" width="150"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
        <?php if(is_array($history_list)) foreach ($history_list as $val):?>
        <tr>
        <td><?php echo format::date($val['creat_at'], 1)?></td>
        <td><?php echo $val['username']?></td>
        <td><a href="?m=block&c=block_admin&a=history_restore&id=<?php echo $val['id']?>"><?php echo L('restore')?></a> <a href="?m=block&c=block_admin&a=history_del&id=<?php echo $val['id']?>" onclick="return confirm('<?php echo L('are_you_sure_you_want_to_delete')?>')"><?php echo L('delete')?></a></td>
        </tr>
        <?php endforeach;?>
</tbody>
</table>
</div>
	<?php if($pages):?><div id="pages"><?php echo $pages;?></div><?php endif;?>
</fieldset>




<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="" />
<iframe name="view" id="view" src='' width="0" height="0"></iframe>
</div>
</form>
<script language="JavaScript" type="text/javascript"><!--

var j=<?php echo isset($total) ? $total : 0?>;
function add_line() {
	for (var i=1; i<= $('#linenum').val(); i++) {
		$('#table_form').append('<tr><td><div class="contents" id="content_'+j+'"></div><div class="forms" style="display:block" id="form_'+j+'"><?php echo L('title')?>：<input type="text" id="title_'+j+'" name="title[]" class="input-text">  <?php echo L('link')?>：<input type="text" id="url_'+j+'" name="url[]"  class="input-text"> <?php echo L('thumb')?>：<input type="hidden" name="thumb[]" id="thumb_'+j+'"> <a href="javascript:void(0)" onclick="flashupload(\'thumb_images\', \'<?php echo L('attachment_upload')?>\',\'thumb_'+j+'\',submit_images,\'1,jpg|jpeg|gif|bmp|png,1\',\'block\', \'\', \'<?php echo upload_key('1,jpg|jpeg|gif|bmp|png,1')?>\')"><?php echo L('pic_upload')?></a> <a href="javascript:void(0)" onclick="$(\'#thumb_'+j+'\').val(\'\')"><?php echo L('delete_image')?></a><br /><?php echo L('desc')?>：<textarea id="desc_'+j+'" name="desc[]" rows="10" cols="80"></textarea><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo L('submit')?>" class="button" onclick="form_submit('+j+')" /></div></td><td width="80"><a href="javascript:void(0);" class="arrowhead" onclick="moveUp(this);" title="<?php echo L('up')?>"></a><a href="javascript:void(0);" onclick="moveDown(this);" class="arrowhead-b"  title="<?php echo L('down')?>"></a><a  href="javascript:void(0)" onclick="edit_form('+j+')"><img src="<?php echo IMG_PATH?>icon/m_2.png" alt="<?php echo L('edit')?>" /></a><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();" class="close" title="<?php echo L('delete')?>"></a></td></tr>');
		j++;
	}
	
}

function insert_forms(obj) {
	eval("var d = "+obj+";");
$('#table_form').append('<tr><td><div class="contents" id="content_'+j+'"></div><div class="forms" style="display:block" id="form_'+j+'"><?php echo L('title')?>：<input type="text" id="title_'+j+'" name="title[]" class="input-text" value="'+d.title+'" >  <?php echo L('link')?>：<input type="text" id="url_'+j+'" name="url[]" value="'+d.url+'"  class="input-text"> <?php echo L('thumb')?>：<input type="hidden" name="thumb[]"  value="'+d.thumb+'" id="thumb_'+j+'"> <a href="javascript:void(0)" onclick="flashupload(\'thumb_images\', \'<?php echo L('attachment_upload')?>\',\'thumb_'+j+'\',submit_images,\'1,jpg|jpeg|gif|bmp|png,1,200,200\',\'block\',\'\',\'<?php echo upload_key('1,jpg|jpeg|gif|bmp|png,1,200,200')?>\')"><?php echo L('pic_upload')?></a> <a href="javascript:void(0)" onclick="$(\'#thumb_'+j+'\').val(\'\')"><?php echo L('delete_image')?></a><br /><?php echo L('desc')?>：<textarea id="desc_'+j+'" name="desc[]" rows="10" cols="80">'+d.desc+'</textarea><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo L('submit')?>" class="button" onclick="form_submit('+j+')" /></div></td><td width="80"><a href="javascript:void(0);" class="arrowhead" onclick="moveUp(this);" title="<?php echo L('up')?>"></a><a href="javascript:void(0);" onclick="moveDown(this);" class="arrowhead-b"  title="<?php echo L('down')?>"></a><a  href="javascript:void(0)" onclick="edit_form('+j+')"><img src="<?php echo IMG_PATH?>icon/m_2.png" alt="<?php echo L('edit')?>" /></a><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();" class="close" title="<?php echo L('delete')?>"></a></td></tr>');
form_submit(j);
j++;	
}

function block_view(id) {
	var old_action = $('#myform').attr('action');
	$('#myform').attr('action', '?m=block&c=block_admin&a=public_view&id='+id);
	$('#myform').attr('target', 'view');
	$('#myform').submit();
	$('#myform').attr('action', old_action);
	$('#myform').attr('target', '');
}

function showblock(id, html){
	if (parent.right) {
		parent.right.$("#block_id_"+id).html(html);
	} else {
		parent.$("#block_id_"+id).html(html);
	}
}

function edit_form(id) {
	$('#content_'+id).hide();
	$('#form_'+id).show();
}

function search_content() {
	art.dialog({title:'<?php echo L('search_content')?>',id:'search_content',iframe:"?m=block&c=block_admin&a=public_search_content",width:'600',height:'400'});
}

function form_submit(id) {
	var title = $('#title_'+id).val();
	var url = $('#url_'+id).val();
	var thumb = $('#thumb_'+id).val();
	var desc = $('#desc_'+id).val();
	if (title == '') {
		alert('<?php echo L('title').L('empty')?>');
		$('#title_'+id).focus();
		return false;
	}
	if (url == '') {
		alert('<?php echo L('link').L('empty')?>');
		$('#url_'+id).focus();
		return false;
	}
	var str = '<a href="http://'+url+'" target="blank"><b>'+title+'</b></a><br />';
	str += '<div style="color:#ccc;">'+(thumb ? '<img src="'+thumb+'" class="thumb" />': '')+desc+'</div>';
	$('#content_'+id).html(str).show();
	$('#form_'+id).hide();
}

function cleanWhitespace(element) {
 for (var i = 0; i < element.childNodes.length; i++) {
  var node = element.childNodes[i];
  if (node.nodeType == 3 && !/S/.test(node.nodeValue))
  node.parentNode.removeChild(node);
 }
}
var _table=document.getElementById("table_form");
cleanWhitespace(_table);
function moveUp(_a){
 var _row=_a.parentNode.parentNode;
 if(_row.previousSibling)swapNode(_row,_row.previousSibling);
}
function moveDown(_a){
 var _row=_a.parentNode.parentNode;
 if(_row.nextSibling)swapNode(_row,_row.nextSibling);
}
function swapNode(node1,node2){
 var _parent=node1.parentNode;
 var _t1=node1.nextSibling;
 var _t2=node2.nextSibling;
 if(_t1)_parent.insertBefore(node2,_t1);
 else _parent.appendChild(node2);
 if(_t2)_parent.insertBefore(node1,_t2);
 else _parent.appendChild(node1);
}


function insertText(text)
{
	$('#template').focus();
    var str = document.selection.createRange();
	str.text = text;
}

function show_history() {
	$('#history').show();
	location.href = '#history_div';
}

//
--></script>
</body>
</html>