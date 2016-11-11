<?php namespace wechat\build;
use wechat\Wx;

/**
 * 专门处理微信消息
 * Class Message
 * @package wechat\build
 */
class Message extends Wx {
	#--------------用户发送的消息类型--------
	//消息类型为文本消息
	const MSG_TYPE_TEXT = 'text';
	//图片消息
	const MSG_TYPE_IMAGE = 'image';
	//语音
	const MSG_TYPE_VOICE = 'voice';
	//视频
	const MSG_TYPE_VIDEO = 'video';
	//短视频
	const MSG_TYPE_SHORT_VIDEO = 'shortvideo';
	//地理位置
	const MSG_TYPE_LOCATION = 'location';
	//链接
	const MSG_TYPE_LINK = 'link';

	//------------------消息判断------------
	//文本消息
	public function isTextMsg() {
		return $this->message->MsgType == self::MSG_TYPE_TEXT;
	}

	//图片消息
	public function isImageMsg() {
		return $this->message->MsgType == self::MSG_TYPE_IMAGE;
	}

	//语音消息
	public function isVoiceMsg() {
		return $this->message->MsgType == self::MSG_TYPE_VOICE;
	}

	//视频消息
	public function isVideoMsg() {
		return $this->message->MsgType == self::MSG_TYPE_VIDEO;
	}

	//短视频消息
	public function isShortVideoMsg() {
		return $this->message->MsgType == self::MSG_TYPE_SHORT_VIDEO;
	}

	//地理位置消息
	public function isLocationMsg() {
		return $this->message->MsgType == self::MSG_TYPE_LOCATION;
	}

	//链接消息
	public function isLinkMsg() {
		return $this->message->MsgType == self::MSG_TYPE_LINK;
	}


	//------------------回复消息------------
	//回复文本消息
	public function text( $content ) {
		$xml
			  = '
		<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), $content );
		header( 'Content-type:application/xml' );
		echo $text;
	}
}