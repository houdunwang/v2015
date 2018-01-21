	function linkage($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$datas = getcache($setting['linkageid'],'linkage');
		$infos = $datas['data'];
		if($setting['showtype']==1) {
			$result = $this->_get_parent($value, $setting['linkageid'], $setting['space']);
		} elseif($setting['showtype']==2) {
			$result = $value;
		} else {
			$result = $infos[$value]['name'];
		}
		return $result;
	}
	function _get_parent($linkageid, $keyid, $space = '>', $result = array(), $infos = array()) {
		if($space=='' || !isset($space))$space = '>';
		if(!$infos) {
			$datas = getcache($keyid,'linkage');
			$infos = $datas['data'];
		}
		if(array_key_exists($linkageid,$infos)) {
			$result[]=$infos[$linkageid]['name'];
			return $this->_get_parent($infos[$linkageid]['parentid'], $keyid, $space, $result, $infos);
		} else {
			if(count($result)>0) {
				krsort($result);
				$result = implode($space,$result);
				return $result;
			}
			else {
				return $result;
			}
		}			
	}
