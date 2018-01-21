<?php
class content_form {
	var $modelid;
	var $fields;
	var $id;
	var $formValidator;

    function __construct($modelid,$catid = 0,$categorys = array()) {
		$this->modelid = $modelid;
		$this->catid = $catid;
		$this->categorys = $categorys;
		$this->fields = getcache('model_field_'.$modelid,'model');
		$this->siteid = get_siteid();
    }

	function get($data = array()) {
		$_groupid = param::get_cookie('_groupid');
		$this->data = $data;
		if(isset($data['id'])) $this->id = $data['id'];
		$info = array();
		$this->content_url = $data['url'];
		foreach($this->fields as $field=>$v) {
			if(defined('IN_ADMIN')) {
				if($v['iscore'] || check_in($_SESSION['roleid'], $v['unsetroleids'])) continue;
			} else {
				if($v['iscore'] || !$v['isadd'] || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			$func = $v['formtype'];
			$value = isset($data[$field]) ? new_html_special_chars($data[$field]) : '';
			if($func=='pages' && isset($data['maxcharperpage'])) {
				$value = $data['paginationtype'].'|'.$data['maxcharperpage'];
			}
			if(!method_exists($this, $func)) continue;
			$form = $this->$func($field, $value, $v);
			if($form !== false) {
				if(defined('IN_ADMIN')) {
					if($v['isbase']) {
						$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
						$info['base'][$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star,'isomnipotent'=>$v['isomnipotent'],'formtype'=>$v['formtype']);
					} else {
						$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
						$info['senior'][$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star,'isomnipotent'=>$v['isomnipotent'],'formtype'=>$v['formtype']);
					}
				} else {
					$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
					$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star,'isomnipotent'=>$v['isomnipotent'],'formtype'=>$v['formtype']);
				}
			}
		}
		return $info;
	}
	function text($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		$size = $setting['size'];
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		$errortips = $this->fields[$field]['errortips'];
		if($errortips || $minlength) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		return '<input type="text" name="info['.$field.']" id="'.$field.'" size="'.$size.'" value="'.$value.'" class="input-text" '.$formattribute.' '.$css.'>';
	}
	function textarea($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		extract($setting);
		if(!$value) $value = $defaultvalue;
		$allow_empty = 'empty:true,';
		if($minlength || $pattern) $allow_empty = '';
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({'.$allow_empty.'onshow:"'.$errortips.'",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		$value = empty($value) ? $setting[defaultvalue] : $value;
		$str = "<textarea name='info[{$field}]' id='$field' style='width:{$width}%;height:{$height}px;' $formattribute $css";
		if($maxlength) $str .= " onkeyup=\"strlen_verify(this, '{$field}_len', {$maxlength})\"";
		$str .= ">{$value}</textarea>";
		if($maxlength) $str .= L('can_enter').'<B><span id="'.$field.'_len">'.$maxlength.'</span></B> '.L('characters');
		return $str;
	}
	function editor($field, $value, $fieldinfo) {
		$grouplist = getcache('grouplist','member');
		$_groupid = param::get_cookie('_groupid');
		$grouplist = $grouplist[$_groupid];
		extract($fieldinfo);
		extract(string2array($setting));
		$disabled_page = isset($disabled_page) ? $disabled_page : 0;
		if(!$height) $height = 300;
		$allowupload = defined('IN_ADMIN') ? 1 : $grouplist['allowattachment'] ? 1: 0;
		if(!$value) $value = $defaultvalue;
		if($minlength || $pattern) $allow_empty = '';
		if($minlength) $this->formValidator .= '$("#'.$field.'").formValidator({'.$allow_empty.'onshow:"",onfocus:"'.$errortips.'"}).functionValidator({
	    fun:function(val,elem){
			var oEditor = CKEDITOR.instances.'.$field.';
			var data = oEditor.getData();
	        if($(\'#islink\').attr(\'checked\')){
			    return true;
		    } else if(($(\'#islink\').attr(\'checked\')==false) && (data==\'\')){
			    return "'.$errortips.'";
		    } else if (data==\'\' || $.trim(data)==\'\') {
				return "'.$errortips.'";
			}
			return true;
		}
	});';
		return "<div id='{$field}_tip'></div>".'<textarea name="info['.$field.']" id="'.$field.'" boxid="'.$field.'">'.$value.'</textarea>'.form::editor($field,$toolbar,'content',$this->catid,'',$allowupload,1,'',$height,$disabled_page);
	}
	function catid($field, $value, $fieldinfo) {
		if(!$value) $value = $this->catid;
		$publish_str = '';
		if(defined('IN_ADMIN') && ROUTE_A=='add') $publish_str = " <a href='javascript:;' onclick=\"omnipotent('selectid','?m=content&c=content&a=add_othors&siteid=".$this->siteid."','".L('publish_to_othor_category')."',1);return false;\" style='color:#B5BFBB'>[".L('publish_to_othor_category')."]</a><ul class='list-dot-othors' id='add_othors_text'></ul>";
		return '<input type="hidden" name="info['.$field.']" value="'.$value.'">'.$this->categorys[$value]['catname'].$publish_str;
	}
	function title($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$style_arr = explode(';',$this->data['style']);
		$style_color = $style_arr[0];
		$style_font_weight = $style_arr[1] ? $style_arr[1] : '';

		$style = 'color:'.$this->data['style'];
		if(!$value) $value = $defaultvalue;
		$errortips = $this->fields[$field]['errortips'];
		$errortips_max = L('title_is_empty');
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:'.$minlength.',max:'.$maxlength.',onerror:"'.$errortips_max.'"});';
		$str = '<input type="text" style="width:400px;'.($style_color ? 'color:'.$style_color.';' : '').($style_font_weight ? 'font-weight:'.$style_font_weight.';' : '').'" name="info['.$field.']" id="'.$field.'" value="'.$value.'" style="'.$style.'" class="measure-input " onBlur="$.post(\'api.php?op=get_keywords&number=3&sid=\'+Math.random()*5, {data:$(\'#title\').val()}, function(data){if(data && $(\'#keywords\').val()==\'\') $(\'#keywords\').val(data); })" onkeyup="strlen_verify(this, \'title_len\', '.$maxlength.');"/><input type="hidden" name="style_color" id="style_color" value="'.$style_color.'">
		<input type="hidden" name="style_font_weight" id="style_font_weight" value="'.$style_font_weight.'">';
		if(defined('IN_ADMIN')) $str .= '<input type="button" class="button" id="check_title_alt" value="'.L('check_title','','content').'" onclick="$.get(\'?m=content&c=content&a=public_check_title&catid='.$this->catid.'&sid=\'+Math.random()*5, {data:$(\'#title\').val()}, function(data){if(data==\'1\') {$(\'#check_title_alt\').val(\''.L('title_repeat').'\');$(\'#check_title_alt\').css(\'background-color\',\'#FFCC66\');} else if(data==\'0\') {$(\'#check_title_alt\').val(\''.L('title_not_repeat').'\');$(\'#check_title_alt\').css(\'background-color\',\'#F8FFE1\')}})" style="width:73px;"/><img src="'.IMG_PATH.'icon/colour.png" width="15" height="16" onclick="colorpicker(\''.$field.'_colorpanel\',\'set_title_color\');" style="cursor:hand"/> 
		<img src="'.IMG_PATH.'icon/bold.png" width="10" height="10" onclick="input_font_bold()" style="cursor:hand"/> <span id="'.$field.'_colorpanel" style="position:absolute;" class="colorpanel"></span>';
		$str .= L('can_enter').'<B><span id="title_len">'.$maxlength.'</span></B> '.L('characters');
		return $str;
	}
	function box($field, $value, $fieldinfo) {

		$setting = string2array($fieldinfo['setting']);
		if($value=='') $value = $this->fields[$field]['defaultvalue'];
		$options = explode("\n",$this->fields[$field]['options']);
		foreach($options as $_k) {
			$v = explode("|",$_k);
			$k = trim($v[1]);
			$option[$k] = $v[0];
		}
		$values = explode(',',$value);
		$value = array();
		foreach($values as $_k) {
			if($_k != '') $value[] = $_k;
		}
		$value = implode(',',$value);
		switch($this->fields[$field]['boxtype']) {
			case 'radio':
				$string = form::radio($option,$value,"name='info[$field]' $fieldinfo[formattribute]",$setting['width'],$field);
			break;

			case 'checkbox':
				$string = form::checkbox($option,$value,"name='info[$field][]' $fieldinfo[formattribute]",1,$setting['width'],$field);
			break;

			case 'select':
				$string = form::select($option,$value,"name='info[$field]' id='$field' $fieldinfo[formattribute]");
			break;

			case 'multiple':
				$string = form::select($option,$value,"name='info[$field][]' id='$field' size=2 multiple='multiple' style='height:60px;' $fieldinfo[formattribute]");
			break;
		}
		return $string;
	}
	function image($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$html = '';
		if (defined('IN_ADMIN')) {
			$html = "<input type=\"button\" style=\"width: 66px;\" class=\"button\" onclick=\"crop_cut_".$field."($('#$field').val());return false;\" value=\"".L('cut_the_picture','','content')."\"><input type=\"button\" style=\"width: 66px;\" class=\"button\" onclick=\"$('#".$field."_preview').attr('src','".IMG_PATH."icon/upload-pic.png');$('#".$field."').val(' ');return false;\" value=\"".L('cancel_the_picture','','content')."\"><script type=\"text/javascript\">function crop_cut_".$field."(id){
	if (id=='') { alert('".L('upload_thumbnails', '', 'content')."');return false;}
	window.top.art.dialog({title:'".L('cut_the_picture','','content')."', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid='+catid+'&picurl='+encodeURIComponent(id)+'&input=$field&preview=".($show_type && defined('IN_ADMIN') ? $field."_preview" : '')."', width:'680px', height:'480px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
	d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
};</script>";
			}
		$authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
		if($show_type && defined('IN_ADMIN')) {
			$preview_img = $value ? $value : IMG_PATH.'icon/upload-pic.png';
			return $str."<div class='upload-pic img-wrap'><input type='hidden' name='info[$field]' id='$field' value='$value'>
			<a href='javascript:void(0);' onclick=\"flashupload('{$field}_images', '".L('attachment_upload', '', 'content')."','{$field}',thumb_images,'1,{$upload_allowext},$isselectimage,$images_width,$images_height,$watermark','content','$this->catid','$authkey');return false;\">
			<img src='$preview_img' id='{$field}_preview' width='135' height='113' style='cursor:hand' /></a>".$html."</div>";
		} else {
			return $str."<input type='text' name='info[$field]' id='$field' value='$value' size='$size' class='input-text' />  <input type='button' class='button' onclick=\"flashupload('{$field}_images', '".L('attachment_upload', '', 'content')."','{$field}',submit_images,'1,{$upload_allowext},$isselectimage,$images_width,$images_height,$watermark','content','$this->catid','$authkey')\"/ value='".L('upload_pic', '', 'content')."'>".$html;
		}
	}
	function images($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$list_str = '';
		if($value) {
			$value = string2array(new_html_entity_decode($value));
			if(is_array($value)) {
				foreach($value as $_k=>$_v) {
				$list_str .= "<div id='image_{$field}_{$_k}' style='padding:1px'><input type='text' name='{$field}_url[]' value='{$_v[url]}' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'> <input type='text' name='{$field}_alt[]' value='{$_v[alt]}' style='width:160px;' class='input-text'> <a href=\"javascript:remove_div('image_{$field}_{$_k}')\">".L('remove_out', '', 'content')."</a></div>";
				}
			}
		} else {
			$list_str .= "<center><div class='onShow' id='nameTip'>".L('upload_pic_max', '', 'content')." <font color='red'>{$upload_number}</font> ".L('tips_pics', '', 'content')."</div></center>";
		}
		$string = '<input name="info['.$field.']" type="hidden" value="1">
		<fieldset class="blue pad-10">
        <legend>'.L('pic_list').'</legend>';
		$string .= $list_str;
		$string .= '<div id="'.$field.'" class="picList"></div>
		</fieldset>
		<div class="bk10"></div>
		';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="statics/js/swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
		$string .= $str."<div class='picBut cu'><a href='javascript:void(0);' onclick=\"javascript:flashupload('{$field}_images', '".L('attachment_upload')."','{$field}',change_images,'{$upload_number},{$upload_allowext},{$isselectimage}','content','$this->catid','{$authkey}')\"/> ".L('select_pic')." </a></div>";
		return $string;
	}	function number($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		$size = $setting['size'];		
		if(!$value) $value = $defaultvalue;
		return "<input type='text' name='info[$field]' id='$field' value='$value' class='input-text' size='$size' {$formattribute} {$css}>";
	}
	function datetime($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$isdatetime = 0;
		$timesystem = 0;
		if($fieldtype=='int') {
			if(!$value) $value = SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			if($format == 'Y-m-d Ah:i:s') $format_txt = 'Y-m-d h:i:s';
			$value = date($format_txt,$value);
			
			$isdatetime = strlen($format) > 6 ? 1 : 0;
			if($format == 'Y-m-d Ah:i:s') {
				
				$timesystem = 0;
			} else {
				$timesystem = 1;
			}			
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
			$timesystem = 1;
		} elseif($fieldtype=='datetime_a') {
			$isdatetime = 1;
			$timesystem = 0;
		}
		return form::date("info[$field]",$value,$isdatetime,1,'true',$timesystem);
	}
	function posid($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$position = getcache('position','commons');
		if(empty($position)) return '';
		$array = array();
		foreach($position as $_key=>$_value) {
			if($_value['modelid'] && ($_value['modelid'] !=  $this->modelid) || ($_value['catid'] && strpos(','.$this->categorys[$_value['catid']]['arrchildid'].',',','.$this->catid.',')===false)) continue;
			$array[$_key] = $_value['name'];
		}
		$posids = array();
		if(ROUTE_A=='edit') {
			$this->position_data_db = pc_base::load_model('position_data_model');
			$result = $this->position_data_db->select(array('id'=>$this->id,'modelid'=>$this->modelid),'*','','','','posid');
			$posids = implode(',', array_keys($result));
		} else {
			$posids = $setting['defaultvalue'];
		}
		return "<input type='hidden' name='info[$field][]' value='-1'>".form::checkbox($array,$posids,"name='info[$field][]'",'',$setting['width']);
	}
	function keyword($field, $value, $fieldinfo) {
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return "<input type='text' name='info[$field]' id='$field' value='$value' style='width:280px' {$formattribute} {$css} class='input-text'>";
	}
	function author($field, $value, $fieldinfo) {
		return '<input type="text" name="info['.$field.']" value="'.$value.'" size="30">';
	}
	function copyfrom($field, $value, $fieldinfo) {
		$value_data = '';
		if($value && strpos($value,'|')!==false) {
			$arr = explode('|',$value);
			$value = $arr[0];
			$value_data = $arr[1];
		}
		$copyfrom_array = getcache('copyfrom','admin');
		$copyfrom_datas = array(L('copyfrom_tips'));
		if(!empty($copyfrom_array)) {
			foreach($copyfrom_array as $_k=>$_v) {
				if($this->siteid==$_v['siteid']) $copyfrom_datas[$_k] = $_v['sitename'];
			}
		}
		return "<input type='text' name='info[$field]' value='$value' style='width: 400px;' class='input-text'>".form::select($copyfrom_datas,$value_data,"name='{$field}_data' ");
	}
	function groupid($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$grouplist = getcache('grouplist','member');
		foreach($grouplist as $_key=>$_value) {
			$data[$_key] = $_value['name'];
		}
		return '<input type="hidden" name="info['.$field.']" value="1">'.form::checkbox($data,$value,'name="'.$field.'[]" id="'.$field.'"','','120');
	}
	function islink($field, $value, $fieldinfo) {
		if($value) {
			$url = $this->data['url'];
			$checked = 'checked';
			$_GET['islink'] = 1;
		} else {
			$disabled = 'disabled';
			$url = $checked = '';
			$_GET['islink'] = 0;
		}
		$size = $fieldinfo['size'] ? $fieldinfo['size'] : 25;
		return '<input type="hidden" name="info[islink]" value="0"><input type="text" name="linkurl" id="linkurl" value="'.$url.'" size="'.$size.'" maxlength="255" '.$disabled.' class="input-text"> <input name="info[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" '.$checked.'> <font color="red">'.L('islink_url').'</font>';
	}
	function template($field, $value, $fieldinfo) {
		$sitelist = getcache('sitelist','commons');
		$default_style = $sitelist[$this->siteid]['default_style'];
		return form::select_template($default_style,'content',$value,'name="info['.$field.']" id="'.$field.'"','show');
	}
	function pages($field, $value, $fieldinfo) {
		extract($fieldinfo);
		if($value) {
			$v = explode('|', $value);
			$data = "<select name=\"info[paginationtype]\" id=\"paginationtype\" onchange=\"if(this.value==1)\$('#paginationtype1').css('display','');else \$('#paginationtype1').css('display','none');\">";
			$type = array(L('page_type1'), L('page_type2'), L('page_type3'));
			if($v[0]==1) $con = 'style="display:"';
			else $con = 'style="display:none"';
			foreach($type as $i => $val) {
				if($i==$v[0]) $tag = 'selected';
				else $tag = '';
				$data .= "<option value=\"$i\" $tag>$val</option>";
			}
			$data .= "</select><span id=\"paginationtype1\" $con><input name=\"info[maxcharperpage]\" type=\"text\" id=\"maxcharperpage\" value=\"$v[1]\" size=\"8\" maxlength=\"8\">".L('page_maxlength')."</span>";
			return $data;
		} else {
			return "<select name=\"info[paginationtype]\" id=\"paginationtype\" onchange=\"if(this.value==1)\$('#paginationtype1').css('display','');else \$('#paginationtype1').css('display','none');\">
                <option value=\"0\">".L('page_type1')."</option>
                <option value=\"1\">".L('page_type2')."</option>
                <option value=\"2\">".L('page_type3')."</option>
            </select>
			<span id=\"paginationtype1\" style=\"display:none\"><input name=\"info[maxcharperpage]\" type=\"text\" id=\"maxcharperpage\" value=\"10000\" size=\"8\" maxlength=\"8\">".L('page_maxlength')."</span>";
		}
	}
	function typeid($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		if(!$value) $value = $setting['defaultvalue'];
		if($errortips) {
			$errortips = $this->fields[$field]['errortips'];
			$this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		}
		$usable_type = $this->categorys[$this->catid]['usable_type'];
		$usable_array = array();
		if($usable_type) $usable_array = explode(',',$usable_type);
		
		//获取站点ID
		if(intval($_GET['siteid'])){
			$siteid = intval($_GET['siteid']);
		}else{
			$siteid = $this->siteid;
		}
		$type_data = getcache('type_content_'.$siteid,'commons');
		if($type_data) {
			foreach($type_data as $_key=>$_value) {
				if(in_array($_key,$usable_array)) $data[$_key] = $_value['name'];
			}
		}
		return form::select($data,$value,'name="info['.$field.']" id="'.$field.'" '.$formattribute.' '.$css,L('copyfrom_tips'));
	}
	function readpoint($field, $value, $fieldinfo) {
		$paytype = $this->data['paytype'];
		if($paytype) {
			$checked1 = '';
			$checked2 = 'checked';
		} else {
			$checked1 = 'checked';
			$checked2 = '';
		}
		return '<input type="text" name="info['.$field.']" value="'.$value.'" size="5"><input type="radio" name="info[paytype]" value="0" '.$checked1.'> '.L('point').' <input type="radio" name="info[paytype]" value="1" '.$checked2.'>'.L('money');
	}
	function linkage($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$linkageid = $setting['linkageid'];
		return menu_linkage($linkageid,$field,$value);
	}
	function downfile($field, $value, $fieldinfo) {
		$list_str = $str = '';
		extract(string2array($fieldinfo['setting']));
		if($value){
			$value_arr = explode('|',$value);
			$value = $value_arr['0'];
			$sel_server = $value_arr['1'] ? explode(',',$value_arr['1']) : '';
			$edit = 1;
		} else {
			$edit = 0;
		}
		$server_list = getcache('downservers','commons');
		if(is_array($server_list)) {
			foreach($server_list as $_k=>$_v) {
				if (in_array($_v['siteid'],array(0,$fieldinfo['siteid']))) {
					$checked = $edit ? ((is_array($sel_server) && in_array($_k,$sel_server)) ? ' checked' : '') : ' checked';
					$list_str .= "<lable id='downfile{$_k}' class='ib lh24' style='width:25%'><input type='checkbox' value='{$_k}' name='{$field}_servers[]' {$checked}>  {$_v['sitename']}</lable>";
				}
			}
		}
	
		$string = '
		<fieldset class="blue pad-10">
        <legend>'.L('mirror_server_list').'</legend>';
		$string .= $list_str;
		$string .= '</fieldset>
		<div class="bk10"></div>
		';	
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}	
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");	
		$string .= $str."<input type='text' name='info[$field]' id='$field' value='$value' class='input-text' style='width:80%'/>  <input type='button' class='button' onclick=\"javascript:flashupload('{$field}_downfield', '".L('attachment_upload')."','{$field}',submit_files,'{$upload_number},{$upload_allowext},{$isselectimage}','content','$this->catid','{$authkey}')\"/ value='".L('upload_soft')."'>";
		return $string;
	}
	function downfiles($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$list_str = '';
		if($value) {
			$value = string2array(new_html_entity_decode($value));
			if(is_array($value)) {
				foreach($value as $_k=>$_v) {
				$list_str .= "<div id='multifile{$_k}'><input type='text' name='{$field}_fileurl[]' value='{$_v[fileurl]}' style='width:310px;' class='input-text'> <input type='text' name='{$field}_filename[]' value='{$_v[filename]}' style='width:160px;' class='input-text'> <a href=\"javascript:remove_div('multifile{$_k}')\">".L('remove_out')."</a></div>";
				}
			}
		}
		$string = '<input name="info['.$field.']" type="hidden" value="1">
		<fieldset class="blue pad-10">
        <legend>'.L('file_list').'</legend>';
		$string .= $list_str;
		$string .= '<ul id="'.$field.'" class="picList"></ul>
		</fieldset>
		<div class="bk10"></div>
		';
		
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
		$string .= $str."<input type=\"button\"  class=\"button\" value=\"".L('multiple_file_list')."\" onclick=\"javascript:flashupload('{$field}_multifile', '".L('attachment_upload')."','{$field}',change_multifile,'{$upload_number},{$upload_allowext},{$isselectimage}','content','$this->catid','{$authkey}')\"/>    <input type=\"button\" class=\"button\" value=\"".L('add_remote_url')."\" onclick=\"add_multifile('{$field}')\">";
		return $string;
	}
	function map($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		$size = $setting['size'];
		$errortips = $this->fields[$field]['errortips'];
		$modelid = $this->fields[$field]['modelid'];
		$tips = $value ? L('editmark','','map') : L('addmark','','map');
		return '<input type="button" name="'.$field.'_mark" id="'.$field.'_mark" value="'.$tips.'" class="button" onclick="omnipotent(\'selectid\',\''.APP_PATH.'api.php?op=map&field='.$field.'&modelid='.$modelid.'\',\''.L('mapmark','','map').'\',1,700,420)"><input type="hidden" name="info['.$field.']" value="'.$value.'" id="'.$field.'" >';
	}
	function omnipotent($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$formtext = str_replace('{FIELD_VALUE}',$value,$formtext);
		$formtext = str_replace('{MODELID}',$this->modelid,$formtext);
		preg_match_all('/{FUNC\((.*)\)}/',$formtext,$_match);
		foreach($_match[1] as $key=>$match_func) {
			$string = '';
			$params = explode('~~',$match_func);
			$user_func = $params[0];
			$string = $user_func($params[1]);
			$formtext = str_replace($_match[0][$key],$string,$formtext);
		}
		$id  = $this->id ? $this->id : 0;
		$formtext = str_replace('{ID}',$id,$formtext);
		$errortips = $this->fields[$field]['errortips'];
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:'.$minlength.',max:'.$maxlength.',onerror:"'.$errortips.'"});';

		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"'.$errortips.'",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		return $formtext;
	}

	function video($field, $value, $fieldinfo) {
		$value_data = '';
		//获取flash上传属性
		pc_base::load_app_class('ku6api', 'video', 0);
		$setting = getcache('video', 'video');
		if(empty($setting)) return L('please_input_video_setting');
		$ku6api = new ku6api($setting['sn'], $setting['skey']);
		$flash_info = $ku6api->flashuploadparam();
		
		//获取上传的视频
		$key = 0;
		$list_str = "<div style='padding:1px'><ul class=\"tbsa\" id=\"video_{$field}_list\">";
		if($value) {
			$video_content_db = pc_base::load_model('video_content_model');
			$video_store_db = pc_base::load_model('video_store_model');
			$videos = $video_content_db->select(array('contentid'=>$this->id), 'videoid, listorder', '', '`listorder` ASC', '', 'videoid');
			if (!empty($videos)) {
				$videoids = '';
				foreach ($videos as $v) {
					$videoids .= $v['videoid'].',';
				}
				$videoids = substr($videoids, 0, -1);
				$result = $video_store_db->select("`videoid` IN($videoids)", '`videoid`, `title`, `picpath`', '', '', '', 'videoid');
				if (is_array($result)) {
					//首先对$result按照$videos的videoid排序
					foreach ($videos as $_vid => $v) {
						$new_result[] = $result[$_vid];
					}
					unset($result, $_vid, $v);
					foreach ($new_result as $_k => $r) {
						$key = $_k+1;
						$picpath = $r['picpath'] ? $r['picpath'] : IMG_PATH.'nopic.gif';
						$list_str .= "<li class=\"ac\" id=\"video_{$field}_{$key}\"><div class=\"r1\"><img src=\"{$r['picpath']}\" onerror=\"".IMG_PATH."nopic.jpg\" width=\"132\" height=\"75\"><input type='text' name='{$field}_video[{$key}][title]' value='".$r['title']."' class=\"input-text ipt_box\"><input type='hidden' name='{$field}_video[{$key}][videoid]' value='{$r[videoid]}'><div class=\"r2\"><span class=\"l\"><label>".L('listorder')."</label><input type='text' name='{$field}_video[$key][listorder]' value='".$videos[$r['videoid']]['listorder']."' class=\"input-text\"></span><span class=\"r\"> <a href=\"javascript:remove_div('video_{$field}_{$key}')\">".L('delete')."</a></span></li>";
					}
				}
			}
		}
		$list_str .= "</ul></div>";
		$data = '';
		if (!defined('SWFOBJECT_INIT')) {
			$data .= '<script type="text/javascript" src="'.JS_PATH.'video/swfobject2.js"></script>';
			$data .= '<script type="text/javascript" src="'.JS_PATH.'video/vod2ckedit.js"></script>';
			define('SWFOBJECT_INIT', 1);
			$data .= '<SCRIPT LANGUAGE="JavaScript">

<!--

var js4swf = {

    onInit: function(list)

    {

        // 初始化时调用, 若 list.length > 0 代表有可续传文件

        // [{file}, {file}]

if(list.length > 0) {

    var length = list.length-1;

$("#list_name").html("'.L('file', '', 'video').'"+list[length].name+"'.L('failed_uplaod_choose_again', '', 'video').'");

}

        this.showMessage("init", list);

    },

    onSelect: function(files)

    {

        // 选中文件后调用, 返回文件列表

        // [{file}, {file}]

        this.showMessage("select", files);

    },

    onSid: function(evt)

    {

        // 获得 sid 后返回, 更新 sid 用 (key, sid, name, type, size)

$("#video_title").val(evt.name);
		var ku6vid = evt.vid;
		$.get(\'index.php\', {m:\'video\', c:\'vid\', a:\'check\', vid:ku6vid});
        this.showMessage("sid", evt);

    },

    onStart: function()

    {

        // 开始上传 (选择文件后自动开始)

        this.showMessage("start");

    },

    onCancel: function()

    {

        // 上传取消事件



        this.showMessage("cancel");

    },

    onProgress: function(evt)

    {

        // 上传进度事件 (bytesLoaded, bytesTotal, speed) m=1 时没有这事件

        this.showMessage("progress", evt);

    },

    onComplete: function(evt)

    {

        // 上传完成事件 (包含文件信息和完成后返回数据(data))
$("#vid").val(evt.vid);
var video_num = parseInt($("#key").val()) + 1;
var title = $("#video_title").val();
var vid = $("#vid").val();
var html = "<li id=\"video_'.$field.'_"+video_num+"\"><div class=\"r1\"><img src=\"'.IMG_PATH.'nopic.jpg\" width=\"132\" height=\"75\"><input type=\"text\" name=\"'.$field.'_video["+video_num+"][title]\" value=\""+title+"\" class=\"input-text\"><input type=\"hidden\" name=\"'.$field.'_video["+video_num+"][vid]\" value=\""+vid+"\"><div class=\"r2\"><span class=\"l\"><label>'.L('listorder').'</label><input type=\"text\" class=\"input-text\" name=\"'.$field.'_video["+video_num+"][listorder]\" value=\""+video_num+"\" ></span><span class=\"r\"> <a href=\"javascript:remove_div(\'video_'.$field.'_"+video_num+"\')\">'.L('delete').'</a></span></li>";

$("#video_'.$field.'_list").append(html);
$("#key").val(video_num);
$("#video_title").val("");

swfobject.embedSWF("'.$flash_info['flashurl'].'", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);


//document.getElementById("frm").submit();

        this.showMessage("complete", evt);

        

    },

    onWarn: function(evt)

    {

        // 报错事件 (key, message)

        //this.showMessage("warn", evt);

alert(evt.msg);

    },

    showMessage: function()

    {

        console.log(arguments);

    }

};

//-->

</SCRIPT>
<script type="text/javascript">
var flashvars = { m: "1", u: "'.$flash_info['userid'].'", ctime: "'.$flash_info['passport_ctime'].'", sig:"'.$flash_info['passport_sig'].'", c: "vms", t: "1", n: "js4swf", k: "190000" ,ms:"39",s: "8000000"};
var params = { allowScriptAccess: "always" , wmode: "transparent"};
var attributes = { };
//swfobject.embedSWF("http://player.ku6cdn.com/default/podcast/upload/201104261840/ku6uploader.swf", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
swfobject.embedSWF("'.$flash_info['flashurl'].'", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
</script>';
		}
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
		$video_store_sel = defined('IN_ADMIN') ? '<div class="picBut cu video_btn" style="float:right; margin-top:10px;"><a herf="javascript:void(0);" onclick="javascript:video_store_select(\''.$field.'_videoes\', \''.L('choose_videoes').'\',\'video_'.$field.'_list\',change_videoes, \''.$_GET['pc_hash'].'\')"> '.L('videoes_store').' </a></div>' : '';
		$vms_str = $flash_info['allow_upload_to_vms'] ? '<label class="ib cu" style="width:125px"><input type="radio" name="channelid" value="2">'. L('upload_to_ku6vms', '', 'video').' </label>' : '';
		return $data.'<input name="info['.$field.']" type="hidden" value="1"><input type="hidden" id="key" value="'.$key.'"><fieldset class="blue pad-10">
        <legend>'.L('videoes_lists').'</legend><center><div class="onShow" id="nameTip">'.L('videoes_num').'</center><div id="videoes" class="picList">'.$list_str.'</div>
		</fieldset>
		
		<table width="100%" border="0" cellspacing="1" class="tbb">
    <tbody><tr>
      <td width="15%" height="40">'.L('select_upload_channel', '', 'video').'</td>
      <td height="40"><label class="ib cu" style="width:125px"><input type="radio" name="channelid" value="1" checked> '.L('upload_to_ku6').' </label>'.$vms_str.'
	  </td>
    </tr>
	<tr>
      <td width="15%" height="40"><div align="right" ><input class="input_style" type="text" value="'.L('video_title', '', 'video').'" name="video_title" id="video_title" size="10"></div></td>
      <td height="40">
	  '.$video_store_sel.'
	  <div id="ku6uploader"></div><BR><span id="list_name" style="color:red"></span></td><input type="hidden" id="vid" name="vid" value="">
    </tr>
  </tbody></table>';
	}
 } 
?>