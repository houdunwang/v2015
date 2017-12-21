<?php
/**
 *  push_factory.class.php 推送信息工厂类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-2
 */

final class push_factory {
	
	/**
	 *  推送信息工厂类静态实例
	 */
	private static $push_factory;
	
	/**
	 * 接口实例化列表
	 */
	protected $api_list = array();
	
	/**
	 * 返回当前终级类对象的实例
	 * @return object
	 */
	public static function get_instance() {
		if(push_factory::$push_factory == '') {
			push_factory::$push_factory = new push_factory();
		}
		return push_factory::$push_factory;
	}
	
	/**
	 * 获取api操作实例
	 * @param string $classname 接口调用的类文件名
	 * @param sting  $module	 模块名
	 * @return object	 
	 */
	public function get_api($module = 'admin') {
		if(!isset($this->api_list[$module]) || !is_object($this->api_list[$module])) {
			$this->api_list[$module] = pc_base::load_app_class('push_api', $module);
		}
		return $this->api_list[$module];
	}
}