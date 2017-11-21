<?php
class content_update {
	var $modelid;
	var $fields;
	var $data;

    function __construct($modelid,$id) {
		$this->modelid = $modelid;
		$this->fields = getcache('model_field_'.$modelid,'model');
		$this->id = $id;
    }
	function update($data) {
		$info = array();
		$this->data = $data;
		foreach($data as $field=>$value) {
			if(!isset($this->fields[$field])) continue;
			$func = $this->fields[$field]['formtype'];
			$info[$field] = method_exists($this, $func) ? $this->$func($field, $value) : $value;
		}
	}
}?>