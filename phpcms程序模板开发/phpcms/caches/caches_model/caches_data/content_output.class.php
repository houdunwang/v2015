<?php
class content_output {
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
			$value = $this->_keylinks($value, $setting['replacenum'],$setting['link_mode']);
		}
		return $value;
	}
	function _base64_encode($matches) {
		return $matches[1]."\"".base64_encode($matches[2])."\"";
	}
	function _base64_decode($matches) {
		return $matches[1]."\"".base64_decode($matches[2])."\"";
	}
	function _keylinks($txt, $replacenum = '',$link_mode = 1) {
		$search = "/(alt\s*=\s*|title\s*=\s*)[\"|\'](.+?)[\"|\']/is";
		$txt = preg_replace_callback($search, array($this, '_base64_encode'), $txt);
		$keywords = $this->data['keywords'];
		if($keywords) $keywords = strpos(',',$keywords) === false ? explode(' ',$keywords) : explode(',',$keywords);
		if($link_mode && !empty($keywords)) {
			foreach($keywords as $keyword) {
				$linkdatas[] = $keyword;
			}
		} else {
			$linkdatas = getcache('keylink','commons');
		}
		if($linkdatas) {
			$word = $replacement = array();
			foreach($linkdatas as $v) {
				if($link_mode && $keywords) {
					$word1[] = '/(?!(<a.*?))' . preg_quote($v, '/') . '(?!.*<\/a>)/s';
					$word2[] = $v;
					$replacement[] = '<a href="javascript:;" onclick="show_ajax(this)" class="keylink">'.$v.'</a>';
				} else {
					$word1[] = '/(?!(<a.*?))' . preg_quote($v[0], '/') . '(?!.*<\/a>)/s';
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
		$txt = preg_replace_callback($search, array($this, '_base64_decode'), $txt);
		return $txt;
	}
	function title($field, $value) {
		$value = new_html_special_chars($value);
		return $value;
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
		if($fieldtype=='date' || $fieldtype=='datetime') {
			return $value;
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
	function keyword($field, $value) {
	    if($value == '') return '';
		$v = '';
		if(strpos($value, ',')===false) {
			$tags = explode(' ', $value);
		} else {
			$tags = explode(',', $value);
		}
		return $tags;
	}
	function copyfrom($field, $value) {
		static $copyfrom_array;
		if(!$copyform_array) $copyfrom_array = getcache('copyfrom','admin');
		if($value && strpos($value,'|')!==false) {
			$arr = explode('|',$value);
			$value = $arr[0];
			$value_data = $arr[1];
		}
		if($value_data) {
			$copyfrom_link = $copyfrom_array[$value_data];
			if(!empty($copyfrom_array)) {
				$imgstr = '';
				if($value=='') $value = $copyfrom_link['siteurl'];
				if($copyfrom_link['thumb']) $imgstr = "<a href='{$copyfrom_link[siteurl]}' target='_blank'><img src='{$copyfrom_link[thumb]}' height='15'></a> ";
				return $imgstr."<a href='$value' target='_blank' style='color:#AAA'>{$copyfrom_link[sitename]}</a>";
			}
		} else {
			return $value;
		}
	}
	function groupid($field, $value) {
		if($value) $value = explode(',',$value);
		return $value;
	}
	function linkage($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$datas = getcache($setting['linkageid'],'linkage');
		$infos = $datas['data'];
		if($setting['showtype']==1 || $setting['showtype']==3) {
			$result = get_linkage($value, $setting['linkageid'], $setting['space'], $setting['showtype']);
		} elseif($setting['showtype']==2) {
			$result = $value;
		} else {
			$result = get_linkage($value, $setting['linkageid'], $setting['space'], 2);
		}
		return $result;
	}

	function downfile($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		$list_str = array();
		if($value){
			$value_arr = explode('|',$value);
			$fileurl = $value_arr['0'];
			if($fileurl) {
				$sel_server = $value_arr['1'] ? explode(',',$value_arr['1']) : '';
				$server_list = getcache('downservers','commons');
				if(is_array($server_list)) {
					foreach($server_list as $_k=>$_v) {
						if($value && is_array($sel_server) && in_array($_k,$sel_server)) {
							$downloadurl = $_v[siteurl].$fileurl;
							if($downloadlink) {
								$a_k = urlencode(sys_auth("i=$this->id&s=$_v[siteurl]&m=1&f=$fileurl&d=$downloadtype&modelid=$this->modelid&catid=$this->catid", 'ENCODE', md5(PC_PATH.'down').pc_base::load_config('system','auth_key')));
								$list_str[] = "<a href='".APP_PATH."index.php?m=content&c=down&a_k={$a_k}' target='_blank'>{$_v[sitename]}</a>";
							} else {
								$list_str[] = "<a href='{$downloadurl}' target='_blank'>{$_v[sitename]}</a>";
							}
						}
					}
				}	
				return $list_str;
			}
		} 
	}
	function downfiles($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		$list_str = array();
		$file_list = string2array($value);
		if(is_array($file_list)) {
			foreach($file_list as $_k=>$_v) {	
				if($_v[fileurl]){
					$filename = $_v[filename] ? $_v[filename] : L('click_to_down');
					if($downloadlink) {
						$a_k = urlencode(sys_auth("i=$this->id&s=&m=1&f=$_v[fileurl]&d=$downloadtype&modelid=$this->modelid&catid=$this->catid", 'ENCODE', md5(PC_PATH.'down').pc_base::load_config('system','auth_key')));
						$list_str[] = "<a href='".APP_PATH."index.php?m=content&c=down&a_k={$a_k}' target='_blank'>{$filename}</a>";
					} else {
						$list_str[] = "<a href='{$_v[fileurl]}' target='_blank'>{$filename}</a>";
					}
				}
			}
		}
		return $list_str;		
	}
	function map($field, $value) {
		$str = '';
		$setting = string2array($this->fields[$field]['setting']);
		$setting[width] = $setting[width] ? $setting[width] : '600';
		$setting[height] = $setting[height] ? $setting[height] : '400';
		list($lngX, $latY,$zoom) = explode('|', $value);
		if($setting['maptype']==1) {
			$str = "<script src='http://app.mapabc.com/apis?&t=flashmap&v=2.4&key=$setting[api_key]&hl=zh-CN' type='text/javascript'></script>";
		} elseif($setting['maptype']==2) {
			$str = "<script type='text/javascript' src='http://api.map.baidu.com/api?v=1.2&key=$setting[api_key]'></script>";
		}
		$str .= '<div id="mapObj" class="view" style="width: '.$setting[width].'px; height:'.$setting[height].'px"></div>';
		$str .='<script type="text/javascript">';
		if($setting['maptype']==1) {
		$str .='
		var mapObj=null;
		lngX = "'.$lngX.'";
		latY = "'.$latY.'";
		zoom = "'.$zoom.'";
		var mapOptions = new MMapOptions();
		mapOptions.toolbar = MConstants.MINI;
		mapOptions.scale = new MPoint(20,20);  
		mapOptions.zoom = zoom;
		mapOptions.mapComButton = MConstants.SHOW_NO
		mapOptions.center = new MLngLat(lngX,latY);
		var mapObj = new MMap("mapObj", mapOptions);
		var  maptools = new MMapTools(mapObj);
		drawPoints();
		';
		$str .='
		function drawPoints(){
			var markerOption = new MMarkerOptions();
			var tipOption=new MTipOptions();//添加信息窗口 
			var address = "'.$address.'";
			tipOption.tipType = MConstants.HTML_BUBBLE_TIP;//信息窗口标题  
			tipOption.title = address;//信息窗口标题  
			tipOption.content = address;//信息窗口内容     
			var markerOption = new MMarkerOptions(); 		
			markerOption.imageUrl="'.IMG_PATH.'icon/mak.png";		
			markerOption.picAgent=false;   
			markerOption.imageAlign=MConstants.BOTTOM_CENTER; 	   
			markerOption.tipOption = tipOption; 		  
			markerOption.canShowTip= address ? true : false; 	  	
			markerOption.dimorphicColor="0x00A0FF"; 			 			
			Mmarker = new MMarker(new MLngLat(lngX,latY),markerOption);
			Mmarker.id="mark101";
			mapObj.addOverlay(Mmarker,true) 
		}';
		} elseif($setting['maptype']==2) {
			$str .='
			var mapObj=null;
			lngX = "'.$lngX.'";
			latY = "'.$latY.'";
			zoom = "'.$zoom.'";		
			var mapObj = new BMap.Map("mapObj");
			var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
			mapObj.addControl(ctrl_nav);
			mapObj.enableDragging();
			mapObj.enableScrollWheelZoom();
			mapObj.enableDoubleClickZoom();
			mapObj.enableKeyboard();//启用键盘上下左右键移动地图
			mapObj.centerAndZoom(new BMap.Point(lngX,latY),zoom);
			drawPoints();
			';
			$str .='
			function drawPoints(){
				var myIcon = new BMap.Icon("'.IMG_PATH.'icon/mak.png", new BMap.Size(27, 45));
				var center = mapObj.getCenter();
				var point = new BMap.Point(lngX,latY);
				var marker = new BMap.Marker(point, {icon: myIcon});
				mapObj.addOverlay(marker);
			}';	
		}
		$str .='</script>';
		return $str;
	}

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
 } 
?>