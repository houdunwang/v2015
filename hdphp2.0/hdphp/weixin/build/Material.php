<?php namespace hdphp\weixin\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use hdphp\weixin\Weixin;

//素材管理
class Material extends Weixin {

	/**
	 * 上传素材
	 *
	 * @param     $type
	 * @param     $file_path
	 * @param int $mediaType 1 临时 0 永久
	 *
	 * @return mixed
	 */
	public function upload( $type, $file_path, $mediaType = 0 ) {
		if ( $mediaType ) {
			//临时素材
			$url = $this->apiUrl . "/cgi-bin/media/upload?access_token={$this->access_token}&type=$type";
		} else {
			//永久素材
			$url = $this->apiUrl . "/cgi-bin/material/add_material?access_token={$this->access_token}&type=$type";
		}
		$mime      = $type == 'image' ? 'image/jpeg' : '';
		$file_path = realpath( $file_path );
		if ( class_exists( '\CURLFile' ) ) {
			//关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件
			$filedata = [
				'media' => new \CURLFile ( realpath( $file_path ), $mime )
			];
		} else {
			$filedata = [
				'media' => '@' . realpath( $file_path )
			];
		}
		$result = Curl::post( $url, $filedata );
		$result = json_decode( $result, TRUE );

		return $this->get( $result );
	}

	//下载素材
	public function download( $media_id, $file ) {
		$url    = $this->apiUrl . "/cgi-bin/media/get?access_token={$this->access_token}&media_id=$media_id";
		$result = Curl::get( $url );
		if ( ! is_dir( C( 'upload.path' ) ) ) {
			mkdir( C( 'upload.path' ), 0755, TRUE );
		}

		return file_put_contents( $file, $result );
	}

	//获取永久素材
	public function getMaterial( $media_id ) {
		$url     = $this->apiUrl . "/cgi-bin/material/get_material?access_token={$this->access_token}";
		$json    = '{"media_id":"' . $media_id . '"}';
		return Curl::post( $url, $json );
	}

	//删除永久素材
	public function delete( $media_id ) {
		$url     = $this->apiUrl . "/cgi-bin/material/del_material?access_token={$this->access_token}";
		$json    = '{"media_id":"' . $media_id . '"}';
		$content = Curl::post( $url, $json );
		$result  = json_decode( $content, TRUE );
		return $this->get( $result );
	}

	//新增永久图文素材
	public function addNews( $articles ) {
		$url     = $this->apiUrl . "/cgi-bin/material/add_news?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $articles ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//修改永久图文素材
	public function editNews( $article ) {
		$url     = $this->apiUrl . "/cgi-bin/material/update_news?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $article ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//获取素材总数
	public function total() {
		$url     = $this->apiUrl . "/cgi-bin/material/get_materialcount?access_token={$this->access_token}";
		$content = Curl::get( $url );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//获取素材列表
	public function lists( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/material/batchget_material?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}
}