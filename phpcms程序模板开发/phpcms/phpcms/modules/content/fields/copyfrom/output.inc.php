	function copyfrom($field, $value) {
		static $copyfrom_array;
		if(!$copyform_array) $copyfrom_array = getcache('copyfrom','admin');
		if($value && strpos($value,'|')!==false) {
			$arr = explode('|',$value);
			$value = $arr[0];
			$value_data = $arr[1];
		}
		if($value_data) {
			$copyfrom_link = $copyfrom_array[$value_data];
			if(!empty($copyfrom_array)) {
				$imgstr = '';
				if($value=='') $value = $copyfrom_link['siteurl'];
				if($copyfrom_link['thumb']) $imgstr = "<a href='{$copyfrom_link[siteurl]}' target='_blank'><img src='{$copyfrom_link[thumb]}' height='15'></a> ";
				return $imgstr."<a href='$value' target='_blank' style='color:#AAA'>{$copyfrom_link[sitename]}</a>";
			}
		} else {
			return $value;
		}
	}
