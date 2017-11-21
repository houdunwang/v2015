<?php
/*
 * 支付模块调用工厂
 */
class pay_factory  {
	
	public function __construct($adapter_name = '', $adapter_config = array()) {
		$this->set_adapter($adapter_name, $adapter_config);
	}
	/**
	 * 构造适配器
	 * @param  $adapter_name 支付模块code
	 * @param  $adapter_config 支付模块配置
	 */
	public function set_adapter($adapter_name, $adapter_config = array()) {
		if (!is_string($adapter_name)) return false;
		else {
			$class_name = ucwords($adapter_name);
			pc_base::load_app_class($class_name,'','0');
			$this->adapter_instance = new $class_name($adapter_config);
		}
		return $this->adapter_instance;
	}
	
	public function __call($method_name, $method_args) {
		if (method_exists($this, $method_name))
			return call_user_func_array(array(& $this, $method_name), $method_args);
		elseif (
			!empty($this->adapter_instance)
			&& ($this->adapter_instance instanceof paymentabstract)
			&& method_exists($this->adapter_instance, $method_name)
		) 
		return call_user_func_array(array(& $this->adapter_instance, $method_name), $method_args);
	}	
}
?>