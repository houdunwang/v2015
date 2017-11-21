	
	function video($field, $value) {
		if ($value) {
			$value = $GLOBALS[$field];
		} else {
			return '';
		}
		$video_content_db = pc_base::load_model('video_content_model');
		//先获取目前contentid下面的videoid
		$result = $video_content_db->select(array('contentid'=>$this->id, 'modelid'=>$this->modelid), 'videoid');
		if (is_array($result)) {
			$video_arr = array();
			foreach ($result as $r) {
				$video_arr[] = $r['videoid'];
			}
		}
		if(!empty($value) && is_array($value)) {
			
			foreach ($value as $v) {
				if (!empty($video_arr) && !in_array($v['videoid'], $video_arr)) {
					$video_content_db->insert(array('contentid'=>$this->id, 'modelid'=>$this->modelid, 'videoid'=>$v['videoid'], 'listorder'=>$v['listorder']));
					$s_key = array_search($v['videoid'], $video_arr);
					unset($video_arr[$s_key]);
				} elseif (empty($video_arr)) {
					$video_content_db->insert(array('contentid'=>$this->id, 'modelid'=>$this->modelid, 'videoid'=>$v['videoid'], 'listorder' => $v['listorder']));
				} elseif (in_array($v['videoid'], $video_arr)) {
					$video_content_db->update(array('listorder'=>$v['listorder']), array('contentid'=>$this->id, 'modelid'=>$this->modelid, 'videoid'=>$v['videoid']));
					$s_key = array_search($v['videoid'], $video_arr);
					unset($video_arr[$s_key]);
				}
			}
			//删除需要删除的videoid
			if ($video_arr && !empty($video_arr)) {
				foreach ($video_arr as $dvid) {
					$video_content_db->delete(array('contentid'=>$this->id, 'modelid'=>$this->modelid, 'videoid'=>$dvid));
				}
 			}
		} elseif (!empty($video_arr) && is_array($video_arr)) {
			foreach ($video_arr as $dvid) {
				$video_content_db->delete(array('contentid'=>$this->id, 'modelid'=>$this->modelid, 'videoid'=>$dvid));
			}
		}
	}