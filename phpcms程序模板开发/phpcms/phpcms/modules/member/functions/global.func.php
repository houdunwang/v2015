<?php 

/**
 * 获取视频模型的栏目
 **/
function video_categorys() {
	$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
	$sitemodel_field = pc_base::load_model('sitemodel_field_model'); //加载模型字段数据库类
	$result = $sitemodel_field->select(array('formtype'=>'video', 'siteid'=>$siteid), 'modelid'); //搜索站点下的视频模型
	if (is_array($result)) {
		$models = '';
		foreach ($result as $r) {
			$models .= $r['modelid'].',';
		}
	}
	$models = substr(trim($models), 0, -1);
	$cat_db = pc_base::load_model('category_model'); //加载栏目数据库类
	$where = '`modelid` IN ('.$models.') AND `type`=0 AND `siteid`=\''.$siteid.'\'';
	$result = $cat_db->select($where, '`catid`, `catname`, `parentid`, `siteid`, `child`', '', '`listorder` ASC, `catid` ASC', '', 'catid');
	return $result;
}

/**
 * 获取模型下的视频字段名称
 * @param int $catid 栏目id
 */
function get_video_field($catid = 0) {
	static $categorys;
	if (!$catid) return false;
	$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : 1;
	if (!$categorys) {
		$categorys = getcache('category_content_'.$siteid, 'commons');
	}
	$modelid = $categorys[$catid]['modelid'];
	$model_field = pc_base::load_model('sitemodel_field_model');
	$r = $model_field->get_one(array('modelid'=>$modelid, 'formtype'=>'video'));
	return $r['field'] ? $r['field'] : '';
}
?>