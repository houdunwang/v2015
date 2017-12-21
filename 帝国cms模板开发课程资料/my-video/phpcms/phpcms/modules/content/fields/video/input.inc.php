	
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
