<?php
defined('IN_PHPCMS') or exit('No permission resources.');
function spider_keywords($data) {
	$http = pc_base::load_sys_class('http');
	if(CHARSET == 'utf-8') {
		$data = iconv('utf-8', 'gbk', $data);
	}
	$http->post('http://tool.phpcms.cn/api/get_keywords.php', array('siteurl'=>APP_PATH, 'charset'=>CHARSET, 'data'=>$data, 'number'=>3));
	if($http->is_ok()) {
		if(CHARSET != 'utf-8') {
			return $http->get_data();
		} else {
			return iconv('gbk', 'utf-8', $http->get_data());
		}
	} else {
		return $data;
	}
}