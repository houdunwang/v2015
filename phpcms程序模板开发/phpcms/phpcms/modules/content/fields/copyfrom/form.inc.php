	function copyfrom($field, $value, $fieldinfo) {
		$value_data = '';
		if($value && strpos($value,'|')!==false) {
			$arr = explode('|',$value);
			$value = $arr[0];
			$value_data = $arr[1];
		}
		$copyfrom_array = getcache('copyfrom','admin');
		$copyfrom_datas = array(L('copyfrom_tips'));
		if(!empty($copyfrom_array)) {
			foreach($copyfrom_array as $_k=>$_v) {
				if($this->siteid==$_v['siteid']) $copyfrom_datas[$_k] = $_v['sitename'];
			}
		}
		return "<input type='text' name='info[$field]' value='$value' style='width: 400px;' class='input-text'>".form::select($copyfrom_datas,$value_data,"name='{$field}_data' ");
	}
