<?php
class formguide_input {
	var $formid;
	var $fields;
	var $data;

    function __construct($formid) {
		$this->formid = $formid;
		$this->fields = getcache('formguide_field_'.$formid, 'model');
		$this->siteid = get_siteid();
		//初始化附件类
		pc_base::load_sys_class('attachment','',0);
		$this->siteid = param::get_cookie('siteid');
		$this->attachment = new attachment('formguide','0',$this->siteid);
		$this->site_config = getcache('sitelist','commons');
		$this->site_config = $this->site_config[$this->siteid];
    }

	function get($data,$isimport = 0) {
		$this->data = $data = trim_script($data);
		$info = array();
		foreach($this->fields as $field) {
			//if(!isset($this->fields[$field]) || check_in($_roleid, $this->fields[$field]['unsetroleids']) || check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
			$name = $field['name'];
			$minlength = $field['minlength'];
			$maxlength = $field['maxlength'];
			$pattern = $field['pattern'];
			$errortips = $field['errortips'];
			$value = $data[$field['field']];
			if(empty($errortips)) $errortips = $name.' '.L('not_meet_the_conditions');
			$length = is_array($value) ? (empty($value) ? 0 : 1) : strlen($value);

			if($minlength && $length < $minlength) {
				if($isimport) {
					return false;
				} else {
					showmessage($name.' '.L('not_less_than').' '.$minlength.L('characters'));
				}
			}
			if($maxlength && $length > $maxlength) {
				if($isimport) {
					$value = str_cut($value,$maxlength,'');
				} else {
					showmessage($name.' '.L('not_more_than').' '.$maxlength.L('characters'));
				}
			} elseif($maxlength) {
				$value = str_cut($value,$maxlength,'');
			}
			if($pattern && $length && !preg_match($pattern, $value) && !$isimport) showmessage($errortips);
			$func = $field['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field['field'], $value);
			$info[$field['field']] = $value;
			//颜色选择为隐藏域 在这里进行取值
			if ($_POST['style_color']) $info['style'] = $_POST['style_color'];
			if($_POST['style_font_weight']) $info['style'] = $info['style'].';'.strip_tags($_POST['style_font_weight']);
		}
		return $info;
	}
	function textarea($field, $value) {
		if(!$this->fields[$field]['enablehtml']) $value = strip_tags($value);
		return $value;
	}
	function editor($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$enablesaveimage = $setting['enablesaveimage'];
		$site_setting = string2array($this->site_config['setting']);
		$watermark_enable = intval($site_setting['watermark_enable']);
		$value = $this->attachment->download('content', $value,$watermark_enable);
		return $value;
	}
	function box($field, $value) {
		if($this->fields[$field]['boxtype'] == 'checkbox') {
			if(!is_array($value) || empty($value)) return false;
			array_shift($value);
			$value = implode(',', $value);
			return $value;
		} elseif($this->fields[$field]['boxtype'] == 'multiple') {
			if(is_array($value) && count($value)>1) {
				$value = implode(',', $value);
				return $value;
			}
		} else {
			return $value;
		}
	}
	function images($field, $value) {
		//取得图片列表
		$pictures = $_POST[$field.'_url'];
		//取得图片说明
		$pictures_alt = isset($_POST[$field.'_alt']) ? $_POST[$field.'_alt'] : array();
		$array = $temp = array();
		if(!empty($pictures)) {
			foreach($pictures as $key=>$pic) {
				$temp['url'] = $pic;
				$temp['alt'] = str_replace(array('"',"'"),'`',$pictures_alt[$key]);
				$array[$key] = $temp;
			}
		}
		$array = array2string($array);
		return $array;
	}
	function datetime($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		if($setting['fieldtype']=='int') {
			$value = strtotime($value);
		}
		return $value;
	}

 } 
?>