<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

/**
 * 文件处理
 * Class FileHandler
 * @package hdphp\session
 * @author 向军
 */
class FileHandler implements AbSession {
	//执行SESSION控制
	public function make() {
		//创建目录
		if ( ! is_dir( ROOT_PATH . '/storage/session' ) ) {
			mkdir( ROOT_PATH . '/storage/session', 0755, TRUE );
		}

		//设置session保存目录
		session_save_path( ROOT_PATH . '/storage/session' );
	}
}