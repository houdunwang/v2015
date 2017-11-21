<?php
class formguide_form {
	var $formid;
	var $fields;
	var $id;
	var $formValidator;

    function __construct($formid, $no_allowed = 0) {
		$this->formid = $formid;
		$this->no_allowed = $no_allowed ? 'disabled=""' : '';
		$this->fields = getcache('formguide_field_'.$formid, 'model');
		$this->siteid = get_siteid();
    }

	function get($data = array()) {
		$_groupid = param::get_cookie('_groupid');
		$this->data = $data;
		if(isset($data['id'])) $this->id = $data['id'];
		$info = array();
		$info = array();
		if (is_array($this->fields)) { 
			foreach($this->fields as $field=>$v) {
				$func = $v['formtype'];
				$value = isset($data[$field]) ? new_html_special_chars($data[$field]) : '';
				if($func=='pages' && isset($data['maxcharperpage'])) {
					$value = $data['paginationtype'].'|'.$data['maxcharperpage'];
				}
				if(!method_exists($this, $func)) continue;
				$form = $this->$func($field, $value, $v);
				if($form !== false) {
					$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
					$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star,'isomnipotent'=>$v['isomnipotent'],'formtype'=>$v['formtype']);
				}
			}
		}
		return $info;
	}
}?>