<?php namespace hdphp\cache;
/**
 * 缓存服务基础类
 * Class Base
 * @package hdphp\cache
 * @author 向军 <2300071698@qq.com>
 */
trait Base {
	public function __construct() {
		$this->connect();
	}
}