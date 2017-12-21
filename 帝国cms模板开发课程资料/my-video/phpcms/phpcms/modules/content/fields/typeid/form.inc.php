	function typeid($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		if(!$value) $value = $setting['defaultvalue'];
		if($errortips) {
			$errortips = $this->fields[$field]['errortips'];
			$this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		}
		$usable_type = $this->categorys[$this->catid]['usable_type'];
		$usable_array = array();
		if($usable_type) $usable_array = explode(',',$usable_type);
		
		//获取站点ID
		if(intval($_GET['siteid'])){
			$siteid = intval($_GET['siteid']);
		}else{
			$siteid = $this->siteid;
		}
		$type_data = getcache('type_content_'.$siteid,'commons');
		if($type_data) {
			foreach($type_data as $_key=>$_value) {
				if(in_array($_key,$usable_array)) $data[$_key] = $_value['name'];
			}
		}
		return form::select($data,$value,'name="info['.$field.']" id="'.$field.'" '.$formattribute.' '.$css,L('copyfrom_tips'));
	}
