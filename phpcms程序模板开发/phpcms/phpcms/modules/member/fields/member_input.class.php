<?php
class member_input {
	var $modelid;
	var $fields;
	var $data;

    function __construct($modelid) {
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->db_pre = $this->db->db_tablepre;
		$this->modelid = $modelid;
		$this->fields = getcache('model_field_'.$modelid,'model');

		//初始化附件类
		pc_base::load_sys_class('attachment','',0);
		$this->siteid = param::get_cookie('siteid');
		$this->attachment = new attachment('content','0',$this->siteid);

    }

	function get($data) {
		$this->data = $data = trim_script($data);
		$model_cache = getcache('member_model', 'commons');
		$this->db->table_name = $this->db_pre.$model_cache[$this->modelid]['tablename'];

		$info = array();
		$debar_filed = array('catid','title','style','thumb','status','islink','description');
		if(is_array($data)) {
			foreach($data as $field=>$value) {
				if($data['islink']==1 && !in_array($field,$debar_filed)) continue;
				$field = safe_replace($field);
				$name = $this->fields[$field]['name'];
				$minlength = $this->fields[$field]['minlength'];
				$maxlength = $this->fields[$field]['maxlength'];
				$pattern = $this->fields[$field]['pattern'];
				$errortips = $this->fields[$field]['errortips'];
				if(empty($errortips)) $errortips = "$name 不符合要求！";
				$length = empty($value) ? 0 : strlen($value);
				if($minlength && $length < $minlength && !$isimport) showmessage("$name 不得少于 $minlength 个字符！");
				if (!array_key_exists($field, $this->fields)) showmessage('模型中不存在'.$field.'字段');
				if($maxlength && $length > $maxlength && !$isimport) {
					showmessage("$name 不得超过 $maxlength 个字符！");
				} else {
					str_cut($value, $maxlength);
				}
				if($pattern && $length && !preg_match($pattern, $value) && !$isimport) showmessage($errortips);
	            if($this->fields[$field]['isunique'] && $this->db->get_one(array($field=>$value),$field) && ROUTE_A != 'edit') showmessage("$name 的值不得重复！");
				$func = $this->fields[$field]['formtype'];
				if(method_exists($this, $func)) $value = $this->$func($field, $value);
	
				$info[$field] = $value;
			}
		}
		return $info;
	}
}?>