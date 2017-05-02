<?php namespace wechat\build;
use wechat\WeChat;

	/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

//接收消息
class Message extends WeChat {

	#-------------------用户事件类型----------------
	//关注事件
	CONST EVENT_TYPE_SUBSCRIBE = 'subscribe';
	//取消关注事件
	CONST EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
	//未关注用户扫描二维码事件
	CONST EVENT_TYPE_UNSUBSCRIBE_SCAN = 'subscribe';
	//关注用户扫描二维码事件
	CONST EVENT_TYPE_SUBSCRIBE_SCAN = 'SCAN';
	//上报地理位置事件
	CONST EVENT_TYPE_LOCATION = 'LOCATION';
	//点击菜单的事件类型
	CONST EVENT_TYPE_EVENT = 'event';
	#-------------------用户发送消息类型----------------
	//请求文本消息
	CONST MSG_TYPE_TEXT = 'text';
	//请求图片消息
	CONST MSG_TYPE_IMAGE = 'image';
	//请求语音消息
	CONST MSG_TYPE_VOICE = 'voice';
	//请求地理位置消息
	CONST MSG_TYPE_LOCATION = 'location';
	//请求链接消息
	CONST MSG_TYPE_LINK = 'link';
	//请求小视频消息
	CONST MSG_TYPE_SMALL_VIDEO = 'shortvideo';
	//请求视频消息
	CONST MSG_TYPE_VIDEO = 'video';
	#-------------------回复消息类型----------------
	//回复文本
	CONST REPLY_TYPE_TEXT = 'text';
	//回复图文
	CONST REPLY_TYPE_IMAGE = 'image';
	//回复语音
	CONST REPLY_TYPE_VOICE = 'voice';
	//回复视频
	CONST REPLY_TYPE_VIDEO = 'video';
	//音乐消息
	CONST REPLY_TYPE_MUSIC = 'music';
	//图文信息
	CONST REPLY_TYPE_NEWS = 'news';
	#-------------------按钮消息类型----------------
	//点击菜单拉取消息时的事件
	CONST BUTTON_EVENT_TYPE_CLICK = 'CLICK';
	//点击菜单跳转链接时的事件
	CONST BUTTON_EVENT_TYPE_VIEW = 'VIEW';
	//扫码推事件的事件推送
	CONST BUTTON_EVENT_TYPE_SCANCODE_PUSH = 'scancode_push';
	//扫码推事件且弹出“消息接收中”提示框的事件推送
	CONST BUTTON_EVENT_TYPE_SCANCODE_WAITMSG = 'scancode_waitmsg';
	//弹出系统拍照发图的事件推送
	CONST BUTTON_EVENT_TYPE_PIC_SYSPHOTO = 'pic_sysphoto';
	//弹出拍照或者相册发图的事件推送
	CONST BUTTON_EVENT_TYPE_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
	//弹出微信相册发图器的事件推送
	CONST BUTTON_EVENT_TYPE_PIC_WEIXIN = 'pic_weixin';
	//弹出地理位置选择器的事件推送
	CONST BUTTON_EVENT_TYPE_LOCATION_SELECT = 'location_select';

	//----------------------按钮消息-----------------------//
	//点击菜单拉取消息时的事件推送
	public function isClickEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_CLICK;
	}

	//点击菜单跳转链接时的事件推送
	public function isViewEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_VIEW;
	}

	//扫码推事件的事件推送
	public function isScancodePush() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_SCANCODE_PUSH;
	}

	//扫码推事件且弹出“消息接收中”提示框的事件推送
	public function isScancodeWaitmsg() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_SCANCODE_WAITMSG;
	}

	//扫码推事件的事件推送
	public function isPicSysphoto() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_PIC_SYSPHOTO;
	}

	//弹出拍照或者相册发图的事件推送
	public function isPicPhotoOrAlbum() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_PIC_PHOTO_OR_ALBUM;
	}

	//弹出微信相册发图器的事件推送
	public function isPicWeixin() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_PIC_WEIXIN;
	}

	//弹出地理位置选择器的事件推送
	public function isLocationSelect() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::BUTTON_EVENT_TYPE_LOCATION_SELECT;
	}

	//----------------------事件消息-----------------------//
	//关注
	public function isSubscribeEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::EVENT_TYPE_SUBSCRIBE;
	}

	//取消关注
	public function isUnSubscribeEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::EVENT_TYPE_UNSUBSCRIBE;
	}

	//未关注用户扫描二维码
	public function isSubscribeScanEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::EVENT_TYPE_UNSUBSCRIBE_SCAN;
	}

	//关注用户二维码事件
	public function isScanEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::EVENT_TYPE_SUBSCRIBE_SCAN;
	}

	//上报地理位置事件
	public function isLocationEvent() {
		return $this->message->MsgType == 'event' && $this->message->Event == self::EVENT_TYPE_LOCATION;
	}
	//----------------------普通消息-----------------------//
	//文本消息
	public function isTextMsg() {
		return $this->message->MsgType == self::MSG_TYPE_TEXT;
	}

	//图像消息
	public function isImageMsg() {
		return $this->message->MsgType == self::MSG_TYPE_IMAGE;
	}

	//语音消息
	public function isVoiceMsg() {
		return $this->message->MsgType == self::MSG_TYPE_VOICE;
	}

	//地址消息
	public function isLocationMsg() {
		return $this->message->MsgType == self::MSG_TYPE_LOCATION;
	}

	//链接消息
	public function isLinkMsg() {
		return $this->message->MsgType == self::MSG_TYPE_LINK;
	}

	//视频消息
	public function isVideoMsg() {
		return $this->message->MsgType == self::MSG_TYPE_VIDEO;
	}

	//小视频消息
	public function isSmallVideoMsg() {
		return $this->message->MsgType == self::MSG_TYPE_SMALL_VIDEO;
	}

	//----------------------回复消息-----------------------//
	//回复文本消息
	public function text( $content ) {
		$xml
			  = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_TEXT, $content );
		header( 'Content-type:application/xml' );
		echo $text;
	}

	//回复图片消息
	public function image( $media_id ) {
		$xml
			  = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_IMAGE, $media_id );
		header( 'Content-type:application/xml' );
		echo $text;
	}

	//回复语音消息
	public function voice( $media_id ) {
		$xml
			  = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_VOICE, $media_id );
		header( 'Content-type:application/xml' );
		echo $text;
	}

	//回复视频消息
	public function video( $video ) {
		$xml
			  = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_VIDEO, $video['media_id'], $video['title'], $video['description'] );
		header( 'Content-type:application/xml' );
		echo $text;
	}

	//回复音乐消息
	public function music( $music ) {
		$xml
			  = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
</Music>
</xml>';
		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_MUSIC, $music['title'], $music['description'], $music['musicurl'], $music['hqmusicurl'], $music['thumbmediaid'] );
		header( 'Content-type:application/xml' );
		echo $text;
	}

	//回复图文信息
	public function news( $news ) {
		$xml
			   = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>
</xml>';
		$item
			   = '<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>';
		$items = '';
		foreach ( (array) $news as $n ) {
			$items .= sprintf( $item, $n['title'], $n['discription'], $n['picurl'], $n['url'] );
		}

		$text = sprintf( $xml, $this->message->FromUserName, $this->message->ToUserName, time(), self::REPLY_TYPE_NEWS, count( $news ), $items );

		header( 'Content-type:application/xml' );
		echo $text;
	}

	//群发消息正式发送
	public function sendall( $data ) {
		$url = $this->apiUrl . '/cgi-bin/message/mass/sendall?access_token=' . $this->getAccessToken();

		$content = Curl::post( $url, json_encode( $data, JSON_UNESCAPED_UNICODE ) );

		$result = json_decode( $content, true );

		return $this->get( $result );
	}

	//群发消息预览发送
	public function preview( $data ) {
		$url = $this->apiUrl . '/cgi-bin/message/mass/preview?access_token=' . $this->getAccessToken();

		$content = Curl::post( $url, json_encode( $data, JSON_UNESCAPED_UNICODE ) );

		$result = json_decode( $content, true );

		return $this->get( $result );
	}
}