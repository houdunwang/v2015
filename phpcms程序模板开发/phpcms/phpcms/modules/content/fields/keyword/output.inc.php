	function keyword($field, $value) {
	    if($value == '') return '';
		$v = '';
		if(strpos($value, ',')===false) {
			$tags = explode(' ', $value);
		} else {
			$tags = explode(',', $value);
		}
		return $tags;
	}
