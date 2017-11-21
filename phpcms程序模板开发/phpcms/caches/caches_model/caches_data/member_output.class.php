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
	function editor($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		if($setting['enablekeylink']) {
			$data = $this->_keylinks($value, $setting['replacenum'],$setting['link_mode']);
		}
		return $data;
	}
	function _base64_encode($t,$str) {
		return $t."\"".base64_encode($str)."\"";
	}
	function _base64_decode($t,$str) {
		return $t."\"".base64_decode($str)."\"";
	}
	function _keylinks($txt, $replacenum = '',$link_mode = 1) {
		$txt = addslashes($txt);
		$search = "/(alt\s*=\s*|title\s*=\s*)[\"|\'](.+?)[\"|\']/ise";
		$replace = "$this->_base64_encode('\\1','\\2')";
		$replace1 = "$this->_base64_decode('\\1','\\2')";
		$txt = preg_replace($search, $replace, $txt);
		$keywords = $this->data['keywords'];
		if($keywords) $keywords = strpos(',',$keywords) === false ? explode(' ',$keywords) : explode(',',$keywords);
		if($link_mode && !empty($keywords)) {
			foreach($keywords as $keyword) {
				$linkdatas[] = $keyword;
			}
		} else {
			//TODO 
			$linkdatas = array(
				0 => array(0=>'网站',1=>'http://www.phpip.com'),
				1 => array(0=>'百度',1=>'http://www.baidu.com'),
			);
		}
		if($linkdatas) {
			$word = $replacement = array();
			foreach($linkdatas as $v) {
				if($link_mode && $keywords) {
					$word1[] = '/'.preg_quote($v, '/').'/';
					$word2[] = $v;
					$replacement[] = '<a href="javascript:;" onclick="show_ajax(this)" class="keylink">'.$v.'</a>';
				} else {
					$word1[] = '/'.preg_quote($v[0], '/').'/';
					$word2[] = $v[0];
					
					$replacement[] = '<a href="'.$v[1].'" target="_blank" class="keylink">'.$v[0].'</a>';
				}
			}
			if($replacenum != '') {
				$txt = preg_replace($word1, $replacement, $txt, $replacenum);
			} else {
				$txt = str_replace($word2, $replacement, $txt);
			}
		}
		$txt = preg_replace($search, $replace1, $txt);
		$txt = stripslashes($txt);
		return $txt;
	}
	function box($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		if($outputtype) {
			return $value;
		} else {
			$options = explode("\n",$this->fields[$field]['options']);
			foreach($options as $_k) {
				$v = explode("|",$_k);
				$k = trim($v[1]);
				$option[$k] = $v[0];
			}
			$string = '';
			switch($this->fields[$field]['boxtype']) {
				case 'radio':
					$string = $option[$value];
				break;

				case 'checkbox':
					$value_arr = explode(',',$value);
					foreach($value_arr as $_v) {
						if($_v) $string .= $option[$_v].' 、';
					}
				break;

				case 'select':
					$string = $option[$value];
				break;

				case 'multiple':
					$value_arr = explode(',',$value);
					foreach($value_arr as $_v) {
						if($_v) $string .= $option[$_v].' 、';
					}
				break;
			}
			return $string;
		}
	}
	function images($field, $value) {
		return string2array($value);
	}
	function datetime($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		extract($setting);
		if($fieldtype=='date') {
			$format_txt = 'Y-m-d';
		} elseif($fieldtype=='datetime') {
			$format_txt = 'Y-m-d H:i:s';
		} else {
			$format_txt = $format;
		}
		if(strlen($format_txt)<6) {
			$isdatetime = 0;
		} else {
			$isdatetime = 1;
		}
		if(!$value) $value = SYS_TIME;
		$value = date($format_txt,$value);
		return $value;
	}
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

 } 
?>