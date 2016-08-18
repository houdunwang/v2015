<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\html;

class Html {
	private $app;

	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * 生成静态
	 *
	 * @param $controller 控制器
	 * @param $action     动作
	 * @param $file       静态文件
	 *
	 * @return int
	 */
	public function make( $controller, $action, $file ) {
		ob_start();
		$this->app->make( $controller )->$action();
		$data = ob_get_clean();

		//目录检测
		if ( ! is_dir( dirname( $file ) ) ) {
			mkdir( dirname( $file ), 0755, TRUE );
		}

		//创建静态文件
		return file_put_contents( $file, $data ) !== FALSE;
	}
}