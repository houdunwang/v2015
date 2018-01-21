<?php
class content_input {
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
		$this->site_config = getcache('sitelist','commons');
		$this->site_config = $this->site_config[$this->siteid];
    }

	function get($data,$isimport = 0) {
		$this->data = $data = trim_script($data);
		$info = array();
		foreach($data as $field=>$value) {
			if(!isset($this->fields[$field]) && !check_in($field,'paytype,paginationtype,maxcharperpage,id')) continue;
			if(defined('IN_ADMIN')) {
				if(check_in($_SESSION['roleid'], $this->fields[$field]['unsetroleids'])) continue;
			} else {
				$_groupid = param::get_cookie('_groupid');
				if(check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
			}
			$name = $this->fields[$field]['name'];
			$minlength = $this->fields[$field]['minlength'];
			$maxlength = $this->fields[$field]['maxlength'];
			$pattern = $this->fields[$field]['pattern'];
			$errortips = $this->fields[$field]['errortips'];
			if(empty($errortips)) $errortips = $name.' '.L('not_meet_the_conditions');
			$length = empty($value) ? 0 : (is_string($value) ? strlen($value) : count($value));

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
			$MODEL = getcache('model', 'commons');
            $this->db->table_name = $this->fields[$field]['issystem'] ? $this->db_pre.$MODEL[$this->modelid]['tablename'] : $this->db_pre.$MODEL[$this->modelid]['tablename'].'_data';
            if($this->fields[$field]['isunique'] && $this->db->get_one(array($field=>$value),$field) && ROUTE_A != 'edit') showmessage($name.L('the_value_must_not_repeat'));
			$func = $this->fields[$field]['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field, $value);
			if($this->fields[$field]['issystem']) {
				$info['system'][$field] = $value;
			} else {
				$info['model'][$field] = $value;
			}
			//颜色选择为隐藏域 在这里进行取值
			$info['system']['style'] = $_POST['style_color'] && preg_match('/^#([0-9a-z]+)/i', $_POST['style_color']) ? $_POST['style_color'] : '';
			if($_POST['style_font_weight']=='bold') $info['system']['style'] = $info['system']['style'].';'.strip_tags($_POST['style_font_weight']);
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
		if(isset($_POST['spider_img'])) $enablesaveimage = 0;
		if($enablesaveimage) {
			$site_setting = string2array($this->site_config['setting']);
			$watermark_enable = intval($site_setting['watermark_enable']);
			$value = $this->attachment->download('content', $value,$watermark_enable);
		}
		return $value;
	}
	function box($field, $value) {
		if($this->fields[$field]['boxtype'] == 'checkbox') {
			if(!is_array($value) || empty($value)) return false;
			array_shift($value);
			$value = ','.implode(',', $value).',';
			return $value;
		} elseif($this->fields[$field]['boxtype'] == 'multiple') {
			if(is_array($value) && count($value)>0) {
				$value = ','.implode(',', $value).',';
				return $value;
			}
		} else {
			return $value;
		}
	}
	function image($field, $value) {
		$value = remove_xss(str_replace(array("'",'"','(',')'),'',$value));
		$value  = safe_replace($value);
		return trim($value);
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
	function posid($field, $value) {
		$number = count($value);
		$value = $number==1 ? 0 : 1;
		return $value;
	}
	function copyfrom($field, $value) {
		$field_data = $field.'_data';
		if(isset($_POST[$field_data])) {
			$value .= '|'.safe_replace($_POST[$field_data]);
		}
		return $value;
	}
	function groupid($field, $value) {
		$datas = '';
		if(!empty($_POST[$field]) && is_array($_POST[$field])) {
			$datas = implode(',',$_POST[$field]);
		}
		return $datas;
	}
	function downfile($field, $value) {
		//取得镜像站点列表
		$result = '';
		$server_list = count($_POST[$field.'_servers']) > 0 ? implode(',' ,$_POST[$field.'_servers']) : '';
		$result = $value.'|'.$server_list;
		return $result;
	}
	function downfiles($field, $value) {
		$files = $_POST[$field.'_fileurl'];
		$files_alt = $_POST[$field.'_filename'];
		$array = $temp = array();
		if(!empty($files)) {
			foreach($files as $key=>$file) {
					$temp['fileurl'] = $file;
					$temp['filename'] = $files_alt[$key];
					$array[$key] = $temp;
			}
		}
		$array = array2string($array);
		return $array;
	}
	
	function video($field, $value) {
		$post_f = $field.'_video';
		if (isset($_POST[$post_f]) && !empty($_POST[$post_f])) {
			$value = 1;
			$video_store_db = pc_base::load_model('video_store_model');
			$setting = getcache('video', 'video');
			pc_base::load_app_class('ku6api', 'video', 0);
			$ku6api = new ku6api($setting['sn'], $setting['skey']);
			pc_base::load_app_class('v', 'video', 0);
			$v_class =  new v($video_store_db);
			$GLOBALS[$field] = '';
			foreach ($_POST[$post_f] as $_k => $v) {
				if (!$v['vid'] && !$v['videoid']) unset($_POST[$post_f][$_k]);
				$info = array();
				if (!$v['title']) $v['title'] = safe_replace($this->data['title']);
				if ($v['vid']) { 
					$info = array('vid'=>$v['vid'], 'title'=>$v['title'], 'cid'=>intval($this->data['catid']));
					$info['channelid'] = intval($_POST['channelid']);
					if ($this->data['keywords']) $info['tag'] = addslashes($this->data['keywords']);
					if ($this->data['description']) $info['description'] = addslashes($this->data['description']);
					$get_data = $ku6api->vms_add($info);
					if (!$get_data) {
						continue;
					}
					$info['vid'] = $get_data['vid'];
					$info['addtime'] = SYS_TIME;
					$info['keywords'] = $info['tag'];
					unset($info['cid'], $info['tag']);
					$info['userupload'] = 1;
					$videoid = $v_class->add($info);
					$GLOBALS[$field][] = array('videoid' => $videoid, 'listorder' => $v['listorder']);
				} else {
					$v_class->edit(array('title'=>$v['title']), $v['videoid']);
					$GLOBALS[$field][] = array('videoid' => $v['videoid'], 'listorder' => $v['listorder']);
				}
			}
		} else {
			$value = 0;
		}
		return $value;
	}

 } 
?>