<?php
	$str=<<<php
	<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
	</xml>
php;
	//定义一个数组，存放消息
	$arr=array(
			'to'=>'小明',
			'from'=>'小刚',
			'time'=>time(),
			'type'=>'text',
			'content'=>'后盾网，人人做后盾'
		);
	/*header('content-type:application/xml');
	//格式化字符串的函数
	$xmlstr=sprintf($str,$arr['to'],$arr['from'],$arr['time'],$arr['type'],$arr['content']);
	// 真正的微信开发是：echo 之后的数据，交给微信服务器
	echo $xmlstr;*/
	$xmlstr=sprintf($str,$arr['to'],$arr['from'],$arr['time'],$arr['type'],$arr['content']);
	file_put_contents('wx.xml',$xmlstr);
?>