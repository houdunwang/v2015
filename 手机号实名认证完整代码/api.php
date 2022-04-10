<?php
$host = "http://fephone.market.alicloudapi.com";
$path = '/phoneCheck';
$method  = 'GET';
$appcode = '5649dd4f1edb48e581ddc4ff1518c67e';
$headers = [];
array_push ($headers,'Authorization:APPCODE ' . $appcode);
$querys = 'idCard=' . $_POST['idcard'] . '&mobile=' . $_POST['phone'] . '&name=' . $_POST['name'];
$url = $host . $path . '?' . $querys;

$curl = curl_init ();
curl_setopt ($curl,CURLOPT_CUSTOMREQUEST,$method);
curl_setopt ($curl,CURLOPT_URL,$url);
curl_setopt ($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt ($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt ($curl,CURLOPT_HEADER,false);
$res = curl_exec ($curl);
//echo '<pre>';
//print_r ($res);

echo $res;exit;
