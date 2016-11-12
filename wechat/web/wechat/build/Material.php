<?php namespace wechat\build;

use wechat\Wx;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class Material extends Wx {
	/**
	 * 资源类素材上传
	 *
	 * @param $file 文件
	 * @param string $type 素材类型
	 * @param int $materialType 永久0 临时素材1
	 *
	 * @return array|bool
	 */
	public function upload( $file, $type = 'image', $materialType = 0 ) {
		switch ( $materialType ) {
			case 0:
				//永久
				$url = $this->apiUrl . '/cgi-bin/material/add_material?access_token=' . $this->getAccessToken() . '&type=' . $type;
				break;
			default:
				//临时
				$url = $this->apiUrl . '/cgi-bin/media/upload?access_token=' . $this->getAccessToken() . '&type=' . $type;
		}
		//curl   get post   php 5.5> CURLFile类     @
		$file = realpath( $file );//将文件转为绝对路径
		if ( class_exists( '\CURLFile', false ) ) {
			$data = [
				'media' => new \CURLFile( $file )
			];
		} else {
			$data = [
				'media' => '@' . $file
			];
		}
		$res = $this->curl( $url, $data );

		return $this->get( json_decode( $res, true ) );
	}
}