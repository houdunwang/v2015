<?php namespace wechat\build;
use wechat\Wx;

/**
 * 专门处理微信消息
 * Class Message
 * @package wechat\build
 */
class Message extends Wx {
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