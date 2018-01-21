	function datetime($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		extract($setting);
		if($fieldtype=='date') {
			$format_txt = 'Y-m-d';
		} elseif($fieldtype=='datetime') {
			$format_txt = 'Y-m-d H:i:s';
		} else {
			$format_txt = $format;
		}
		if(strlen($format_txt)<6) {
			$isdatetime = 0;
		} else {
			$isdatetime = 1;
		}
		if(!$value) $value = SYS_TIME;
		$value = date($format_txt,$value);
		return $value;
	}
