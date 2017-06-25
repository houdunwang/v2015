<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\oss\build;

//错误处理
use houdunwang\config\Config;
use OSS\OssClient;

class Base {
	//oss实例
	protected $ossClient;
	//储存块
	protected $bucket;

	public function __construct() {
		$this->ossClient = new OssClient(
			Config::get( 'oss.accessKeyId' ),
			Config::get( 'oss.accessKeySecret' ),
			Config::get( 'oss.endpoint' ),
			Config::get( 'oss.custom_domain' )
		);
		$this->bucket    = Config::get( 'oss.bucket' );
	}

	public function __call( $name, $arguments ) {
		array_unshift( $arguments, $this->bucket );
		$fileInfo = pathinfo( $arguments['1'] );
		$arguments[1]  = time() . substr( md5( $arguments[1] ), 0, 5 ) . mt_rand( 0, 999 ) . '.' . $fileInfo['extension'];
		$arr           = call_user_func_array( [ $this->ossClient, $name ], $arguments );
		$arr['uptime'] = time();
		//文件上传时添加其他数据
		if ( in_array( $name, [ 'uploadFile' ] ) ) {
			$info             = pathinfo( $arguments['2'] );
			$arr['path']      = $arr['oss-request-url'];
			$arr['fieldname'] = '';
			$arr['basename']  = $info['basename'];
			$arr['filename']  = ''; //新文件名
			$arr['name']      = $info['filename']; //旧文件名
			$arr['size']      = $arr['info']['size_upload'];
			$arr['ext']       = $info['extension'];
			$arr['dir']       = '';
			$arr['image']     = in_array( strtolower( $info['extension'] ), [ 'jpg', 'jpeg', 'png', 'gif' ] );
		}

		return $arr;
	}
}