<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class wap_url{
	private $urlrules,$categorys,$html_root;
	public function __construct() {
		self::set_siteid();
	}
	/**
	* WAP内容页链接
	*/
	public function show($id, $page = 0, $catid = 0, $typeid = 0, $prefix = '',$data = '',$action = 'edit') {
		$page = max($page,1);
		$urls = '';
		$urlrules = 'c=index&a=show&catid={$catid}&typeid={$typeid}&id={$id}|c=index&a=show&catid={$catid}&typeid={$typeid}&id={$id}&page={$page}';
		$urlrules_arr = explode('|',$urlrules);
		if($page==1) {
			$urlrule = $urlrules_arr[0];
		} else {
			$urlrule = $urlrules_arr[1];
		}				
		$urls = str_replace(array('{$catid}','{$typeid}','{$id}','{$page}'),array($catid,$typeid,$id,$page),$urlrule);		
		$laststr = substr(trim(WAP_SITEURL), -1);
		if($laststr=='?'){
			$url_arr[0] = $url_arr[1] = WAP_SITEURL.$urls;
		}else{
			$url_arr[0] = $url_arr[1] = WAP_SITEURL.'&'.$urls;
		}	
		return $url_arr;
	}
	/**
	 * 设置站点id
	 */
	private function set_siteid() {
		if(defined('IN_ADMIN')) {
			$this->siteid = get_siteid();
		} else {
			param::get_cookie('siteid');
			$this->siteid = param::get_cookie('siteid');
		}
	}
}