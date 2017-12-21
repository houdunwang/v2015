<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 生成模板中所有PC标签的MD5
 * @param $file 模板文件地址
 */
function tag_md5($file) {
	$data = file_get_contents($file);
	preg_match_all("/\{pc:(\w+)\s+([^}]+)\}/i", stripslashes($data),$matches);
	$arr = array();
	if(is_array($matches) && !empty($matches)) foreach($matches[0] as $k=>$v) {
		if (!$v) continue;
		$md5 = md5($v);
		$arr[0][$k] = $md5;
		$arr[1][$md5] = $v;
	}
	return $arr;
}

/**
 * 生成pc标签
 * @param $op 操作名
 * @param $data 数据
 */
function creat_pc_tag($op, $data) {
	$str = '{pc:'.$op.' ';
	if (is_array($data)) {
		foreach ($data as $k=>$v) {
			if ($v) $str .= $str ? " $k=\"$v\"" : "$k=\"$v\"";
		}
	} else {
		$str .= $data;
	}
	return $str.'}';
}

/**
 * 替换模板中的PC标签
 * @param $filepath 文件地址
 * @param $old_tag 老PC标签
 * @param $new_tag 新PC标签
 * @param $style 风格
 * @param $dir 目录名
 */
function replace_pc_tag($filepath, $old_tag, $new_tag, $style, $dir) {
	if (file_exists($filepath)) {
		creat_template_bak($filepath, $style, $dir);
		$data = @file_get_contents($filepath);
		$data = str_replace($old_tag, $new_tag, $data);
		if (!is_writable($filepath)) return false;
		@file_put_contents($filepath, $data);
		return true;
	}
}

/**
 * 生成模板临时文件
 * @param $filepath 文件地址
 * @param $style 风格
 * @param $dir 目录名
 */
function creat_template_bak($filepath, $style, $dir) {
	$filename = basename($filepath);
	$template_bak_db = pc_base::load_model('template_bak_model');
	$template_bak_db->insert(array('creat_at'=>SYS_TIME,'fileid'=>$style."_".$dir."_".$filename, 'userid'=>param::get_cookie('userid'), 'username'=>param::get_cookie('admin_username'), 'template'=>new_addslashes(file_get_contents($filepath))));
}

/**
 * 生成标签选项
 * @param $id HTML ID号
 * @param $data 生成条件
 * @param $value 当前值
 * @param $op 操作名
 * @return html 返回HTML代码
 */
function creat_form($id, $data, $value = '', $op = '') {
	pc_base::load_sys_class('form', '', 0);
	if (empty($value)) $value = $data['defaultvalue'];
	$str = $ajax = '';
	if($data['ajax']['name']) {
		if($data['ajax']['m']) {
			$url = '$.get(\'?m=content&c=push&a=public_ajax_get\', {html: this.value, id:\''.$data['ajax']['id'].'\', action: \''.$data['ajax']['action'].'\', module: \''.$data['ajax']['m'].'\', pc_hash: \''.$_SESSION['pc_hash'].'\'}, function(data) {$(\'#'.$id.'_td\').html(data)});';
		} else {
			$url = '$.get(\'?m=template&c=file&a=public_ajax_get\', { html: this.value, id:\''.$data['ajax']['id'].'\', action: \''.$data['ajax']['action'].'\', op: \''.$op.'\', style: \'default\', pc_hash: \''.$_SESSION['pc_hash'].'\'}, function(data) {$(\'#'.$id.'_td\').html(data)});';
		}
	}
	switch ($data['htmltype']) {
		case 'input':
			if($data['ajax']['name']) {
				$ajax = 'onblur="'.$url.'"';
			}
			$str .= '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="30" />';
			
			break;
		case 'select':
			if($data['ajax']['name']) {
				$ajax = 'onchange="'.$url.'"';
			}
			$str .= form::select($data['data'], $value, "name='$id' id='$id' $ajax");
			break;
		case 'checkbox':
			if($data['ajax']['name']) {
				$ajax = ' onclick="'.$url.'"';
			}
			if (is_array($value)) implode(',', $value);
			$str .= form::checkbox($data['data'], $value, "name='".$id."[]'".$ajax, '', '120');
			break;
		case 'radio':
			if($data['ajax']['name']) {
				$ajax = ' onclick="'.$url.'"';
			}
			$str .= form::radio($data['data'], $value, "name='$id'$ajax", '', '120');
			break;
		case 'input_select':
			if($data['ajax']['name']) {
				$ajax = ';'.$url;
			}
			$str .= '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="30" />'.form::select($data['data'], $value, "name='select_$id' id='select_$id' onchange=\"$('#$id').val(this.value);$ajax\"");
			break;
		
		case 'input_select_category':
			if($data['ajax']['name']) {
				$ajax = ';'.$url;
			}
			$str .= '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="30" />'.form::select_category('', $value, "name='select_$id' id='select_$id' onchange=\"$('#$id').val(this.value);$ajax\"", '', (isset($data['data']['modelid']) ? $data['data']['modelid'] : 0), (isset($data['data']['type']) ? $data['data']['type'] : -1), (isset($data['data']['onlysub']) ? $data['data']['onlysub'] : 0));
			break;

		case 'select_yp_model':
			if($data['ajax']['name']) {
				$ajax = ';'.$url;
			}
			$yp_models = getcache('yp_model', 'commons');
			$d = array(L('please_select'));
			if (is_array($yp_models) && !empty($yp_models)) {
				foreach ($yp_models as $k =>$v) {
					$d[$k] = $v['name'];
				}
			}
			$str .= '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="30" />'.form::select($d, $value, "name='select_$id' id='select_$id' onchange=\"$('#$id').val(this.value);$ajax\"");
			break;
	}
	if (!empty($data['validator'])) {
		$str .= '<script type="text/javascript">$(function(){$("#'.$id.'").formValidator({onshow:"'.L('input').$data['name'].'。",onfocus:"'.L('input').$data['name'].'。"'.($data['empty'] ? ',empty:true' : '').'})';
		if ($data['htmltype'] != 'select' && (isset($data['validator']['min']) || isset($data['validator']['max']))) {
			$str .= ".inputValidator({".(isset($data['validator']['min']) ? 'min:'.$data['validator']['min'].',' : '').(isset($data['validator']['max']) ? 'max:'.$data['validator']['max'].',' : '')." onerror:'".$data['name'].L('should', '', 'template').(isset($data['validator']['min']) ? ' '.L('is_greater_than', '', 'template').$data['validator']['min'].L('lambda', '', 'template') : '').(isset($data['validator']['max']) ? ' '.L('less_than', '', 'template').$data['validator']['max'].L('lambda', '', 'template') : '')."。'})";
			
		}
		if ($data['htmltype'] != 'checkbox' && $data['htmltype'] != 'radio' && isset($data['validator']['reg'])) {
			$str .= '.regexValidator({regexp:"'.$data['validator']['reg'].'"'.(isset($data['validator']['reg_param']) ? ",param:'".$data['validator']['reg_param']."'" : '').(isset($data['validator']['reg_msg']) ? ',onerror:"'.$data['validator']['reg_msg'].'"' : '').'})';
		}
		$str .=";});</script>";
	}
	return $str;
}

/**
 * 编辑PC标签时，生成跳转URL地址
 * @param $action 操作
 */
function creat_url($action) {
	$url = '';
	foreach ($_GET as $k=>$v) {
		if ($k=='action') $v = $action;
		$url .= $url ? "&$k=$v" : "$k=$v";
	}
	return $url;
}

/**
 * 生成可视化模板
 * @param $html 模板代码
 * @param $style 风格
 * @param $dir 目录
 * @param $file 文件名
 */
function visualization($html, $style = '', $dir = '', $file = '') {
	$change = "<link href=\"".CSS_PATH."dialog.css\" rel=\"stylesheet\" type=\"text/css\" />
		<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_PATH."admin_visualization.css\" />
		<script language=\"javascript\" type=\"text/javascript\" src=\"".JS_PATH."dialog.js\"></script>
		<script type='text/javascript' src='".JS_PATH."jquery.min.js'></script>
		<script type='text/javascript'>
		var pc_hash = '".$_SESSION['pc_hash']."';
		$(function(){
		$('a').attr('href', 'javascript:void(0)').attr('target', '');
		$('.admin_piao_edit').click(function(){
		var url = '?m=template&c=file&a=edit_pc_tag';
		if($(this).parent('.admin_piao').attr('pc_action') == 'block') url = '?m=block&c=block_admin&a=add';
		window.top.art.dialog({title:'".L('pc_tag','' ,'template')."',id:'edit',iframe:url+'&style=$style&dir=$dir&file=$file&'+$(this).parent('.admin_piao').attr('data'),width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});})
		$('.admin_block').click(function(){
			window.top.art.dialog({title:'".L('pc_tag','' ,'template')."',id:'edit',iframe:'?m=block&c=block_admin&a=block_update&id='+$(this).attr('blockid'),width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
		});
	})</script><div id=\"PC__contentHeight\" style=\"display:none\">80</div>";
		$html = str_replace('</body>', $change.'</body>', $html, $num);
		if (!$num) $html .= $change;
		
		return $html;
}