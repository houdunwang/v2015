<?php
/**
 *  param.class.php	参数处理类
 *
 * @copyright			(C) 2005-2012 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2012-9-17
 */
class param {

	//路由配置
	private $route_config = '';
	
	public function __construct() {
		if(!get_magic_quotes_gpc()) {
			$_POST = new_addslashes($_POST);
			$_GET = new_addslashes($_GET);
			$_REQUEST = new_addslashes($_REQUEST);
			$_COOKIE = new_addslashes($_COOKIE);
		}

		$this->route_config = pc_base::load_config('route', SITE_URL) ? pc_base::load_config('route', SITE_URL) : pc_base::load_config('route', 'default');

		if(isset($this->route_config['data']['POST']) && is_array($this->route_config['data']['POST'])) {
			foreach($this->route_config['data']['POST'] as $_key => $_value) {
				if(!isset($_POST[$_key])) $_POST[$_key] = $_value;
			}
		}
		if(isset($this->route_config['data']['GET']) && is_array($this->route_config['data']['GET'])) {
			foreach($this->route_config['data']['GET'] as $_key => $_value) {
				if(!isset($_GET[$_key])) $_GET[$_key] = $_value;
			}
		}
		if(isset($_GET['page'])) {
			$_GET['page'] = max(intval($_GET['page']),1);
			$_GET['page'] = min($_GET['page'],1000000000);
		}
		return true;
	}

	/**
	 * 获取模型
	 */
	public function route_m() {
		$m = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] : (isset($_POST['m']) && !empty($_POST['m']) ? $_POST['m'] : '');
		$m = $this->safe_deal($m);
		if (empty($m)) {
			return $this->route_config['m'];
		} else {
			if(is_string($m)) return $m;
		}
	}

	/**
	 * 获取控制器
	 */
	public function route_c() {
		$c = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : (isset($_POST['c']) && !empty($_POST['c']) ? $_POST['c'] : '');
		$c = $this->safe_deal($c);
		if (empty($c)) {
			return $this->route_config['c'];
		} else {
			if(is_string($c)) return $c;
		}
	}

	/**
	 * 获取事件
	 */
	public function route_a() {
		$a = isset($_GET['a']) && !empty($_GET['a']) ? $_GET['a'] : (isset($_POST['a']) && !empty($_POST['a']) ? $_POST['a'] : '');
		$a = $this->safe_deal($a);
		if (empty($a)) {
			return $this->route_config['a'];
		} else {
			if(is_string($a)) return $a;
		}
	}

	/**
	 * 设置 cookie
	 * @param string $var     变量名
	 * @param string $value   变量值
	 * @param int $time    过期时间
	 */
	public static function set_cookie($var, $value = '', $time = 0) {
		$time = $time > 0 ? $time : ($value == '' ? SYS_TIME - 3600 : 0);
		$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
		$httponly = $var=='userid'||$var=='auth'?true:false;
		$var = pc_base::load_config('system','cookie_pre').$var;
		$_COOKIE[$var] = $value;
		if (is_array($value)) {
			foreach($value as $k=>$v) {
				setcookie($var.'['.$k.']', sys_auth($v, 'ENCODE', md5(PC_PATH.'cookie'.$var).pc_base::load_config('system','auth_key')), $time, pc_base::load_config('system','cookie_path'), pc_base::load_config('system','cookie_domain'), $s, $httponly);
			}
		} else {
			setcookie($var, sys_auth($value, 'ENCODE', md5(PC_PATH.'cookie'.$var).pc_base::load_config('system','auth_key')), $time, pc_base::load_config('system','cookie_path'), pc_base::load_config('system','cookie_domain'), $s, $httponly);
		}
	}

	/**
	 * 获取通过 set_cookie 设置的 cookie 变量 
	 * @param string $var 变量名
	 * @param string $default 默认值 
	 * @return mixed 成功则返回cookie 值，否则返回 false
	 */
	public static function get_cookie($var, $default = '') {
		$var = pc_base::load_config('system','cookie_pre').$var;
		$value = isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var], 'DECODE', md5(PC_PATH.'cookie'.$var).pc_base::load_config('system','auth_key')) : $default;
		if(in_array($var,array('_userid','userid','siteid','_groupid','_roleid'))) {
			$value = intval($value);
		} elseif(in_array($var,array('_username','username','_nickname','admin_username','sys_lang'))) { //  site_model auth
			$value = safe_replace($value);
		}
		return $value;
	}

	/**
	 * 安全处理函数
	 * 处理m,a,c
	 */
	private function safe_deal($str) {
		return str_replace(array('/', '.'), '', $str);
	}

}
?>