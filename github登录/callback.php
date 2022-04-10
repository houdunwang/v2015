<?php
/**
 * curl 请求
 * @param       $url		请求地址
 * @param array $postData	请求数据
 * @param array $headers	头信息
 *
 * @return string
 */
function curl($url,$postData = [],$headers = []){
	$ch = curl_init ();
	curl_setopt ($ch,CURLOPT_URL,$url);
	curl_setopt ($ch,CURLOPT_HEADER,0);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt ($ch,CURLOPT_HTTPHEADER,$headers);
	if($postData){
		curl_setopt ($ch,CURLOPT_TIMEOUT,60);
		curl_setopt ($ch,CURLOPT_POST,1);
		curl_setopt ($ch,CURLOPT_POSTFIELDS,$postData);
	}
	if(curl_exec ($ch) == false){
		$data = '';
	}else{
		$data = curl_multi_getcontent ($ch);
	}
	curl_close ($ch);
	return $data;
}

/**
 * 获取access_token
 */
$postData = [
	'client_id'=>'c9855f80d186eb010762',
	'client_secret'=>'df1cdfbd7acd7d9fec4e2d8ea0fade6e2d8a8d03',
	'code'=>$_GET['code'],
];
//获取字符串
//$res = curl ('https://github.com/login/oauth/access_token',$postData);
//获取json数据
$res = curl ('https://github.com/login/oauth/access_token',$postData,['Accept: application/json']);
//xml数据
//$res = curl ('https://github.com/login/oauth/access_token',$postData,['Accept: application/xml']);
$res = json_decode ($res,true);
$access_token = $res['access_token'];


/**
 * 根据access_token换取用户信息
 */
$res = curl ('https://api.github.com/user?access_token='.$access_token,[],['User-Agent:houdunren']);
$res = json_decode ($res,true);
//将用户昵称头像存储
session_start ();
$_SESSION['login'] = $res['login'];
$_SESSION['avatar_url'] = $res['avatar_url'];
header ('location:/');exit;












