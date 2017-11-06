<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 19/10/2017
 * Time: 17:45
 * Email: 410004417@qq.com
 */

namespace houdunwang\view;


class Base {
	private $var = [];

	public function with($var){
		$this->var = $var;
		return $this;
	}

	public function make() {
		extract($this->var);
		include '../app/' . MODULE . '/view/' . CONTROLLER . '/' . ACTION . '.php';
	}
}