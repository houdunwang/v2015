<?php
$phone = $_POST['phone'];

$host = "https://api04.aliyun.venuscn.com";
$path = "/mobile";
$method = "GET";
$appcode = "5649dd4f1edb48e581ddc4ff1518c67e";
$headers = array();
array_push($headers, "Authorization:APPCODE " . $appcode);
$querys = "mobile=".$phone;
$bodys = "";
$url = $host . $path . "?" . $querys;

$curl = curl_init();
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_FAILONERROR, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, true);
if (1 == strpos("$".$host, "https://"))
{
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
}
$content = curl_exec($curl);
$header_size = curl_getinfo ($curl,CURLINFO_HEADER_SIZE);
$bodys = substr ($content,$header_size);
$res = json_decode ($bodys,true);

if($res['ret']==200){
	//说明查询成功
	$data = [
		'status'=>1,'msg'=>'查询成功',
		'data'=>[
			'types'=>$res['data']['types'],
			'area'=>$res['data']['prov'] . '/' . $res['data']['city'],
			'zip_code'=>$res['data']['zip_code'],
			'city_code'=>$res['data']['city_code'],
		],
	];

}else{
	//说明查询失败
	$data = [
		'status'=>0,
		'msg'=>$res['msg'],
		'data'=>'',
	];
}
echo json_encode ($data,JSON_UNESCAPED_UNICODE);
