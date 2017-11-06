<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 02/11/2017
 * Time: 14:41
 * Email: 410004417@qq.com
 */

namespace app\admin\controller;


use houdunwang\core\Controller;

class Common extends Controller {
	public function __construct() {
		if(!isset($_SESSION['user'])){
			$this->message('请去登陆','?s=admin/login/index');
		}
	}


}