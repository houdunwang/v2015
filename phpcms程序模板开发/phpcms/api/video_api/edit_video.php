<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 视频修改接收接口 在vms系统中修改视频时，会调用此接口更新这些视频
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
 * title, description, tag, vid, picpath, size, timelen, status, playnum
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
 * 
 * 
 * ************************************
 *              			          *
 *                 返 回 值           *
 *                                    *
 * ************************************ 
 * 
 * 接口执行后，应返回相应的值通知vms系统
 * 返回值格式 json数据，array('msg'=>'Edit Success', 'code'=>'100')
 */

//加载数据模型
$video_store_db = pc_base::load_model('video_store_model');
pc_base::load_app_func('global', 'video');

//验证信息
$data = array();

$vid = $_POST['vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}
if ($_POST['title'])		$data['title'] = safe_replace($_POST['title']);
if ($_POST['description'])  $data['description'] = safe_replace($_POST['description']);
if ($_POST['keywords'])		$data['keywords'] = safe_replace($_POST['tag']);
if ($_POST['picpath'])		$data['picpath'] = safe_replace(format_url($_POST['picpath']));
if ($_POST['size'])			$data['size'] = $_POST['size'];
if ($_POST['timelen'])		$data['timelen'] = intval($_POST['timelen']);
if ($_POST['ku6status'])	$data['status'] = intval($_POST['ku6status']);
if ($_POST['playnum'])		$data['playnum'] = intval($_POST['playnum']);

if ($data['status']<0 || $data['status']==24) {
	$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
	$videoid = $r['videoid'];
	//$video_store_db->delete(array('vid'=>$vid)); //删除此视频
	/**
	 * 加载视频内容对应关系数据模型，检索与删除视频相关的内容。
	 * 在对应关系表中解除关系，并更新内容的静态页
	 */
	$video_content_db = pc_base::load_model('video_content_model');
	$result = $video_content_db->select(array('videoid'=>$videoid));
	if (is_array($result) && !empty($result)) {
		//加载更新html类
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			/**
			 * 判断如果内容页生成了静态页，则更新静态页
			 */
			if (ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($rs, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
			} else {
				continue;
			}
		}
	}
} elseif ($data['status']==21) {
	$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
	$videoid = $r['videoid'];
	/**
	 * 加载视频内容对应关系数据模型，检索与删除视频相关的内容。
	 * 在对应关系表中找出对应的内容id，并更新内容的静态页
	 */
	$video_content_db = pc_base::load_model('video_content_model');
	$result = $video_content_db->select(array('videoid'=>$videoid));
	if (is_array($result) && !empty($result)) {
		//加载更新html类
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$content_check_db = pc_base::load_model('content_check_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$content_db->set_model($modelid);
			$c_info = $content_db->get_one(array('id'=>$contentid), 'thumb');

			$where = array('status'=>99);
			if (!$c_info['thumb']) $where['thumb'] = $data['picpath'];
			$content_db->update($where, array('id'=>$contentid));
			$checkid = 'c-'.$contentid.'-'.$modelid;
			$content_check_db->delete(array('checkid'=>$checkid));
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			/**
			 * 判断如果内容页生成了静态页，则更新静态页
			 */
			if (ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($r1, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
				
			} else {
				continue;
			}
		}
	}
}
//修改视频库中的视频
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$video_store_db->update($data, array('vid'=>$vid));
echo json_encode(array('msg'=>'Edit successful', 'code'=>200,'vid'=>$vid));
?>