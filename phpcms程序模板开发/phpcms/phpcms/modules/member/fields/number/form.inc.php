	function number($field, $value, $fieldinfo) {
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$errortips = $this->fields[$field]['errortips'];
		$min = $minnumber ? ",min:$minnumber" : '';
		$max = $maxnumber ? ",max:$maxnumber" : '';
		if($errortips && $this->fields[$field]['isbase']) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"'.$errortips.'",onfocus:"'.$errortips.'"}).inputValidator({type:"number"'.$min.$max.',onerror:"'.$errortips.'"}).regexValidator({regexp:"num",datatype:"enum",onerror:"'.$errortips.'"});';
		return "<input type='text' name='info[$field]' id='$field' value='$value' size='$size' class='input-text' {$formattribute} {$css}>";
	}
