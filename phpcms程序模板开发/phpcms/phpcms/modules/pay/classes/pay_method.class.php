<?php
class pay_method  {
	
	public function __construct($modules_path) {
		$this->db = pc_base::load_model('pay_payment_model');
		$this->modules_path = $modules_path;
	}
	
	/**
	 * 获取支付类型列表
	 */
	public function get_list() {
		$list = $this->get_payment();
		$install = $this->get_intallpayment();
		if(is_array($list)) {
		foreach ($list as $code => $payment ) {
			if (isset($install[$code])) {
				$install[$code]['pay_desc'] = $list[$code]['pay_desc'];
				unset($list[$code]);
			}
		}
		}
		$all = @array_merge($install, $list);
		return array('data' => $all,
						array(
								'all' => count($all),
								'install' => count($install)
								)
					);
	 }
	 		
	/**
	 * 获取插件目录信息
	 * @param unknown_type $code
	 */
	public function get_payment( $code = '') {
		$modules = $this->read_payment($this->modules_path.DIRECTORY_SEPARATOR.'classes');
		foreach($modules as $payment) {
			if ( empty($code) || $payment['code']) {
				$config = array();
				foreach ($payment['config'] as $conf) {
					$name = $conf['name'];
					$conf['name'] = L($name);
					if ($conf['type'] == 'select') {
						$conf['range'] = L($name.'_range');
					}
					$config[$name] = $conf;
				}
			}			
			$payment_info[$payment['code']] = array(
				"pay_id" => 0,
				"pay_code" => $payment['code'],
				"pay_name" => $payment['name'],
				"pay_desc" => $payment['desc'],
				"pay_fee" => '0',
				"config" => $config,
				"is_cod" => $payment['is_cod'],
				"is_online" => $payment['is_online'],
				"enabled" => '0',
				"sort_order" => "",
				"author" => $payment['author'],
				"website" => $payment['website'],
				"version" => $payment['version']
				);			
		}
		if (empty($code)) {
			return $payment_info;
		} else {
			return $payment_info[$code];
		}		
	}

	/**
	 * 取得数据库中的支付列表
	 * @param $code
	 */
	public function get_intallpayment($code = '')
	{
		if (empty($code)) {
			$intallpayment = array();
			$result = $this->db->select();
			foreach($result as $r) {
				$r['pay_code'] = ucwords($r['pay_code']);
				$intallpayment[$r['pay_code']] = $r;
			}
			return $intallpayment;
		} else {
			return  $this->db->get_one(array('pay_code'=>ucwords($code)));
		}

	}
	
	/**
	 * 读取插件目录中插件列表
	 * @param unknown_type $directory
	 */
	public function read_payment($directory = ".") {
		$dir = @opendir($directory);
		$set_modules = true;
		$modules = array();
		while (($file = @readdir($dir))!== false) {
		 	if ( preg_match( "/^[A-Z]{1}.*?\\.class.php\$/", $file ) ) {
		 		include_once( $directory.DIRECTORY_SEPARATOR.$file );
		 	}
		}
		@closedir($dir);
		foreach ($modules as $key => $value ) {
				asort($modules[$key] );
		 }
		asort( $modules );		
		return $modules;
	}		
}
?>