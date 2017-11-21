<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		pc_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}
	
	public function init() {
		$siteid = SITEID;
 		$setting = getcache('link', 'commons');
		$SEO = seo(SITEID, '', L('link'), '', '');
		include template('link', 'index');
	}
	
	 /**
	 *	友情链接列表页
	 */
	public function list_type() {
		$siteid = SITEID;
  		$type_id = trim(urldecode($_GET['type_id']));
		$type_id = intval($type_id);
  		if($type_id==""){
 			$type_id ='0';
 		}
   		$setting = getcache('link', 'commons');
		$SEO = seo(SITEID, '', L('link'), '', '');
  		include template('link', 'list_type');
	} 
 	
	 /**
	 *	申请友情链接 
	 */
	public function register() { 
 		$siteid = SITEID;
 		if(isset($_POST['dosubmit'])){
 			if($_POST['name']==""){
 				showmessage(L('sitename_noempty'),"?m=link&c=index&a=register&siteid=$siteid");
 			}
 			if($_POST['url']=="" || !preg_match('/^http:\/\/(.*)/i', $_POST['url'])){
 				showmessage(L('siteurl_not_empty'),"?m=link&c=index&a=register&siteid=$siteid");
 			}
 			if(!in_array($_POST['linktype'],array('0','1'))){
 				$_POST['linktype'] = '0';
 			}
 			$link_db = pc_base::load_model(link_model);
 			$_POST['logo'] =new_html_special_chars($_POST['logo']);

			$logo = safe_replace(strip_tags($_POST['logo']));
			if(!preg_match('/^http:\/\/(.*)/i', $logo)){
				$logo = '';
			}
			$name = safe_replace(strip_tags($_POST['name']));
			$url = safe_replace(strip_tags($_POST['url']));
			$url = trim_script($url);
 			if($_POST['linktype']=='0'){
 				$sql = array('siteid'=>$siteid,'typeid'=>intval($_POST['typeid']),'linktype'=>intval($_POST['linktype']),'name'=>$name,'url'=>$url);
 			}else{
 				$sql = array('siteid'=>$siteid,'typeid'=>intval($_POST['typeid']),'linktype'=>intval($_POST['linktype']),'name'=>$name,'url'=>$url,'logo'=>$logo);
 			}
 			$link_db->insert($sql);
 			showmessage(L('add_success'), "?m=link&c=index&siteid=$siteid");
 		} else {
  			$setting = getcache('link', 'commons');
			$setting = $setting[$siteid];
 			if($setting['is_post']=='0'){
 				showmessage(L('suspend_application'), HTTP_REFERER);
 			}
 			$this->type = pc_base::load_model('type_model');
 			$types = $this->type->get_types($siteid);//获取站点下所有友情链接分类
 			pc_base::load_sys_class('form', '', 0);
  			$SEO = seo(SITEID, '', L('application_links'), '', '');
   			include template('link', 'register');
 		}
	} 
	
}
?>