	function posid($field, $value) {
		$number = count($value);
		$value = $number==1 ? 0 : 1;
		return $value;
	}
