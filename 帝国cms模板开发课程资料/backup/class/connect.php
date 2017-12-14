<?php
error_reporting(E_ALL ^ E_NOTICE);
if(PHP_VERSION<'5.3.0')
{
	@set_magic_quotes_runtime(0);
}

define('InEmpireBak',TRUE);
define('EBAK_PATH',substr(dirname(__FILE__),0,-5));
define('MAGIC_QUOTES_GPC',function_exists('get_magic_quotes_gpc')&&@get_magic_quotes_gpc());

$php_outtime=0;
$editor=0;
$langr=array();
$ebaklang='';
$ebaklangchar='';
$langcharr=array();
$link='';
$empire='';
$phome_db_dbtype='';
$phome_db_ver='';
$phome_db_server='';
$phome_db_port='';
$phome_db_username='';
$phome_db_password='';
$phome_db_dbname='';
$baktbpre='';
$phome_db_char='';
$ebak_set_moredbserver='';
$ebak_set_selfserver_r=array();
$ebak_set_selfserverid=0;
$fun_r=array();
$message_r=array();
$ebak_ebma_open=0;
$ebak_ebma_path='';
$ebak_ebma_cklogin=0;

Ebak_CheckCloseEbakSys();

require_once EBAK_PATH.'lang/dbchar.php';
require_once EBAK_PATH.'class/config.php';

if(!defined('EmpireBakConfig'))
{
	exit();
}

Ebak_CheckUserAgent();

//超时设置
if($php_outtime)
{
	$php_outtime=(int)$php_outtime;
	@set_time_limit($php_outtime);
}

//Database
$defphome_db_dbtype=$phome_db_dbtype;
$defphome_db_ver=$phome_db_ver;
$defphome_db_server=$phome_db_server;
$defphome_db_port=$phome_db_port;
$defphome_db_username=$phome_db_username;
$defphome_db_password=$phome_db_password;
$defphome_db_dbname=$phome_db_dbname;
$defbaktbpre=$baktbpre;
$defphome_db_char=$phome_db_char;

//MysqlType
if(empty($phome_db_dbtype))
{
	if(!function_exists('mysql_connect'))
	{
		$phome_db_dbtype='mysqli';
	}
}

if($phome_db_dbtype=='mysqli')
{
	include(EBAK_PATH.'class/db_sqli.php');
}
else
{
	include(EBAK_PATH.'class/db_sql.php');
}

if(!defined('EmpireBakSetPage'))
{
	$ebak_set_selfserver_r=Ebak_SetUseMoreDbServer();
	$ebak_set_selfserverid=$ebak_set_selfserver_r['serverid'];
}

//数据库
function eDbConnectError(){
	global $editor,$fun_r;
	if(empty($fun_r['ConntConnectDb']))
	{
		if($editor==1){$a="../";}
		elseif($editor==2){$a="../../";}
		elseif($editor==3){$a="../../../";}
		else{$a="";}
		@include_once EBAK_PATH.LoadLang('f.php');
	}
	echo $fun_r['ConntConnectDb'];
	exit();
}

function db_connect(){
	global $phome_db_server,$phome_db_username,$phome_db_password,$phome_db_dbname,$phome_db_port,$phome_db_char,$phome_db_ver;
	$dblink=do_dbconnect($phome_db_server,$phome_db_port,$phome_db_username,$phome_db_password);
	return $dblink;
}

//设置编码
function DoSetDbChar($dbchar){
	if($dbchar&&$dbchar!='auto')
	{
		do_DoSetDbChar($dbchar);
	}
}

function return_dblink($query=''){
	$dblink=$GLOBALS['link'];
	return $dblink;
}

function db_close(){
	global $link;
	do_dbclose();
}

//取得mysql版本
function Ebak_GetMysqlVerForDb($selectdb=0){
	$getdbver=do_eGetDBVer($selectdb);
	return Ebak_ReturnMysqlVer($getdbver);
}

//返回mysql版本
function Ebak_ReturnMysqlVer($dbver){
	if(empty($dbver))
	{
		return '';
	}
	if($dbver>='6.0')
	{
		$dbver='6.0';
	}
	elseif($dbver>='5.0')
	{
		$dbver='5.0';
	}
	elseif($dbver>='4.1')
	{
		$dbver='4.1';
	}
	else
	{
		$dbver='4.0';
	}
	return $dbver;
}

//返回cookie前缀
function Ebak_ReturnCookieVarPre($ecms=0){
	global $phome_cookievarpre;
	$varpre=empty($ecms)?$phome_cookievarpre:'qebak_';
	return $varpre;
}

//设置COOKIE
function esetcookie($var,$val,$life=0,$ecms=0){
	global $phome_cookiedomain,$phome_cookiepath,$phome_cookievarpre;
	$varpre=Ebak_ReturnCookieVarPre($ecms);
	return setcookie($varpre.$var,$val,$life,$phome_cookiepath,$phome_cookiedomain);
}

//返回cookie
function getcvar($var,$ecms=0){
	global $phome_cookievarpre;
	$tvar=Ebak_ReturnCookieVarPre($ecms).$var;
	return $_COOKIE[$tvar];
}

//导入语言包
function LoadLang($file){
	global $ebaklang;
	return "lang/".$ebaklang."/pub/".$file;
}

//参数处理函数
function RepPostVar($val){
	$val=str_replace(" ","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=addslashes(stripSlashes($val));
	return $val;
}

//导入模板
function LoadAdminTemp($file){
	global $ebaklang;
	return "lang/".$ebaklang."/temp/".$file;
}

//使用编码
function HeaderIeChar(){
	global $ebaklangchar;
	@header('Content-Type: text/html; charset='.$ebaklangchar);
}

//返回语言
function ReturnUseEbakLang(){
	global $langcharr;
	$loginlangid=(int)getcvar('loginlangid',1);
	if($langcharr[$loginlangid])
	{
		$lr=explode(',',$langcharr[$loginlangid]);
		$r['lang']=$lr[0];
		$r['langchar']=$lr[1];
	}
	else
	{
		$r['lang']='gb';
		$r['langchar']='gbk';
	}
	return $r;
}

//返回使用的服务器
function Ebak_ReturnUseMoreDbServer($serverid=0){
	global $ebak_set_moredbserver;
	$ret_r=array();
	$ret_r['dbhost']='';
	if(empty($ebak_set_moredbserver))
	{
		return $ret_r;
	}
	$serverid=(int)$serverid;
	if(empty($serverid))
	{
		return $ret_r;
	}
	$rexp='|ebak|';
	$fexp='!ebak!';
	$dbr=explode($rexp,$ebak_set_moredbserver);
	$count=count($dbr);
	if(!$count)
	{
		return $ret_r;
	}
	$useid=$serverid-1;
	$dbfr=explode($fexp,$dbr[$useid]);
	if(empty($dbfr[1]))
	{
		return $ret_r;
	}
	$ret_r['dbver']=$dbfr[0];
	$ret_r['dbhost']=$dbfr[1];
	$ret_r['dbport']=$dbfr[2];
	$ret_r['dbuser']=$dbfr[3];
	$ret_r['dbpass']=$dbfr[4];
	$ret_r['dbname']=$dbfr[5];
	$ret_r['dbtbpre']=$dbfr[6];
	$ret_r['dbchar']=$dbfr[7];
	return $ret_r;
}

//返回使用的服务器
function Ebak_SetUseMoreDbServer(){
	global $phome_db_ver,$phome_db_server,$phome_db_port,$phome_db_username,$phome_db_password,$phome_db_dbname,$baktbpre,$phome_db_char;
	$dbr=array();
	$dbr['serverid']=0;
	$serverid=(int)getcvar('useserverid');
	if(empty($serverid))
	{
		return $dbr;
	}
	$dbr=Ebak_ReturnUseMoreDbServer($serverid);
	if(empty($dbr['dbhost']))
	{
		return $dbr;
	}
	$phome_db_ver=$dbr['dbver'];
	$phome_db_server=$dbr['dbhost'];
	$phome_db_port=$dbr['dbport'];
	$phome_db_username=$dbr['dbuser'];
	$phome_db_password=$dbr['dbpass'];
	$phome_db_dbname=$dbr['dbname'];
	$baktbpre=$dbr['dbtbpre'];
	$phome_db_char=$dbr['dbchar'];
	$dbr['serverid']=$serverid;
	return $dbr;
}

//返回多数据库服务器列表
function Ebak_ReturnMoreDbServerList($selfserverid){
	global $ebak_set_moredbserver;
	if(empty($ebak_set_moredbserver))
	{
		return '';
	}
	$rexp='|ebak|';
	$fexp='!ebak!';
	$r=explode($rexp,$ebak_set_moredbserver);
	$count=count($r);
	$dbservers='';
	for($i=0;$i<$count;$i++)
	{
		$fr=explode($fexp,$r[$i]);
		if(empty($fr[1]))
		{
			continue;
		}
		$serverid=$i+1;
		$servername=$fr[1];
		if($fr[5])
		{
			$servername.=' ('.$fr[5].')';
		}
		$selected='';
		if($serverid==$selfserverid)
		{
			$selected=' selected';
		}
		$no=$serverid;
		if($serverid<10&&$count>9)
		{
			$no=' '.$serverid;
		}
		$dbservers.="<option value='".$serverid."'".$selected.">".$no.": ".$servername."</option>";
	}
	return $dbservers;
}

//识别mysql接口(0都不支持,1支持mysql,2支持mysqli,3都支持)
function Ebak_ReturnMysqlConnectType(){
	$no=0;
	if(function_exists('mysql_connect'))
	{
		$no+=1;
	}
	if(function_exists('mysqli_connect'))
	{
		$no+=2;
	}
	return $no;
}

//是否关闭
function Ebak_CheckCloseEbakSys(){
	if(file_exists(EBAK_PATH.'closesys/empirebak.off'))
	{
		echo'<font color=red><b>EmpireBak is close!</b></font> You can delete or rename <b>/closesys/empirebak.off</b> to open.';
		exit();
	}
}

//验证agent信息
function Ebak_CheckUserAgent(){
	global $ebak_set_ckuseragent;
	if(empty($ebak_set_ckuseragent))
	{
		return '';
	}
	$userinfo=$_SERVER['HTTP_USER_AGENT'];
	$cr=explode('||',$ebak_set_ckuseragent);
	$count=count($cr);
	for($i=0;$i<$count;$i++)
	{
		if(empty($cr[$i]))
		{
			continue;
		}
		if(!strstr($userinfo,$cr[$i]))
		{
			//echo'Userinfo Error';
			exit();
		}
	}
}

//设置验证码
function Ebak_SetShowKey($varname,$val){
	global $ebak_set_ckrndvalthree;
	$time=time();
	$checkpass=md5($varname.md5($val.'-Empire-CMS-'.$time.'!-!'.$ebak_set_ckrndvalthree).$ebak_set_ckrndvalthree.'#p-H-o-m#e');
	$key=$time.','.$checkpass.',EmpireBak';
	esetcookie($varname,$key,0,1);
}

//检查验证码
function Ebak_CheckShowKey($varname,$postval){
	global $ebak_set_ckrndvalthree,$ebak_set_keytime;
	$r=explode(',',getcvar($varname,1));
	$cktime=(int)$r[0];
	$pass=$r[1];
	$val=$r[2];
	$time=time();
	if($cktime>$time||$time-$cktime>$ebak_set_keytime)
	{
		printerror('FailLoginKey',$_SERVER['HTTP_REFERER']);
	}
	if(empty($postval))
	{
		printerror('FailLoginKey',$_SERVER['HTTP_REFERER']);
	}
	$checkpass=md5($varname.md5($postval.'-Empire-CMS-'.$cktime.'!-!'.$ebak_set_ckrndvalthree).$ebak_set_ckrndvalthree.'#p-H-o-m#e');
	if($checkpass<>$pass)
	{
		printerror('FailLoginKey',$_SERVER['HTTP_REFERER']);
	}
}

//清空验证码
function Ebak_EmptyShowKey($varname){
	esetcookie($varname,'',0,1);
}

//返回当前域名
function Ebak_eReturnDomain(){
	$domain=$_SERVER['HTTP_HOST'];
	if(empty($domain))
	{
		return '';
	}
	return (Ebak_eCheckUseHttps()==1?'https://':'http://').$domain;
}

//验证是否使用https
function Ebak_eCheckUseHttps(){
	if($_SERVER['SERVER_PORT']==443)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//返回第四随机码
function Ebak_ReturnFourCheckRnd(){
	global $set_username,$ebak_set_ckrndvalfour;
	$fourcheck=md5($ebak_set_ckrndvalfour.'!E-b-A-k!'.$set_username);
	return $fourcheck;
}
?>