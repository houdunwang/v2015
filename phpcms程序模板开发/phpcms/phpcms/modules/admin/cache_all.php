<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class cache_all extends admin {
	private $cache_api;
	
	public function init() {
		if (isset($_POST['dosubmit']) || isset($_GET['dosubmit'])) {
			$page = $_GET['page'] ? intval($_GET['page']) : 0;
			$modules = array(
				array('name' => L('module'), 'function' => 'module'),
				array('name' => L('sites'), 'mod' => 'admin', 'file' => 'sites', 'function' => 'set_cache'),
				array('name' => L('category'), 'function' => 'category'),
				array('name' => L('downservers'), 'function' => 'downservers'),
				array('name' => L('badword_name'), 'function' => 'badword'),
				array('name' => L('ipbanned'), 'function' => 'ipbanned'),
				array('name' => L('keylink'), 'function' => 'keylink'),
				array('name' => L('linkage'), 'function' => 'linkage'),
				array('name' => L('position'), 'function' => 'position'),
				array('name' => L('admin_role'), 'function' => 'admin_role'),
				array('name' => L('urlrule'), 'function' => 'urlrule'),
				array('name' => L('sitemodel'), 'function' => 'sitemodel'),
				array('name' => L('type'), 'function' => 'type', 'param' => 'content'),
				array('name' => L('workflow'), 'function' => 'workflow'),
				array('name' => L('dbsource'), 'function' => 'dbsource'),
				array('name' => L('member_setting'), 'function' => 'member_setting'),
				array('name' => L('member_group'), 'function' => 'member_group'),
				array('name' => L('membermodel'), 'function' => 'membermodel'),
				array('name' => L('member_model_field'), 'function' => 'member_model_field'),
				array('name' => L('search_type'), 'function' => 'type', 'param' => 'search'),
				array('name' => L('search_setting'), 'function' => 'search_setting'),
				array('name' => L('update_vote_setting'), 'function' => 'vote_setting'),
				array('name' => L('update_link_setting'), 'function' => 'link_setting'),
				array('name' => L('special'), 'function' => 'special'),
				array('name' => L('setting'), 'function' => 'setting'),
				array('name' => L('database'), 'function' => 'database'),
				array('name' => L('update_formguide_model'), 'mod' => 'formguide', 'file' => 'formguide', 'function' => 'public_cache'),
				array('name' => L('cache_file'), 'function' => 'cache2database'),
				array('name' => L('cache_copyfrom'), 'function' => 'copyfrom'),
				array('name' => L('clear_files'), 'function' => 'del_file'),
				array('name' => L('video_category_tb'), 'function' => 'video_category_tb'),
			);
			$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
			$m = $modules[$page];
			if ($m['mod'] && $m['function']) {
				if ($m['file'] == '') $m['file'] = $m['function'];
				$M = getcache('modules', 'commons');
				if (in_array($m['mod'], array_keys($M))) {
					$cache = pc_base::load_app_class($m['file'], $m['mod']);
					$cache->{$m['function']}();
				}
			} else if($m['target']=='iframe') {
				echo '<script type="text/javascript">window.parent.frames["hidden"].location="index.php?'.$m['link'].'";</script>';
			} else {
				$this->cache_api->cache($m['function'], $m['param']);
			}
			$page++;
			if (!empty($modules[$page])) {
				echo '<script type="text/javascript">window.parent.addtext("<li>'.L('update').$m['name'].L('cache_file_success').'..........</li>");</script>';
				showmessage(L('update').$m['name'].L('cache_file_success'), '?m=admin&c=cache_all&page='.$page.'&dosubmit=1&pc_hash='.$_SESSION['pc_hash'], 0);
			} else {
				echo '<script type="text/javascript">window.parent.addtext("<li>'.L('update').$m['name'].L('site_cache_success').'..........</li>")</script>';
				showmessage(L('update').$m['name'].L('site_cache_success'), 'blank');
			}
		} else {
			include $this->admin_tpl('cache_all');
		}
	}
}
?>