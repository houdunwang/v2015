<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.3
 * @author connect@qq.com
 * @copyright ? 2011, Tencent Corporation. All rights reserved.
 */

/**
 * @brief 本文件包含了OAuth认证过程中会用到的公用方法 
 */


/**
 * @brief 对参数进行字典升序排序
 *
 * @param $params 参数列表
 *
 * @return 排序后用&链接的key-value对（key1=value1&key2=value2...)
 */
function get_normalized_string($params)
{
    ksort($params);
    $normalized = array();
    foreach($params as $key => $val)
    {
        $normalized[] = $key."=".$val;
    }

    return implode("&", $normalized);
}

/**
 * @brief 使用HMAC-SHA1算法生成oauth_signature签名值 
 *
 * @param $key  密钥
 * @param $str  源串
 *
 * @return 签名值
 */

function get_signature($str, $key)
{
    $signature = "";
    if (function_exists('hash_hmac'))
    {
        $signature = base64_encode(hash_hmac("sha1", $str, $key, true));
    }
    else
    {
        $blocksize	= 64;
        $hashfunc	= 'sha1';
        if (strlen($key) > $blocksize)
        {
            $key = pack('H*', $hashfunc($key));
        }
        $key	= str_pad($key,$blocksize,chr(0x00));
        $ipad	= str_repeat(chr(0x36),$blocksize);
        $opad	= str_repeat(chr(0x5c),$blocksize);
        $hmac 	= pack(
            'H*',$hashfunc(
                ($key^$opad).pack(
                    'H*',$hashfunc(
                        ($key^$ipad).$str
                    )
                )
            )
        );
        $signature = base64_encode($hmac);
    }

    return $signature;
} 

/**
 * @brief 对字符串进行URL编码，遵循rfc1738 urlencode
 *
 * @param $params
 *
 * @return URL编码后的字符串
 */
function get_urlencode_string($params)
{
    ksort($params);
    $normalized = array();
    foreach($params as $key => $val)
    {
        $normalized[] = $key."=".rawurlencode($val);
    }

    return implode("&", $normalized);
}

/**
 * @brief 检查openid是否合法
 *
 * @param $openid  与用户QQ号码一一对应
 * @param $timestamp　时间戳
 * @param $sig　　签名值
 *
 * @return true or false
 */
function is_valid_openid($appkey,$openid, $timestamp, $sig)
{
    $key = $appkey;
    $str = $openid.$timestamp;
    $signature = get_signature($str, $key);

    //echo "sig:$sig\n";
    //echo "str:$str\n";

    return $sig == $signature; 
}

/**
 * @brief 所有Get请求都可以使用这个方法
 *
 * @param $url
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 *
 * @return true or false
 */
function do_get($url, $appid, $appkey, $access_token, $access_token_secret, $openid)
{
    $sigstr = "GET"."&".rawurlencode("$url")."&";

    //必要参数, 不要随便更改!!
    $params = $_GET;
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;
    $params["oauth_token"]            = $access_token;
    $params["openid"]                 = $openid;
    unset($params["oauth_signature"]);

    //参数按照字母升序做序列化
    $normalized_str = get_normalized_string($params);
    $sigstr        .= rawurlencode($normalized_str);

    //签名,确保php版本支持hash_hmac函数
    $key = $appkey."&".$access_token_secret;
    $signature = get_signature($sigstr, $key);
    $url      .= "?".$normalized_str."&"."oauth_signature=".rawurlencode($signature);

    //echo "$url\n";
    return file_get_contents($url);
}

/**
 * @brief 所有multi-part post 请求都可以使用这个方法
 *
 * @param $url
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 *
 */
function do_multi_post($url, $appid, $appkey, $access_token, $access_token_secret, $openid)
{
    //构造签名串.源串:方法[GET|POST]&uri&参数按照字母升序排列
    $sigstr = "POST"."&"."$url"."&";

    //必要参数,不要随便更改!!
    $params = $_POST;
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;
    $params["oauth_token"]            = $access_token;
    $params["openid"]                 = $openid;
    unset($params["oauth_signature"]);


    //获取上传图片信息
    foreach ($_FILES as $filename => $filevalue)
    {
        if ($filevalue["error"] != UPLOAD_ERR_OK)
        {
            //echo "upload file error $filevalue['error']\n";
            //exit;
        } 
        $params[$filename] = file_get_contents($filevalue["tmp_name"]);
    }

    //对参数按照字母升序做序列化
    $sigstr .= get_normalized_string($params);

    //签名,需要确保php版本支持hash_hmac函数
    $key = $appkey."&".$access_token_secret;
    $signature = get_signature($sigstr, $key);
    $params["oauth_signature"] = $signature; 

    //处理上传图片
    foreach ($_FILES as $filename => $filevalue)
    {
        $tmpfile = dirname($filevalue["tmp_name"])."/".$filevalue["name"];
        move_uploaded_file($filevalue["tmp_name"], $tmpfile);
        $params[$filename] = "@$tmpfile";
    }

    /*
    echo "len: ".strlen($sigstr)."\n";
    echo "sig: $sigstr\n";
    echo "key: $appkey&\n";
    */

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);
    //$httpinfo = curl_getinfo($ch);
    //print_r($httpinfo);

    curl_close($ch);
    //删除上传临时文件
    unlink($tmpfile);
    return $ret;

}


/**
 * @brief 所有post 请求都可以使用这个方法
 *
 * @param $url
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 *
 */
function do_post($url, $appid, $appkey, $access_token, $access_token_secret, $openid)
{
    //构造签名串.源串:方法[GET|POST]&uri&参数按照字母升序排列
    $sigstr = "POST"."&".rawurlencode($url)."&";

    //必要参数,不要随便更改!!
    $params = $_POST;
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;
    $params["oauth_token"]            = $access_token;
    $params["openid"]                 = $openid;
    unset($params["oauth_signature"]);

    //对参数按照字母升序做序列化
    $sigstr .= rawurlencode(get_normalized_string($params));

    //签名,需要确保php版本支持hash_hmac函数
    $key = $appkey."&".$access_token_secret;
    $signature = get_signature($sigstr, $key); 
    $params["oauth_signature"] = $signature; 

    $postdata = get_urlencode_string($params);

    //echo "$sigstr******\n";
    //echo "$postdata\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;

}

?>
