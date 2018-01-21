
	function keyword ($field, $value) {
		//获取post过来的关键字，关键字用空格或者‘,’分割的
		$data = array();
		$data = preg_split("/[ ,]+/", $value);
		//加载关键字的数据模型
		$keyword_db = pc_base::load_model('keyword_model');
		$keyword_data_db = pc_base::load_model('keyword_data_model');
		pc_base::load_sys_func('iconv');
		if (is_array($data) && !empty($data)) {
			$siteid = get_siteid();
			foreach ($data as $v) {
				$v = defined('IN_ADMIN') ? $v : safe_replace(addslashes($v));
				$v = str_replace(array('//','#','.'),' ',$v);
				if (!$r = $keyword_db->get_one(array('keyword'=>$v, 'siteid'=>$siteid))) {
					$letters = gbk_to_pinyin($v);
					$letter = strtolower(implode('', $letters));
					$tagid = $keyword_db->insert(array('keyword'=>$v, 'siteid'=>$siteid, 'pinyin'=>$letter, 'videonum'=>1), true);
				} else {
					$keyword_db->update(array('videonum'=>'+=1'), array('id'=>$r['id']));
					$tagid = $r['id'];
				}
				$contentid = $this->id.'-'.$this->modelid;
				if (!$keyword_data_db->get_one(array('tagid'=>$tagid, 'siteid'=>$siteid, 'contentid'=>$contentid))) {
					$keyword_data_db->insert(array('tagid'=>$tagid, 'siteid'=>$siteid, 'contentid'=>$contentid));
				}
				unset($contentid, $tagid, $letters);
			}
		}
		return $value;
	}
