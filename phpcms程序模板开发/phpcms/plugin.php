<?php 
/**
 *   plugin.php 插件入口
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2013-06-07
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
$param = pc_base::load_sys_class('param');
pc_base::load_sys_func('plugin');
$cache = '';

if(isset($_GET['id'])) {
	if(!preg_match("/^[a-z0-9_\-]+$/i",$_GET['id'])) showmessage((L('illegal_parameters')));
	list($identification, $filename,$action) = explode('-', $_GET['id']);
	$filename = !empty($filename) ? $filename : $identification;
	$action = !empty($action) ? $action : 'init';
}
if(!preg_match("/^[a-z0-9_\-]+$/i", $identification)) showmessage(L('plugin_not_exist','','plugin'));
$cache = getcache($identification,'plugins');

if(!$cache['disable'] || $filename=='plugin_admin'  || $filename=='hook') {
	showmessage(L('plugin_not_exist','','plugin'));
} else {
	$status = plugin_stat($cache['appid']);
	if($status== 0 || $app_status == 1) {
		showmessage(L('plugin_developing','','plugin'));
	} elseif($status== 3) {
		showmessage(L('plugin_be_locked','','plugin'));	
	} 
	$iframe = string2array($cache['iframe']);
	if($iframe['url']) {
		$cache_var = getcache($identification.'_var','plugins');
		plugin_base::creat_iframe($cache,$cache_var);
	} else {
		plugin_base::creat_app($identification, $filename, $action);
	}
}


class plugin_base {
	/**
	 * 初始化插件
	 */
	public static function creat_app($id,$file,$action) {
		define('PLUGIN_ID', $id);
		define('PLUGIN_FILE', $file);
		define('PLUGIN_ACTION', $action);
		self::plugin_init();
	}
	
	/**
	 * 调用插件方法
	 */
	private function plugin_init() {
		$controller = self::load_controller();
		if (method_exists($controller, PLUGIN_ACTION)) {
			if (preg_match('/^[_]/i', PLUGIN_ACTION)) {
				exit('Plugin Error:You are visiting the action is to protect the private action');
			} else {
				call_user_func(array($controller, PLUGIN_ACTION));
			}
		} else {
			exit(L('plugin_error_or_not_exist','','plugin'));
		}
	}
	
	/**
	 * 加载插件控制器
	 * @param string $filename
	 * @param string $m
	 * @return obj
	 */
	private function load_controller($filename = '', $m = '') {
		if (empty($filename)) $filename = PLUGIN_FILE;
		if (empty($m)) $m = PLUGIN_ID;
		$filepath = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.'.class.php';
		if (file_exists($filepath) && $filename !='plugin_admin') {
			$classname = $filename;
			include $filepath;
			if ($mypath = pc_base::my_path($filepath)) {
				$classname = 'MY_'.$filename;
				include $mypath;
			}
			return new $classname;
		} else {
			exit(L('plugin_error_or_not_exist','','plugin'));
		}
	}		
	
	/**
	 * 加载插件模板
	 */
	final public static function plugin_tpl($file, $identification = '') {
		$identification = empty($identification) && defined('PLUGIN_ID') ? PLUGIN_ID : $identification;
		if(empty($identification)) return false;
		return PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
	
	public static function creat_iframe($cache = '',$cache_var = '') {
		$iframe = string2array($cache['iframe']);
		$width = $cache_var['width'] ? $cache_var['width'] : $iframe['width'];
		$height = $cache_var['height'] ? $cache_var['height'] : $iframe['width'];
		$url = $iframe['url'];
		$SEO = seo(1, 0, $cache['name'], $cache['description'], $cache['name']);
		include template('plugin','iframe');
	}
}
?>