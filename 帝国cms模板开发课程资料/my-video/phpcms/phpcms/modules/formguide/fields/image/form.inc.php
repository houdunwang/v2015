	function image($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script><script language="javascript" type="text/javascript" src="'.JS_PATH.'content_addtop.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height");
		if($show_type) {
			$preview_img = $value ? $value : IMG_PATH.'icon/upload-pic.png';
			return $str."<div class='upload-pic img-wrap'><input type='hidden' name='info[$field]' id='$field' value='$value'>
			<a href='javascript:;' onclick=\"javascript:flashupload('{$field}_images', '".L('attachment_upload')."','{$field}',thumb_images,'1,$upload_allowext,$isselectimage,$images_width,$images_height','member','','{$authkey}')\">
			<img src='$preview_img' id='{$field}_preview' width='135' height='113' style='cursor:hand' /></a></div>";
		} else {
			return $str."<input type='text' name='info[$field]' id='$field' value='$value' size='$size' $this->no_allowed class='input-text' />  <input type='button' class='button' $this->no_allowed onclick=\"javascript:flashupload('{$field}_images', '".L('attachment_upload')."','{$field}',submit_images,'1,{$upload_allowext},$isselectimage,$images_width,$images_height','member','','{$authkey}')\"/ value='".L('image_upload')."'>";
		}
	}
