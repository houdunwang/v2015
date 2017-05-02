<?php
	header('content-type:text/html;charset=utf8');
	//加载xml文档
	$xml=simplexml_load_file('wx.xml');
	//获取数据
	$tousername=$xml->ToUserName;
	$fromusername=$xml->FromUserName;
	$time=$xml->CreateTime;
	$type=$xml->MsgType;
	$content=$xml->Content;

	echo '微信'.$fromusername.'在'.date('Y-m-d H:i:s',(int)$time).'发送给'.$tousername.'一段'.$type.'消息,'.'消息的内容为'.$content;
?>