<?php
/**
 * 解析评论ID
 * @param $commentid 评论ID
 */
function decode_commentid($commentid) {
	return explode('-', $commentid);
}

/**
 * 方向生成
 * @param $direction
 */
function direction($direction) {
	switch($direction){
		case 1:
			return '<img src="'.IMG_PATH.'/icon/zheng.png" />';
		break;
		case 2:
			return '<img src="'.IMG_PATH.'/icon/fan.png" />';
		break;
		case 3:
			return '<img src="'.IMG_PATH.'/icon/zhong.png" />';
		break;
	}
}
 
/**
 * 通过API接口调用标题和URL数据
 * @param string $commentid    评论ID
 * @return array($title, $url)   返回数据
 */
function get_comment_api($commentid) {
	list($modules, $contentid, $siteid) = id_decode($commentid);
	if (empty($modules) || empty($siteid) || empty($contentid)) {
		return false;
	}
	$comment_api = '';
	$module = explode('_', $modules);
	$comment_api = pc_base::load_app_class('comment_api', $module[0]);
	if (empty($comment_api)) return false;
	return $comment_api->get_info($modules, $contentid, $siteid);
}