	function datetime($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$isdatetime = 0;
		if($fieldtype=='int') {
			if(!$value) $value = SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			$value = date($format_txt,$value);
			$isdatetime = strlen($format) > 6 ? 1 : 0;
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
		}
		return form::date("info[$field]",$value,$isdatetime,1);
	}
