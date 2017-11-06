<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 19/10/2017
 * Time: 17:02
 * Email: 410004417@qq.com
 */

namespace houdunwang\core;


class Boot {
	public static function run(){
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
		//1.初始化
		self::init();
		//p($_SESSION);
		//echo date('Y-m-d H:i:s');
		//2.应用执行
		self::appRun();
	}



	private static function appRun(){
		//?s=admin/entry/index
		//?s=admin/member/index
		$s = isset($_GET['s']) ? strtolower($_GET['s']) : 'home/entry/index';
		$arr = explode('/',$s);

		//定义模块、控制器、方法的常量
		define('MODULE',$arr[0]);
		define('CONTROLLER',$arr[1]);
		define('ACTION',$arr[2]);


		$className = "\app\\" . $arr[0] . "\controller\\" . ucfirst($arr[1]);
		//echo $className;
		$controller = new $className;
		$action = $arr[2];
		$controller->$action();

	}

	/**
	 * 框架初始化
	 */
	private static function init(){
		session_id() || session_start();
		date_default_timezone_set('PRC');
	}
}