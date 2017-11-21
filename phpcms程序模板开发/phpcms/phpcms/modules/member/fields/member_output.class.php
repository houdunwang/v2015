<?php
class member_output {
	var $fields;
	var $data;

	function __construct($modelid,$catid = 0,$categorys = array()) {
		$this->modelid = $modelid;
		$this->catid = $catid;
		$this->categorys = $categorys;
		$this->fields = getcache('model_field_'.$modelid,'model');
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