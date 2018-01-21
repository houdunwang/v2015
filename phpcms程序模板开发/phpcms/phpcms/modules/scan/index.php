<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class index extends admin {
	
	protected $safe = array ('file_type' => 'php|js','code' => '','func' => 'com|system|exec|eval|escapeshell|cmd|passthru|base64_decode|gzuncompress','dir' => '', 'md5_file'=>'');
	
	public function __construct() {
		parent::__construct();
	}
	
	public function init() {
		$list = glob(PHPCMS_PATH.'*');
		if (file_exists(CACHE_PATH.'caches_scan'.DIRECTORY_SEPARATOR.'caches_data')) {
			$md5_file_list = glob(CACHE_PATH.'caches_scan'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR.'md5_*.php');
			if(is_array($md5_file_list)) {
				foreach ($md5_file_list as $k=>$v) {
					$md5_file_list[$v] = basename($v);
					unset($md5_file_list[$k]);
				}
			}
		}
		$scan = getcache('scan_config', 'scan');
		if (is_array($scan)) {
			$scan = array_merge($this->safe, $scan);
		} else {
			$scan = $this->safe;
		}
		$scan['dir'] = string2array($scan['dir']);
		pc_base::load_sys_class('form', '', 0);
		include $this->admin_tpl('scan_index');
	}
	
	//进行配置文件更新
	public function public_update_config() {
		$info = isset($_POST['info']) ? $_POST['info'] : showmessage(L('illegal_action'), HTTP_REFERER);
		$dir = isset($_POST['dir']) ? new_stripslashes($_POST['dir']) : '';
		if (empty($dir)) { 
			showmessage(L('please_select_the_content'), '?m=scan&c=index&a=init');
		}
		$info['dir'] = var_export($dir, true);
		setcache('scan_config', $info, 'scan');
		showmessage(L('configuration_file_save_to_the'), '?m=scan&c=index&a=public_file_count');
	}
	
	//对要进行扫描的文件进行统计
	public function public_file_count() {
		$scan = getcache('scan_config', 'scan');
		pc_base::load_app_func('global');
		set_time_limit(120);
		$scan['dir'] = string2array($scan['dir']);
		$scan['file_type'] = explode('|', $scan['file_type']);
		$list = array();
		foreach ($scan['dir'] as $v) {
			if (is_dir($v)) {
				foreach ($scan['file_type'] as $k ) {
					$list = array_merge($list, scan_file_lists($v.DIRECTORY_SEPARATOR, 1, $k, 0, 1, 1));
				}
			} else {
				$list = array_merge($list, array(str_replace(PHPCMS_PATH, '', $v)=>md5_file($v)));
			}
		}
		setcache('scan_list', $list, 'scan');
		showmessage(L('documents_to_file_the_statistics'), '?m=scan&c=index&a=public_file_filter');
	}
	
	//对文件进行筛选
	public function public_file_filter() {
		$scan_list = getcache('scan_list', 'scan');
		$scan = getcache('scan_config', 'scan');
		if (file_exists($scan['md5_file'])) {
			$old_md5 = include $scan['md5_file'];
			foreach ($scan_list as $k=>$v) {
				if ($v == $old_md5[$k]) {
					unset($scan_list[$k]);
				}
			}
		}
		setcache('scan_list', $scan_list, 'scan');
		showmessage(L('file_through_a_feature_the_function_is'), '?m=scan&c=index&a=public_file_func');
	}
	
	//进行特征函数过滤
	public function public_file_func() {
		@set_time_limit(600);
		$file_list = getcache('scan_list', 'scan');
		$scan = getcache('scan_config', 'scan');
		if (isset($scan['func']) && !empty($scan['func'])) {
			foreach ($file_list as $key=>$val) {
				$html = file_get_contents(PHPCMS_PATH.$key);
				if(stristr($key,'.php.') != false || preg_match_all('/[^a-z]?('.$scan['func'].')\s*\(/i', $html, $state, PREG_SET_ORDER)) {
					$badfiles[$key]['func'] = $state;
	            }
			}
		}
		if(!isset($badfiles)) $badfiles = array();
		setcache('scan_bad_file', $badfiles, 'scan');
		showmessage(L('feature_function_complete_a_code_used_by_filtration'), '?m=scan&c=index&a=public_file_code');
	}
	
	//进行特征代码过滤
	public function public_file_code() {
		@set_time_limit(600);
		$file_list = getcache('scan_list', 'scan');
		$scan = getcache('scan_config', 'scan');
		$badfiles = getcache('scan_bad_file', 'scan');
		if (isset($scan['code']) && !empty($scan['code'])) {
			foreach ($file_list as $key=>$val) {
				$html = file_get_contents(PHPCMS_PATH.$key);
				if(stristr($key, '.php.') != false || preg_match_all('/[^a-z]?('.$scan['code'].')/i', $html, $state, PREG_SET_ORDER)) {
					$badfiles[$key]['code'] = $state;
	            }
	            if(strtolower(substr($key, -4)) == '.php' && function_exists('zend_loader_file_encoded') && zend_loader_file_encoded(PHPCMS_PATH.$key)) {
	            	$badfiles[$key]['zend'] = 'zend encoded';
	            }
			}
		}
		setcache('scan_bad_file', $badfiles, 'scan');
		showmessage(L('scan_completed'), '?m=scan&c=index&a=scan_report&menuid=1005');
	}
	
	public function scan_report() {
		$badfiles = getcache('scan_bad_file', 'scan');
		if (empty($badfiles)) {
			showmessage(L('scan_to_find_a_result_please_to_scan'), '?m=scan&c=index&a=init');
		}
		include $this->admin_tpl('scan_report');
	}
	
	public function view() {
		$url = isset($_GET['url']) && trim($_GET['url']) ? new_stripslashes(urldecode(trim($_GET['url']))) : showmessage(L('illegal_action'), HTTP_REFERER);
		$url = str_replace("..","",$url);
		
		if (!file_exists(PHPCMS_PATH.$url)) {
			showmessage(L('file_not_exists'));
		}
		$html = file_get_contents(PHPCMS_PATH.$url);
		//判断文件名，如果是database.php 对里面的关键字符进行替换
		$basename = basename($url);
		if($basename == "database.php" || $basename == "system.php"){
			//$html = str_replace();
			showmessage(L('重要文件，不允许在线查看！'));
		}
		$file_list = getcache('scan_bad_file', 'scan');
		if (isset($file_list[$url]['func']) && is_array($file_list[$url]['func']) && !empty($file_list[$url]['func'])) foreach ($file_list[$url]['func'] as $key=>$val)
		{
			$func[$key] = strtolower($val[1]);
		}
		if (isset($file_list[$url]['code']) && is_array($file_list[$url]['code']) && !empty($file_list[$url]['code'])) foreach ($file_list[$url]['code'] as $key=>$val)
		{
			$code[$key] = strtolower($val[1]);
		}
		if (isset($func)) $func = array_unique($func);
		if (isset($code)) $code = array_unique($code);
		$show_header = true;
 		include $this->admin_tpl('public_view');
	}
	
	public function md5_creat() {
		set_time_limit(120);
		$pro = isset($_GET['pro']) && intval($_GET['pro']) ? intval($_GET['pro']) : 1;
		pc_base::load_app_func('global');
		switch ($pro) {
			case '1'://统计文件
				$msg = L('please_wait');
				ob_start();
				include $this->admin_tpl('md5_creat');
				ob_flush();
				ob_clean();
				$list = scan_file_lists(PHPCMS_PATH, 1, 'php', 0, 1);
				setcache('md5_'.date('Y-m-d'), $list, 'scan');
				echo '<script type="text/javascript">location.href="?m=scan&c=index&a=md5_creat&pro=2&pc_hash='.$_SESSION['pc_hash'].'"</script>';
				break;
				
			case '2':
				showmessage(L('viewreporttrue'),'?m=scan&c=index&a=init');
				break;
		}
	}
}