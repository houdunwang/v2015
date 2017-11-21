	function posid($field, $value) {
		if(!empty($value) && is_array($value)) {
			if($_GET['a']=='add') {
				$position_data_db = pc_base::load_model('position_data_model');
				$textcontent = array();
				foreach($value as $r) {
					if($r!='-1') {
						if(empty($textcontent)) {
							foreach($this->fields AS $_key=>$_value) {
								if($_value['isposition']) {
									$textcontent[$_key] = $this->data[$_key];
								}
							}
							$textcontent = array2string($textcontent);
						}
						$thumb = $this->data['thumb'] ? 1 : 0;
						$position_data_db->insert(array('id'=>$this->id,'catid'=>$this->data['catid'],'posid'=>$r,'thumb'=>$thumb,'module'=>'content','modelid'=>$this->modelid,'data'=>$textcontent,'listorder'=>$this->id,'siteid'=>get_siteid()));
					}
				}
			} else {
				$posids = array();
				$catid = $this->data['catid'];
				$push_api = pc_base::load_app_class('push_api','admin');
				foreach($value as $r) {
					if($r!='-1') $posids[] = $r;
				}
				$textcontent = array();
				foreach($this->fields AS $_key=>$_value) {
					if($_value['isposition']) {
						$textcontent[$_key] = $this->data[$_key];
					}
				}
				//颜色选择为隐藏域 在这里进行取值
				$textcontent['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
				$textcontent['inputtime'] = strtotime($textcontent['inputtime']);
				if($_POST['style_font_weight']) $textcontent['style'] = $textcontent['style'].';'.strip_tags($_POST['style_font_weight']);
				$push_api->position_update($this->id, $this->modelid, $catid, $posids, $textcontent,0);
			}
		}
	}
