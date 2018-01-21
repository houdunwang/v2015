<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 外部数据源缓存
 */
function dbsource_cache() {
	$db = pc_base::load_model('dbsource_model');
	$list = $db->select();
	$data = array();
	if ($list) {
		foreach ($list as $val) {
			$data[$val['name']] = array('hostname'=>$val['host'].':'.$val['port'], 'database' =>$val['dbname'] , 'db_tablepre'=>$val['dbtablepre'], 'username' =>$val['username'],'password' => $val['password'],'charset'=>$val['charset'],'debug'=>0,'pconnect'=>0,'autoconnect'=>0);
		}
	} else {
		return false;
	}
	return setcache('dbsource', $data, 'commons');
}

/**
 * 获取模型PC标签配置相信
 * @param $module 模型名
 */
function pc_tag_class ($module) {
	$filepath = PC_PATH.'modules'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$module.'_tag.class.php';
	if (file_exists($filepath)) {
		$pc_tag = pc_base::load_app_class($module.'_tag', $module); 
		if (!method_exists($pc_tag, 'pc_tag')) {
			showmessage(L('the_module_will_not_support_the_operation'));
		}
		$html  = $pc_tag->pc_tag();
	} else {
		showmessage(L('the_module_will_not_support_the_operation'), HTTP_REFERER);
	}
	return $html;
}

/**
 * 返回模板地址。
 * @param $id 数据源调用ID
 */
function template_url($id) {
	$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.'dbsource'.DIRECTORY_SEPARATOR.$id.'.php';
	if (!file_exists($filepath)) {
		$datacall = pc_base::load_model('datacall_model');
		$str = $datacall->get_one(array('id'=>$id), 'template');
		$dir = dirname($filepath);
		if(!is_dir($dir)) {
			mkdir($dir, 0777, true);
	    }
	    $tpl = pc_base::load_sys_class('template_cache');
		$str = $tpl->template_parse($str['template']);
		@file_put_contents($filepath, $str);
	}
	return $filepath;
}
?>