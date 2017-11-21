<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'video', 'parentid'=>'0', 'm'=>'video', 'c'=>'video', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$parentid = $menu_db->insert(array('name'=>'video', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'video_manage', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_upload', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_edit', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'video_delete', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$o_mid = $menu_db->insert(array('name'=>'video_open', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'open', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'video_inputinfo', 'parentid'=>$o_mid, 'm'=>'video', 'c'=>'video', 'a'=>'open', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'complete_info', 'parentid'=>$o_mid, 'm'=>'video', 'c'=>'video', 'a'=>'complete_info', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'subscribe_manage', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'subscribe_list', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'sub_delete', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'sub_del', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'import_ku6_video', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'import_ku6video', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_store', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'video2content', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'player_manage', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'player', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_stat', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'stat', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

if (module_exists('special')) {
	$special_db = pc_base::load_model('special_model');
	if( !$special_db->field_exists('aid') ){
		$menu_db->insert(array('name'=>'album_import', 'parentid'=>868, 'm'=>'special', 'c'=>'album', 'a'=>'import', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
		$special_db->query("ALTER TABLE  `phpcms_special` ADD  `aid` INT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `siteid`");
	}
	if (!$special_db->field_exists('isvideo')) {
		$special_db->query("ALTER TABLE `phpcms_special` ADD `isvideo` TINYINT( 1 ) UNSIGNED NOT NULL");
	}
	$special_content_db = pc_base::load_model('special_content_model');
	if (!$special_content_db->field_exists('videoid')) {
		$special_content_db->query("ALTER TABLE `phpcms_special_content` ADD `videoid` INT UNSIGNED NOT NULL DEFAULT  '0'");
	}
}

//替换category_video模版推荐位值
$position_db = pc_base::load_model('position_model');
$position_1 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页焦点图推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_2 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页头条推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_3 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页每日热点推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_4 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频栏目精彩推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);

$tpl_file = PC_PATH.'templates'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'category_video.html';
if(!file_exists($tpl_file)){
	showmessage($tpl_file.' template does not exist.');
}
if(!is_writable($tpl_file)) {
	showmessage($tpl_file.' template does not writable.');
}
$content = file_get_contents($tpl_file);

$content = str_replace('*position1*',$position_1,$content);
$content = str_replace('*position2*',$position_2,$content);
$content = str_replace('*position3*',$position_3,$content);
$content = str_replace('*position4*',$position_4,$content);

file_put_contents($tpl_file,$content);

$language = array('video'=>'视频', 'video_manage'=>'视频库管理', 'video_upload'=>'视频上传','video_edit'=>'修改视频', 'video_delete'=>'删除视频', 'video_open'=>'申请开通', 'video_inputinfo'=>'视频配置', 'complete_info'=>'填写资料', 'subscribe_manage'=>'订阅管理', 'sub_delete'=>'删除订阅', 'import_ku6_video'=>'导入ku6视频', 'album_import'=>'视频专辑导入', 'video_store'=>'视频库', 'video_stat'=>'视频统计', 'player_manage'=>'播放器管理');
?>