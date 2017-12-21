	function number($field, $value, $fieldinfo) {
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$errortips = $this->fields[$field]['errortips'];
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"'.$errortips.'",onfocus:"'.$errortips.'"}).inputValidator({min:'.$minnumber.',max:'.$maxnumber.',onerror:"'.$errortips.'"}).regexValidator({regexp:"num",datatype:"enum",onerror:"'.$errortips.'"});';
		return "<input type='text' name='info[$field]' id='$field' value='$value' size='$size' $this->no_allowed class='input-text' {$formattribute} {$css}>";
	}
