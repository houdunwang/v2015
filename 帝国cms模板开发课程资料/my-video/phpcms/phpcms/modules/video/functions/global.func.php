<?php

/**
 * 
 * 格式化url
 */
function format_url($path) {
	if (!$path) return IMG_PATH.'nopic.jpg';
	if (strpos($path, 'http://')===FALSE && strpos($path, 'https://')===FALSE) {
		return 'http://'.$path;
	} else {
		return $path;
	}
}

/**
 * Function ISHTML
 * 判断内容是否需要生成静态
 * @param int $catid 栏目id
 */
function ishtml($catid = 0) {
	static $ishtml, $catid_siteid;
	if (!isset($ishtml[$catid])) {
		if (!$catid_siteid) {
			$catid_siteid = getcache('category_content', 'commons');
		} else {
			$siteid = $catid_siteid[$catid];
		}
		$siteid = $catid_siteid[$catid];
		$categorys = getcache('category_content_'.$siteid, 'commons');
		$ishtml[$catid] = $categorys[$catid]['content_ishtml'];
	}
	return $ishtml[$catid];
}