<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>

<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=scan&c=index&a=public_update_config" method="post" id="myform" onsubmit="return check_form()">
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('ravsingle')?>:</td> 
			<td><ul id="file" style="list-style:none; height:200px;overflow:auto;width:300px;">
			<?php $dir = $file= ''; foreach ($list as $v){
				$filename = basename($v);
				if (is_dir($v)) {
					$dir .= '<li><input type="checkbox" name="dir[]" value="'.$v.'" '.(isset($scan['dir']) && is_array($scan['dir']) && !empty($scan['dir']) && in_array($v, $scan['dir']) ? 'checked' :'').'><img src="'.IMG_PATH.'folder.gif"> '.$filename.'</li>';
				} elseif (substr(strtolower($v), -3, 3)=='php'){
					$file .= '<li><input type="checkbox" name="dir[]" value="'.$v.'" '.(isset($scan['dir']) && is_array($scan['dir']) && !empty($scan['dir']) && in_array($v, $scan['dir']) ? 'checked' :'').'><img src="'.IMG_PATH.'file.gif">'.$filename.'</li>';
				} else {
					continue;
				}
			}
			echo $dir,$file;
			?>
</ul></td>
		</tr>
		<tr>
			<td><?php echo L('file_type')?>:</td> 
			<td><input type="text" name="info[file_type]" size="100"  class="input-text" value="<?php echo $scan['file_type']?>"></input></td>
		</tr>
		<tr>
			<td><?php echo L('characteristic_function')?>:</td> 
			<td><input type="text" name="info[func]" size="100" class="input-text" value="<?php echo $scan['func']?>"></input></td>
		</tr>
		<tr>
			<td><?php echo L('characteristic_key')?>:</td> 
			<td><input type="text" name="info[code]" size="100" class="input-text" value="<?php echo $scan['code']?>"></input></td>
		</tr>
		
		<tr>
			<td><?php echo L('md5_the_mirror')?>:</td>
			<td>
			<?php echo form::select($md5_file_list, $scan['md5_file'], 'name="info[md5_file]"')?>
			</td>
		</tr>
	</table>
 
    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
</form>
</div>
</div>

<script type="text/javascript">
function check_form() {
	var checked = 0;
	$("input[type='checkbox'][name='dir[]']").each(function(i,n){if ($(this).attr('checked')=='checked') {checked = 1;}});
	if (checked) {
		return true;
	} else {
		alert('<?php echo L('please_select_the_content')?>');
		return false;
	}
}
</script>
</body>
</html>