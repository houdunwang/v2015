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
