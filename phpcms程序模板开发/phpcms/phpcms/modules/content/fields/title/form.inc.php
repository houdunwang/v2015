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
