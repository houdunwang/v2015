<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 视频删除接收接口 在vms系统中删除视频时，会调用此接口
 * 
 * @author				chenxuewang
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			CopyRight (c) 2006-2012 酷溜网（北京）科技有限公司
 * @license				http://www.phpcms.cn/license/
 * 
 * 
 * *************************************
 *              			           *
 *                 参数说明            *
 *                                     *
 * ************************************* 
 * 
 * vid，视频vid，视频的唯一的标示符。区分视频
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

$vid = $_POST['ku6vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}

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

$video_store_db->update(array('status'=>'-30'), array('vid'=>$vid));
echo json_encode(array('msg'=>'Delete video successful', 'code'=>200,'vid'=>$vid));
?>