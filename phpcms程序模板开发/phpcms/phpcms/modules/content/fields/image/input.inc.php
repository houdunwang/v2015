	function image($field, $value) {
		$value = remove_xss(str_replace(array("'",'"','(',')'),'',$value));
		$value  = safe_replace($value);
		return trim($value);
	}
