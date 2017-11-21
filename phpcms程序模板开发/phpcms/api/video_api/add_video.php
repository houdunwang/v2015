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
 * title, description, tag, vid, picpath, size, timelen, status, playnum, catid, posid
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
 * catid 导入到本系统栏目ID 导入过来的视频，首先发布为内容，同时将视频放入视频库中供以后使用
 * 
 * posid 本系统推荐位ID 可以为空，不为空时，需要将视频添加到推荐位表中
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
$content = pc_base::load_model('content_model');
$cat_db = pc_base::load_model('category_model');
$model_field = pc_base::load_model('sitemodel_field_model');
$video_setting = getcache('video', 'video');
//加载v.class
pc_base::load_app_func('global', 'video');
pc_base::load_app_class('v', 'video', 0);
$v = new v($db);

//验证信息
$data = $video_data = array();
$data['catid'] = intval($_POST['catid']);
if (!$data['catid']) {
	$data['catid'] = $video_setting['catid'];
} 
$cat_info = $cat_db->get_one(array('catid'=>$data['catid']));

$data['title'] = $video_data['title'] = $_POST['title'];
if (!$data['title']) {
	echo json_encode(array('msg'=>'The parameter title must have a value', 'code'=>3));
	exit;
}
if (!$_POST['picpath'] || strripos($_POST['picpath'],'.jpg')===false) {
	echo json_encode(array('msg'=>'The parameter picpath must have a value', 'code'=>5));
	exit;
}
$data['content'] = $_POST['description'] ? addslashes($_POST['description']) : '';
$data['description'] = $video_data['description'] = substr($data['content'], 0, 255);
$data['keywords'] = $video_data['keywords'] = $_POST['tag'] ? $_POST['tag'] : '';
$video_data['timelen'] = intval($_POST['timelen']);
$video_data['size'] = intval($_POST['size']);
$video_data['vid'] = $_POST['vid'];
if (!$video_data['vid']) {
	echo json_encode(array('msg'=>'The parameter vid must have a value', 'code'=>4));
	exit;
}

//先将视频加入到视频库中，并取得videoid
//判断vid是否已经存在视频库中
if (!$video_store = $video_store_db->get_one(array('vid'=>$video_data['vid']))) {
	$video_data['status'] = $_POST['ku6status'] ? intval($_POST['ku6status']) : 1;
	$video_data['picpath'] = safe_replace( format_url($_POST['picpath']) );
	$video_data['addtime'] = $_POST['createtime'] ? $_POST['createtime'] : SYS_TIME;
	$video_data['channelid'] = 1;
	if (strtolower(CHARSET)!='utf-8') {
		$video_data = array_iconv($video_data, 'utf-8', 'gbk');
	}
	$videoid = $video_store_db->insert($video_data, true);
} else {
	$videoid = $video_store['videoid'];
}
if (!$cat_info) {
	echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
	exit;
}
//根据栏目信息取得站点id及模型id
$siteid = $cat_info['siteid'];
$modelid = $cat_info['modelid'];
//根据模型id，得到视频字段名
$r = $model_field->get_one(array('modelid'=>$modelid, 'formtype'=>'video'), 'field');
$fieldname = $r['field'];
if ($_POST['posid']) {
	$data['posids'][] = $_POST['posid'];
}
$data['thumb'] = safe_replace( format_url($_POST['picpath']) );
$data[$fieldname] = 1;
//组合POST数据
$_POST[$fieldname.'_video'][1] = array('videoid'=>$videoid, 'listorder'=>1);
$data['status'] = ($video_data['status'] == 21 || $_POST['status']==1) ? 99 : 1;
//调用内容模型
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$content->set_model($modelid); 
$cid = $content->add_content($data);
//更新对应关系
//$content_video_db = pc_base::load_model('video_content_model');
//$content_video_db->insert(array('contentid'=>$cid, 'videoid'=>$videoid, 'modelid'=>$modelid, 'listorder'=>1));
//更新点击次数 
if ($_POST['playnum']) {
	$views = intval($_POST['playnum']);
	$hitsid = 'c-'.$modelid.'-'.$cid;
	$count = pc_base::load_model('hits_model');
	$count->update(array('views'=>$views), array('hitsid'=>$hitsid));
}

echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
exit;
?>