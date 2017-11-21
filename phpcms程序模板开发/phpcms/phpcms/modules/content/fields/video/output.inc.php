
	function video($field, $value) {
		$video_content_db = pc_base::load_model('video_content_model');
		$video_store_db = pc_base::load_model('video_store_model');
		//先获取目前contentid下面的videoid
		$videos = $video_content_db->select(array('contentid'=>$this->id, 'modelid'=>$this->modelid), 'videoid', '', '`listorder` ASC', '', 'videoid');
		if (is_array($videos) && !empty($videos)) {
			$videoids = '';
			foreach ($videos as $_vid => $r) {
				$videoids .= $_vid.',';
			}
			$videoids = substr($videoids, 0, -1);
			$result = $video_store_db->select("`videoid` IN($videoids) AND `status`=21", '*', '', '', '', 'videoid');
			$pagenumber = count($result);
			$return_data = array();
			if ($pagenumber>0) {
				if (is_array($result) && !empty($result)) {
					//首先对$result按照$videos的videoid排序
					foreach ($videos as $_vid => $v) {
						if ($result[$_vid]) $new_result[] = $result[$_vid];
					}
					unset($result, $_vid, $v);
				}

				$this->url = pc_base::load_app_class('url', 'content');
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($this->id, $i, $this->data['catid'], $this->data['inputtime']);
				}
				//构建返回数组
				foreach ($pageurls as $page =>$urls) {
					$_k = $page - 1;
					if ($_k==0) $arr = reset($new_result);
					else $arr = next($new_result);
					$return_data['data'][$page]['title'] = $arr['title'] ? new_html_special_chars($arr['title']) : new_html_special_chars($this->data['title']);
					$return_data['data'][$page]['url'] = $urls[0];
					$return_data['vid'] = $arr['vid'];
					$return_data['channelid'] = $arr['channelid'];
				}

				$category_db = pc_base::load_model('category_model');
				$r = $category_db->get_one(array('catid'=>$this->data['catid']), 'modelid, setting, siteid');
				$setting = string2array($r['setting']);
				$siteid = intval($r['siteid']);
				if ($setting['content_ishtml']) {
					if (!function_exists('content_pages')) {
						pc_base::load_app_func('util', 'content');
					}
					$modelid = intval($r['modelid']);
					
					$data = $this->data;
					unset($data[$field]);
					$output_data = $this->get($data);
					extract($output_data);
					$id = $this->id;
					//SEO
					$seo_keywords = '';
					if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
					$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);

					$this->html_root = pc_base::load_config('system','html_root');
					$this->sitelist = getcache('sitelist','commons');
					$this->queue = pc_base::load_model('queue_model');
					$template = $this->data['template'] ? $this->data['template'] : $setting['show_template'];
					foreach ($pageurls as $page => $urls) {
						$_k = $page - 1;
						if ($_k==0) {
							$arr = $first = reset($new_result);
						} else {
							$arr = next($new_result);
						}
						$return_data['vid'] = $arr['vid'];
						${$field} = $return_data;
						$pagefile = $urls[1];
						if($siteid!=1) {
							$site_dir = $this->sitelist[$siteid]['dirname'];
							$pagefile = $this->html_root.'/'.$site_dir.$pagefile;
						}
						$this->queue->add_queue('add',$pagefile,$siteid);
						$pagefile = PHPCMS_PATH.$pagefile;
						ob_start();
						include template('content', $template);
						$data = ob_get_contents();
						ob_clean();
						$dir = dirname($pagefile);
						if(!is_dir($dir)) {
							mkdir($dir, 0777,1);
						}
						$strlen = file_put_contents($pagefile, $data);
						@chmod($file,0777);
					}
					$return_data['vid'] = $first['vid'];
					unset($new_result);
				}
				return $return_data;
			} else {
				return array();
			}
		}
	}