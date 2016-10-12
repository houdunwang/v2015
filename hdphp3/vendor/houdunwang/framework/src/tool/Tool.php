<?php namespace hdphp\tool;
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

class Tool {
	private $app;

	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * 生成随机数字
	 *
	 * @param int $len 数量
	 *
	 * @return string
	 */
	public function randNum( $len = 4 ) {
		$str = '0123456789';
		$s   = '';
		for ( $i = 0;$i < $len;$i ++ ) {
			$pos = mt_rand( 0, strlen( $str ) - 1 );
			$s .= $str[ $pos ];
		}

		return $s;
	}

	/**
	 * 下载文件
	 *
	 * @param $filepath
	 */
	public function download( $filepath, $name = '' ) {
		if ( is_file( $filepath ) ) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename=' . ( $name ?: basename( $filepath ) ) );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Pragma: public' );
			header( 'Content-Length: ' . filesize( $filepath ) );
			readfile( $filepath );
		}
	}

	/**
	 * 根据大小返回标准单位 KB  MB GB等
	 *
	 * @param int $size
	 * @param int $decimals 小数位
	 *
	 * @return string
	 */
	public function getSize( $size, $decimals = 2 ) {
		switch ( TRUE ) {
			case $size >= pow( 1024, 3 ):
				return round( $size / pow( 1024, 3 ), $decimals ) . " GB";
			case $size >= pow( 1024, 2 ):
				return round( $size / pow( 1024, 2 ), $decimals ) . " MB";
			case $size >= pow( 1024, 1 ):
				return round( $size / pow( 1024, 1 ), $decimals ) . " KB";
			default:
				return $size . 'B';
		}
	}
}