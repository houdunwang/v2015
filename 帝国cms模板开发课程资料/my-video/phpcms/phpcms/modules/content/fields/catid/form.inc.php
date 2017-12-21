	function catid($field, $value, $fieldinfo) {
		if(!$value) $value = $this->catid;
		$publish_str = '';
		if(defined('IN_ADMIN') && ROUTE_A=='add') $publish_str = " <a href='javascript:;' onclick=\"omnipotent('selectid','?m=content&c=content&a=add_othors&siteid=".$this->siteid."','".L('publish_to_othor_category')."',1);return false;\" style='color:#B5BFBB'>[".L('publish_to_othor_category')."]</a><ul class='list-dot-othors' id='add_othors_text'></ul>";
		return '<input type="hidden" name="info['.$field.']" value="'.$value.'">'.$this->categorys[$value]['catname'].$publish_str;
	}
