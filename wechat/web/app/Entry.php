<?php namespace app;

//业务代码,为了测试微信SDK功能
use wechat\Wx;

class Entry {
	protected $wx;

	public function __construct() {
		$config   = [
			'token'     => 'houdunren',
			'appID'     => 'wxcf444c17dbd095b9',
			'appsecret' => '6fd451c0cff05b6c39c51dd7f7bff562',
		];
		$this->wx = new Wx( $config );
		$this->wx->valid();
	}

	public function handler() {
		//angularJs   后盾人
		$json=<<<php
{
     "button":[
      {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {	
          "type":"view",
          "name":"后盾", 
          "url" :"http://www.houdunwang.com"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }
php;

		$res = $this->wx->instance('button')->create($json);
		var_dump($res);
//		echo $this->wx->getAccessToken();

		//		$message = $this->wx->instance( 'message' );
		//		if ( $message->isTextMsg() ) {
		//			$message->text( '这是文本消息' );
		//		}
		//		if ( $message->isImageMsg() ) {
		//			$message->text( '你发图片' );
		//		}
		//		if ( $message->isLinkMsg() ) {
		//			$message->text( '你发了链接' );
		//		}
		//		if ( $message->isVideoMsg() ) {
		//			$message->text( '你发了视频' );
		//		}
		//		if ( $message->isShortVideoMsg() ) {
		//			$message->text( '你发了短视频' );
		//		}
		//		if ( $message->isLocationMsg() ) {
		//			$message->text( '你上报了地址位置 ' );
		//		}
		//		if ( $message->isVoiceMsg() ) {
		//			$message->text( '你发了语音消息' );
		//		}
	}
}