<?php

//取得php配置参数
function EGInfo_ReturnPHPiniVar($var){
	if(function_exists('ini_get'))
	{
		$val=@ini_get($var);
	}
	else
	{
		$val=@get_cfg_var($var);
	}
	return $val;
}

//验证函数是否存在
function EGInfo_PHPHaveFun($fun){
	if(function_exists($fun))
	{
		$st=1;
	}
	else
	{
		$st=0;
	}
	return $st;
}

//取得操作系统
function EGInfo_GetUseSys(){
	if(defined('PHP_OS'))
	{
		$sys=PHP_OS;
	}
	else
	{
		$phposall=@php_uname();
		$phpos=explode(" ",$phposall);
		$sys=$phpos[0]."&nbsp;".$phpos[1];
		if(empty($phpos[0]))
		{
			$sys="---";
		}
	}
	return $sys;
}

//返回服务器软件
function EGInfo_GetUseWebServer(){
	$webserver=$_SERVER['SERVER_SOFTWARE'];
	return $webserver;
}

//返回PHP版本
function EGInfo_GetPHPVersion(){
	if(defined('PHP_VERSION'))
	{
		$ver=PHP_VERSION;
	}
	else
	{
		$ver=@phpversion();
	}
	return $ver;
}

//返回当前时间
function EGInfo_GetDatetime(){
	$datetime=date("Y-m-d H:i:s");
	return $datetime;
}

//返回IP
function EGInfo_GetUserIP(){
	$loginip=Ebak_egetip();
	return $loginip;
}

//返回域名
function EGInfo_GetDomain(){
	$domain=$_SERVER['HTTP_HOST'];
	return $domain;
}

//返回当前绝对路径
function EGInfo_GetAbsPath(){
	$path=EBAK_PATH;
	return $path;
}

//是否开启魔术引用
function EGInfo_GetPHPMagicQuotes(){
	$phpmq=MAGIC_QUOTES_GPC;
	return $phpmq;
}

//是否运行于安全模式
function EGInfo_GetPHPSafemod(){
	$phpsafemod=EGInfo_ReturnPHPiniVar('safe_mode');
	return $phpsafemod;
}

//返回register_globals状态
function EGInfo_GetPHPRGlobals(){
	$phprglobals=EGInfo_ReturnPHPiniVar('register_globals');
	return $phprglobals;
}

//返回file_uploads状态
function EGInfo_GetPHPFileUploads(){
	$fileuploads=EGInfo_ReturnPHPiniVar('file_uploads');
	return $fileuploads;
}

//返回最大上传文件大小
function EGInfo_GetPHPMaxUploadSize(){
	$uploadsize=EGInfo_ReturnPHPiniVar('upload_max_filesize');
	return $uploadsize;
}

//返回表单最大提交大小
function EGInfo_GetPHPMaxPostSize(){
	$postsize=EGInfo_ReturnPHPiniVar('post_max_size');
	return $postsize;
}

//返回是否开启短标签
function EGInfo_GetPHPShortTag(){
	$st=EGInfo_ReturnPHPiniVar('short_open_tag');
	return $st;
}

//返回表单最大变量
function EGInfo_GetPHPMaxInputVars(){
	$maxvars=EGInfo_ReturnPHPiniVar('max_input_vars');
	return $maxvars;
}

//返回表单最大上传文件数
function EGInfo_GetPHPMaxUploadFileNum(){
	$maxfilenum=EGInfo_ReturnPHPiniVar('max_file_uploads');
	return $maxfilenum;
}

//返回是否支持GD库
function EGInfo_GetPHPGd(){
	$st=EGInfo_PHPHaveFun('gd_info');
	return $st;
}


//返回mysql版本
function EGInfo_GetMysqlVersion(){
	global $link,$empire,$phome_db_server,$phome_db_username,$phome_db_password,$phome_db_dbname,$phome_db_port,$phome_db_char,$phome_db_ver;
	if(empty($phome_db_ver))
	{
		return '';
	}
	$dbhost=$phome_db_server;
	$dbport=$phome_db_port;
	$dbuser=$phome_db_username;
	$dbpass=$phome_db_password;
	if(!$dbhost)
	{
		return '';
	}
	$link=do_dbconnect_common($dbhost,$dbport,$dbuser,$dbpass);
	if(empty($link))
	{
		return '';
	}
	$empire=new mysqlquery();
	$getdbver=do_eGetDBVer(1);
	return $getdbver;
}

//返回支持mysql接口方式
function EGInfo_GetMysqlConnectType(){
	$ct=Ebak_ReturnMysqlConnectType();
	$types='';
	if($ct==1)
	{
		$types='mysql';
	}
	elseif($ct==2)
	{
		$types='mysqli';
	}
	elseif($ct==3)
	{
		$types='mysql,mysqli';
	}
	else
	{
		$types='';
	}
	return $types;
}


//是否支持采集
function EGInfo_GetCj(){
	$cj=EGInfo_ReturnPHPiniVar('allow_url_fopen');
	return $cj;
}

//测试采集
function EGInfo_TestCj(){
	$testpage=EGInfo_ReturnHttpPath('eginfo.php');
	if(!$testpage)
	{
		$testpage='http://www.phome.net';
	}
	$r=@file($testpage);
	if($r[5])
	{
		$st=1;
	}
	else
	{
		$st=0;
	}
	return $st;
}

//取得php运行模式
function EGInfo_GetPhpMod(){
	$mod=@php_sapi_name();
	$mod=strtoupper($mod);
	if(empty($mod))
	{
		$mod="---";
	}
	return $mod;
}

//是否支持ICONV库
function EGInfo_GetIconv(){
	$st=EGInfo_PHPHaveFun('iconv');
	return $st;
}


//是否支持zend
function EGInfo_GetZend(){
	@ob_start();
	@phpinfo();
	$string=@ob_get_contents();
	@ob_end_clean();
	if(stristr($string,'Zend Guard Loader')||stristr($string,'Zend Optimizer')||stristr($string,'Zend&nbsp;Guard&nbsp;Loader')||stristr($string,'Zend&nbsp;Optimizer'))
	{
		$st=1;
	}
	else
	{
		if(strlen($string)<120)
		{
			$st=-1;
		}
		else
		{
			$st=0;
		}
	}
	return $st;
}

//取得当前域名
function EGInfo_ReturnDomain(){
	$domain=$_SERVER['HTTP_HOST'];
	if(empty($domain))
	{
		return '';
	}
	return 'http://'.$domain;
}

//取得当前网页目录
function EGInfo_ReturnHttpPath($selffile='eginfo.php'){
	$domain=EGInfo_ReturnDomain();
	if(!$domain)
	{
		return '';
	}
	$fnlen=strlen($selffile);
	$phpself=$_SERVER['PHP_SELF'];
	if(!$phpself)
	{
		return '';
	}
	$yfnlen=strlen($phpself);
	$sublen=$yfnlen-$fnlen;
	$selfpath=substr($phpself,0,$sublen);
	$httpurl=$domain.$selfpath.'doc/docutf.html';
	return $httpurl;
}

?>