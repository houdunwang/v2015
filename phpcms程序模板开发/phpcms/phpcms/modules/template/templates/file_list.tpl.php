<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="subnav">
  <h1 class="title-2 line-x"><?php echo $this->style_info['name'].' - '.L('detail')?></h1>
</div>
<div class="pad-lr-10">
<div class="table-list">
<form action="?m=template&c=file&a=updatefilename&style=<?php echo $this->style?>" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th align="left" ><?php echo L("dir")?></th>
		<th align="left" ><?php echo L('desc')?></th>
		<th align="left" ><?php echo L('operation')?></th>
		</tr>
        </thead>
<tbody>
<tr>
<td align="left" colspan="3"><?php echo L("local_dir")?>：<?php echo $local?></td>
</tr>
<?php if ($dir !='' && $dir != '.'):?>
<tr>
<td align="left" colspan="3"><a href="<?php echo '?m=template&c=file&a=init&style='.$this->style.'&dir='.stripslashes(dirname($dir))?>"><img src="<?php echo IMG_PATH?>folder-closed.gif" /><?php echo L("parent_directory")?></a></td>
</tr>
<?php endif;?>
<?php 
if(is_array($list)):
	foreach($list as $v):
	$filename = basename($v);
?>
<tr>
<?php if (is_dir($v)) {
	echo '<td align="left"><img src="'.IMG_PATH.'folder-closed.gif" /> <a href="?m=template&c=file&a=init&style='.$this->style.'&dir='.(isset($_GET['dir']) && !empty($_GET['dir']) ? stripslashes($_GET['dir']).DIRECTORY_SEPARATOR : '').$filename.'"><b>'.$filename.'</b></a></td><td align="left"><input type="text" name="file_explan['.$encode_local.']['.$filename.']" value="'.(isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "").'"></td><td></td>';
} else {
 	if (substr($filename,-4,4) == 'html') {
 		echo '<td align="left"><img src="'.IMG_PATH.'file.gif" /> '.$filename.'</td><td align="left"><input type="text" name="file_explan['.$encode_local.']['.$filename.']" value="'.(isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "").'"></td>';
		if($tpl_edit=='1'){
			echo '<td> <a href="?m=template&c=file&a=edit_file&style='.$this->style.'&dir='.urlencode(stripslashes($dir)).'&file='.$filename.'">['.L('edit').']</a> <a href="?m=template&c=file&a=visualization&style='.$this->style.'&dir='.urlencode(stripslashes($dir)).'&file='.$filename.'" target="_blank">['.L('visualization').']</a> <a href="javascript:history_file(\''.$filename.'\')">['.L('histroy').']</a></td>';
		}else{
			echo '<td></td>';
		}
 	}
}?>
</tr>
<?php 
	endforeach;
endif;
?></tbody>
</table>
<div class="btn"><input type="button" onclick="location.href='?m=template&c=style&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>'" class="button" name="dosubmit" value="<?php echo L('returns_list_style')?>" /> <input type="button" class="button" name="dosubmit" value="<?php echo L('new')?>" onclick="add_file()" /> <input type="submit" class="button" name="dosubmit" value="<?php echo L('update')?>" ></div> 
</form>
</div>
<div id="pages"><?php echo $pages?></div>
</div>
<script type="text/javascript">
<!--

function history_file(name) {
	window.top.art.dialog({title:'《'+name+'》<?php echo L("histroy")?>',id:'history',iframe:'?m=template&c=template_bak&a=init&style=<?php echo $this->style;?>&dir=<?php echo urlencode(stripslashes($dir))?>&filename='+name,width:'700',height:'521'}, function(){var d = window.top.art.dialog({id:'history'}).close();return false;}, function(){window.top.art.dialog({id:'history'}).close()});
}

function add_file() {
	window.top.art.dialog({title:'<?php echo L("new")?>',id:'add_file',iframe:'?m=template&c=file&a=add_file&style=<?php echo $this->style;?>&dir=<?php echo urlencode(stripslashes($dir))?>',width:'500',height:'100'}, function(){var d = window.top.art.dialog({id:'add_file'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'add_file'}).close()});
}
//-->
</script>
</body>
</html>