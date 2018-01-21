	function linkage($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$datas = getcache($setting['linkageid'],'linkage');
		$infos = $datas['data'];
		if($setting['showtype']==1 || $setting['showtype']==3) {
			$result = get_linkage($value, $setting['linkageid'], $setting['space'], $setting['showtype']);
		} elseif($setting['showtype']==2) {
			$result = $value;
		} else {
			$result = get_linkage($value, $setting['linkageid'], $setting['space'], 2);
		}
		return $result;
	}

