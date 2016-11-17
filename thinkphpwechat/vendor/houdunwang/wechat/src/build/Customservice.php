<?php namespace wechat\build;
//客服
use wechat\WeChat;

class customService extends WeChat {
	//发送消息
	private function send( $toUser, $msgType, $data ) {
		$url    = $this->apiUrl . '/cgi-bin/message/custom/send?access_token=' . $this->getAccessToken();
		$json   = json_encode( [
				'touser'  => $toUser,
				'msgtype' => $msgType,
				$msgType  => $data
			] );
		$result = $this->curl( $url, $json );

		return $this->get( $result );
	}

	//发送文本消息
	public function sendTest( $toUser, $content ) {
		return $this->send( $toUser, 'text', [ 'content' => $content ] );
	}

	//发送图片消息
	public function sendImage( $toUser, $media_id ) {
		return $this->send( $toUser, 'image', [ 'media_id' => $media_id ] );
	}

	//发送语音消息
	public function sendVoice( $toUser, $media_id ) {
		return $this->send( $toUser, 'voice', [ 'media_id' => $media_id ] );
	}

	//发送视频消息
	public function sendVideo( $toUser, $media_id, $title, $desc = '' ) {
		return $this->send( $toUser, 'video', [
				'media_id'    => $media_id,
				'title'       => $title,
				'description' => $desc
			] );
	}

	//发送音乐消息
	public function sendMusic( $toUser, $thumb_media_id, $url, $title, $desc = '', $hq_url = '' ) {
		return $this->send( $toUser, 'music', [
				'title'          => $title,
				'description'    => $desc,
				'musicurl'       => $url,
				'thumb_media_id' => $thumb_media_id,
				'hqmusicurl'     => $hq_url || $url
			] );
	}

	//发送图文消息
	public function sendNews( $toUser, $articles ) {
		return $this->send( $toUser, 'news', [
				'articles' => $articles
			] );
	}
}