	function images($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$list_str = '';
		if($value) {
			$value = string2array(new_html_entity_decode($value));
			if(is_array($value)) {
				foreach($value as $_k=>$_v) {
				$list_str .= "<div id='image_{$field}_{$_k}' style='padding:1px'><input type='text' name='{$field}_url[]' value='{$_v[url]}' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'> <input type='text' name='{$field}_alt[]' value='{$_v[alt]}' style='width:160px;' class='input-text'> <a href=\"javascript:remove_div('image_{$field}_{$_k}')\">".L('remove_out', '', 'content')."</a></div>";
				}
			}
		} else {
			$list_str .= "<center><div class='onShow' id='nameTip'>".L('upload_pic_max', '', 'content')." <font color='red'>{$upload_number}</font> ".L('tips_pics', '', 'content')."</div></center>";
		}
		$string = '<input name="info['.$field.']" type="hidden" value="1">
		<fieldset class="blue pad-10">
        <legend>'.L('pic_list').'</legend>';
		$string .= $list_str;
		$string .= '<div id="'.$field.'" class="picList"></div>
		</fieldset>
		<div class="bk10"></div>
		';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="statics/js/swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
		$string .= $str."<div class='picBut cu'><a href='javascript:void(0);' onclick=\"javascript:flashupload('{$field}_images', '".L('attachment_upload')."','{$field}',change_images,'{$upload_number},{$upload_allowext},{$isselectimage}','content','$this->catid','{$authkey}')\"/> ".L('select_pic')." </a></div>";
		return $string;
	}