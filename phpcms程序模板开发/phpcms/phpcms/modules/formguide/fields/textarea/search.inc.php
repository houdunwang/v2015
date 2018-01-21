	function text($field, $value)
	{
		return $value === '' ? '' : " `$field` LIKE '%$value%' ";
	}
