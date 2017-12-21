<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 视频添加接收接口 在vms系统中添加视频、导入ku6视频时，会调用此接口同步这些视频
 * 
 * @author				chenxuewang
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			CopyRight (c) 2006-2012 酷溜网（北京）科技有限公司
 * @license			http://www.phpcms.cn/license/
 * 
 * 
 * *************************************
 *              			           *
 *                 参数说明            *
 *                                     *
 * ************************************* 
 * 
 * title, description, tag, vid, picpath, size, timelen, status, playnum, specialid
 * 
 * title, 视频标题
 * 
 * descrption 视频简介
 * 
 * tag 视频标签
 * 
 * vid，视频vid，视频的唯一的标示符。区分视频
 * 
 * picpath 视频缩略图
 * 
 * size 视频大小
 * 
 * timelen 视频播放时长
 * 
 * status 视频目前的状态
 * 
 * playnum 视频播放次数
 * 
 * specialid 视频导入的专题id
 * 
 * 
 * 
 * ************************************
 *              			          *
 *                 返 回 值           *
 *                                    *
 * ************************************ 
 * 
 * 接口执行后，应返回相应的值通知vms系统
 * 返回值格式 json数据，array('msg'=>'Add Success', 'code'=>'100')
 */

//加载数据模型

$video_store_db = pc_base::load_model('video_store_model');
$special_db = pc_base::load_model('special_model');
$special_content_db = pc_base::load_model('special_content_model');
$content_data_db = pc_base::load_model('special_c_data_model');
$type_db = pc_base::load_model('type_model');

pc_base::load_app_func('global', 'video');

//验证信息
$data = $video_data = array();

$data['specialid'] = intval($_POST['specialid']);
if (!$data['specialid']) {
	echo json_encode(array('msg'=>'Specialid do not empty', 'code'=>'1'));
	exit;
} 
if (!$special_info = $special_db->get_one(array('id'=>$data['specialid']))) {
	echo json_encode(array('msg'=>'The system does not exist this special', 'code'=>2));
	exit;
}
$data['title'] = $video_data['title'] = safe_replace($_POST['title']);
if (!$data['title']) {
	echo json_encode(array('msg'=>'Video\'s title not empty', 'code'=>3));
	exit;
}
$content = $_POST['desc'] ? addslashes($_POST['desc']) : '';
$data['description'] = $video_data['description'] = substr($content, 0, 255);
$data['keywords'] = $video_data['keywords'] = $_POST['tag'] ? addslashes($_POST['tag']) : '';
$vid = $video_data['vid'] = $_POST['vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}
//先将视频加入到视频库中，并取得videoid
//判断vid是否已经存在视频库中
if (!$video_store = $video_store_db->get_one(array('vid'=>$vid))) {
	$video_data['status'] = $_POST['status'] ? intval($_POST['status']) : 21;
	$video_data['picpath'] = safe_replace( format_url($_POST['picPath']) );
	$video_data['addtime'] = intval(substr($_POST['uploadTime'], 0, 10));
	$video_data['timelen'] = intval($_POST['videoTime']);
	$video_data['size'] = intval($_POST['videoSize']);
	if (strtolower(CHARSET)!='utf-8') {
		$video_data = array_iconv($video_data, 'utf-8', 'gbk');
	}
	$videoid = $video_store_db->insert($video_data, true);
} else {
	$videoid = $video_store['vid'];
}
//构建special_content表数据字段
$res = $type_db->get_one(array('parentid'=>$data['specialid'], 'module'=>'special'), 'typeid', 'listorder ASC');
$data['typeid'] = $res['typeid'];
$data['thumb'] = $video_data['picpath'];
$data['videoid'] = $videoid;
//组合POST数据
$data['inputtime'] = SYS_TIME;
$data['updatetime'] = SYS_TIME;
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$contentid = $special_content_db->insert($data, true);
// 向数据统计表添加数据
$count = pc_base::load_model('hits_model');
$hitsid = 'special-c-'.$data['specialid'].'-'.$contentid;
$count->insert(array('hitsid'=>$hitsid, 'views'=>intval($_POST['playnum'])));
//将内容加到data表中
$content = iconv('utf-8', 'gbk', $content);
$content_data_db->insert(array('id'=>$contentid, 'content'=>$content));
//更新search表
$search_db = pc_base::load_model('search_model');
$siteid = $special_info['siteid'];
$type_arr = getcache('type_module_'.$siteid,'search');
$typeid = $type_arr['special'];
$searchid = $search_db->update_search($typeid ,$contentid,'',$data['title'], $data['inputtime']);
//获取专题的url
$html = pc_base::load_app_class('html', 'special');
$urls= $html->_create_content($contentid);
$special_content_db->update(array('url'=>$urls[0], 'searchid'=>$searchid), array('id'=>$contentid));
if ($_POST['end_status']) {
	$html->_index($data['specialid'], 20, 5);
}
echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
exit;