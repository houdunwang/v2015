<?php
/**
 *  cache_factory.class.php 缓存工厂类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class cache_factory {
	
	/**
	 * 当前缓存工厂类静态实例
	 */
	private static $cache_factory;
	
	/**
	 * 缓存配置列表
	 */
	protected $cache_config = array();
	
	/**
	 * 缓存操作实例化列表
	 */
	protected $cache_list = array();
	
	/**
	 * 构造函数
	 */
	function __construct() {
	}
	
	/**
	 * 返回当前终级类对象的实例
	 * @param $cache_config 缓存配置
	 * @return object
	 */
	public static function get_instance($cache_config = '') {

		if(cache_factory::$cache_factory == '') {
			cache_factory::$cache_factory = new cache_factory();
			if(!empty($cache_config)) {
				cache_factory::$cache_factory->cache_config = $cache_config;
			}
		}
		return cache_factory::$cache_factory;
	}
	
	/**
	 * 获取缓存操作实例
	 * @param $cache_name 缓存配置名称
	 */
	public function get_cache($cache_name) {
		if(!isset($this->cache_list[$cache_name]) || !is_object($this->cache_list[$cache_name])) {
			$this->cache_list[$cache_name] = $this->load($cache_name);
		}
		return $this->cache_list[$cache_name];
	}
	
	/**
	 *  加载缓存驱动
	 * @param $cache_name 	缓存配置名称
	 * @return object
	 */
	public function load($cache_name) {
		$object = null;
		if(isset($this->cache_config[$cache_name]['type'])) {
			switch($this->cache_config[$cache_name]['type']) {
				case 'file' :
					$object = pc_base::load_sys_class('cache_file');
					break;
				case 'memcache' :
					define('MEMCACHE_HOST', $this->cache_config[$cache_name]['hostname']);
					define('MEMCACHE_PORT', $this->cache_config[$cache_name]['port']);
					define('MEMCACHE_TIMEOUT', $this->cache_config[$cache_name]['timeout']);
					define('MEMCACHE_DEBUG', $this->cache_config[$cache_name]['debug']);
					
					$object = pc_base::load_sys_class('cache_memcache');
					break;
				case 'apc' :
					$object = pc_base::load_sys_class('cache_apc');
					break;
				default :
					$object = pc_base::load_sys_class('cache_file');
			}
		} else {
			$object = pc_base::load_sys_class('cache_file');
		}
		return $object;
	}

}
?>