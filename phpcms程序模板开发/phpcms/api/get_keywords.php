<?php
/**
 * 获取关键字接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

define('API_URL_GET_KEYWORDS', 'http://tool.phpcms.cn/api/get_keywords.php');

$number = intval($_GET['number']);
$data = $_POST['data'];
echo get_keywords($data, $number);

function get_keywords($data, $number = 3) {
	$data = trim(strip_tags($data));
    if(empty($data)) return '';
	$http = pc_base::load_sys_class('http');
	if(CHARSET != 'utf-8') {
		$data = iconv('utf-8', CHARSET, $data);
	} else {
		$data = iconv('utf-8', 'gbk', $data);
	}
	$http->post(API_URL_GET_KEYWORDS, array('siteurl'=>SITE_URL, 'charset'=>CHARSET, 'data'=>$data, 'number'=>$number));
	if($http->is_ok()) {
		if(CHARSET != 'utf-8') {
			return $http->get_data();
		} else {
			return iconv('gbk', 'utf-8', $http->get_data());
		}
	}
	return '';
}
?>