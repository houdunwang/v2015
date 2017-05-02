<?php namespace wechat\build;

//素材管理
use wechat\WeChat;

class Material extends WeChat {

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
		$file_path = realpath( $file_path );
		if ( class_exists( '\CURLFile' ) ) {
			//关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件
			$filedata = [
				'media' => new \CURLFile ( realpath( $file_path ) )
			];
		} else {
			$filedata = [
				'media' => '@' . realpath( $file_path )
			];
		}
		$result = $this->curl( $url, $filedata );

		return $this->get( $result );
	}

	/**
	 * 下载素材
	 *
	 * @param $media_id
	 * @param $file
	 *
	 * @return int
	 */
	public function download( $media_id, $file ) {
		$url    = $this->apiUrl . "/cgi-bin/media/get?access_token={$this->access_token}&media_id=$media_id";
		$result = $this->curl( $url );
		$dir    = dirname( $file );
		is_dir( $dir ) || mkdir( $dir, 0755, true );

		return file_put_contents( $file, $result );
	}

	//获取永久素材
	public function getMaterial( $media_id ) {
		$url  = $this->apiUrl . "/cgi-bin/material/get_material?access_token={$this->access_token}";
		$json = '{"media_id":"' . $media_id . '"}';

		$result = $this->curl( $url, $json );

		return $this->get( $result );
	}

	//删除永久素材
	public function delete( $media_id ) {
		$url     = $this->apiUrl . "/cgi-bin/material/del_material?access_token={$this->access_token}";
		$json    = '{"media_id":"' . $media_id . '"}';
		$content = $this->curl( $url, $json );

		return $this->get( $content );
	}

	//新增永久图文素材
	public function addNews( $articles ) {
		$url     = $this->apiUrl . "/cgi-bin/material/add_news?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $articles ) ) ) );

		return $this->get( $content );
	}

	//修改永久图文素材
	public function editNews( $article ) {
		$url     = $this->apiUrl . "/cgi-bin/material/update_news?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $article ) ) ) );

		return $this->get( $content );
	}

	//获取素材总数
	public function total() {
		$url     = $this->apiUrl . "/cgi-bin/material/get_materialcount?access_token={$this->access_token}";
		$content = $this->curl( $url );

		return $this->get( $content );
	}

	//获取素材列表
	public function lists( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/material/batchget_material?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}
}