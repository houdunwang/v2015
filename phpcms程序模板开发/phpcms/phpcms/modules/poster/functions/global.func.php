<?php
/**
 * 广告模板配置函数
 */
function get_types() {
	$poster_template = getcache('poster_template_'.get_siteid(), 'commons');
	$TYPES = array();
	if (is_array($poster_template) && !empty($poster_template)){
		foreach ($poster_template as $k => $template) {
			$TYPES[$k] = $template['name'];
		}
	} else {
		$TYPES = array('banner'=>L('banner', '', 'poster'), 'fixure'=>L('fixure'), 'float'=>L('float'), 'couplet'=>L('couplet'), 'imagechange'=>L('imagechange'),  'imagelist'=>L('imagelist'), 'text'=>L('text'), 'code'=>L('code'),);
	}
	return $TYPES;
}
?>