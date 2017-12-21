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
