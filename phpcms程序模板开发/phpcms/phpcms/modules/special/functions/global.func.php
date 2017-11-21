<?php 
/**
 * 生成css
 * @param array $param css参数
 */
function get_css($param = array()) {
	if (!isset($param) || empty($param)) return false;
	$css = '<style type="text/css">'."\n";
	if ($param['bg_path']) {
		$css .= ' body{ background: url(\''.$param['bg_path'].'\');';
		if ($param['repeat']) $css .= ' background-repeat: '.$param['repeat'].';';
		if ($param['background-attachment']) $css .= ' background-attachment: '.$param['background-attachment'].';';
		if ($param['background-position']) $css .= ' background-position: '.$param['background-position'].';';
		$css .= '}'."\n";
	}
	if ($param['background-color']) $css .= 'body {background-color: '.$param['background-color'].'}'."\n";
	if ($param['color']) $css .= 'body { color: '.$param['color'].'}'."\n";
	if ($param['link_color']) $css .= 'a {color: '.$param['link_color'].'}'."\n";
	$css .= '</style>';
	return $css;
}

/**
 * 内容页url
 * @param $contentid 文章ID
 * @param $page 当前页
 * @param $addtime 文章发布时间
 * @param $type 返回路径的格式（.html|.php）
 * @param $site_info 站点信息
 * @param $type 类型 静态地址 $type = 'html', 动态地址 $type='php'
 */
function content_url($contentid = 0, $page = 1, $addtime, $type = 'html', $site_info = '') {
	if (!$contentid) return '';
	$url = array();
	$page = max(intval($page), 1);
	$app_path = substr(APP_PATH, 0, -1);
	switch ($type) {
		case 'html':
			if ($site_info['dirname']) {
				if ($page==1) {
					$url[0] = $site_info['domain'].'special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'.html';
					$url[1] = pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'.html';
				} else {
					$url[0] = $site_info['domain'].'special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'-'.$page.'.html';
					$url[1] = pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'-'.$page.'.html';
				}
			} else {
				if ($page==1) {
					$url[0] = $url[1] = pc_base::load_config('system', 'html_root').'/special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'.html';
					$url[0] = $app_path.$url[0];
				} else {
					$url[0] = $url[1] = pc_base::load_config('system', 'html_root').'/special/'.date('Y', $addtime).'/'.date('md', $addtime).'/'.$contentid.'-'.$page.'.html';
					$url[0] = $app_path.$url[0];
				}
			}
			break;
		
		case 'php':
			if ($page==1) {
				$url[0] = APP_PATH.'index.php?m=special&c=index&a=show&id='.$contentid;
			} else {
				$url[0] = APP_PATH.'index.php?m=special&c=index&a=show&id='.$contentid.'&page='.$page;
			}
			break;
	}
	return $url;
}

function get_pic_content($pics) {
	if (!$pics) return '';
	$info = explode('|', $pics);
	$catid = intval($info[1]);
	$id = intval($info[0]);
	unset($info);
	$db = pc_base::load_model('content_model');
		
	if(!$catid || !$id) return false;
	$siteids = getcache('category_content','commons');
	$siteid = $siteids[$catid];
	$CATEGORYS = getcache('category_content_'.$siteid,'commons');

	if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) return false;
	$category = $CAT = $CATEGORYS[$catid];
	$category_setting = string2array($category['setting']);
	$siteid = $CAT['siteid'];
	$MODEL = getcache('model','commons');
	$modelid = $CAT['modelid'];

	$tablename = $db->table_name = $db->db_tablepre.$MODEL[$modelid]['tablename'];
	$r = $db->get_one(array('id'=>$id));
	if(!$r || $r['status'] != 99) return false;
		
	$db->table_name = $tablename.'_data';
	$r2 = $db->get_one(array('id'=>$id));
	$rs = array_merge($r,$r2);

	//再次重新赋值，以数据库为准
	$catid = $CATEGORYS[$r['catid']]['catid'];
	$modelid = $CATEGORYS[$catid]['modelid'];
		
	require_once CACHE_MODEL_PATH.'content_output.class.php';
	$content_output = new content_output($modelid,$catid,$CATEGORYS);
	$data = $content_output->get($rs);
	extract($data);
	if(empty($previous_page)) {
		$previous_page = array('title'=>L('first_page', '', 'content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page', '', 'content').'\');');
	}
	if(empty($next_page)) {
		$next_page = array('title'=>L('last_page', '', 'content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page', '', 'content').'\');');
	}
	ob_start();
	include template('special', 'api_picture');
	$data = ob_get_contents();
	ob_clean();
	return $data;
}
?>