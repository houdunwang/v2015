<?php
class formguide_output {
	var $fields;
	var $data;

	function __construct($formid) {
		$this->formid = $formid;
		$this->fields = getcache('formguide_field_'.$formid, 'model');
		$this->siteid = get_siteid();
    }
	function get($data) {
		$this->data = $data;
		$this->id = $data['id'];
		$info = array();
		foreach($this->fields as $field=>$v) {
			if(!isset($data[$field])) continue;
			$func = $v['formtype'];
			$value = $data[$field];
			$result = method_exists($this, $func) ? $this->$func($field, $data[$field]) : $data[$field];
			if($result !== false) $info[$field] = $result;
		}
		return $info;
	}
}?>