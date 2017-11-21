<?php
class member_form {
	var $modelid;
	var $fields;
	var $id;
	var $formValidator;

    function __construct($modelid) {
		$this->modelid = $modelid;
		$this->fields = getcache('model_field_'.$modelid,'model');
    }

	function get($data = array()) {
		$_roleid = param::get_cookie('_roleid');
		$_groupid = param::get_cookie('_groupid');
		$this->data = $data;
		if(isset($data['id'])) $this->id = $data['id'];
		$info = array();
		foreach($this->fields as $field=>$v) {
			if(defined('IN_ADMIN')) {
				if($v['disabled'] || $v['iscore'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			} else {
				if($v['disabled'] || $v['iscore'] || !$v['isadd'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			$func = $v['formtype'];
			$value = isset($data[$field]) ? new_html_special_chars($data[$field]) : '';
			if($func=='pages' && isset($data['maxcharperpage'])) {
				$value = $data['paginationtype'].'|'.$data['maxcharperpage'];
			}
			if(!method_exists($this, $func)) continue;
			$form = $this->$func($field, $value, $v);
			if($form !== false) {
				$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
				$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star, 'isbase'=>$v['isbase'],'isomnipotent'=>$v['isomnipotent'],'formtype'=>$v['formtype']);
			}
		}
		return $info;
	}
}?>