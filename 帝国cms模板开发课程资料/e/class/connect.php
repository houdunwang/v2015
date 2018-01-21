<?php
error_reporting(E_ALL ^ E_NOTICE);

define('InEmpireCMS',TRUE);
define('ECMS_PATH',substr(dirname(__FILE__),0,-7));
define('MAGIC_QUOTES_GPC',function_exists('get_magic_quotes_gpc')&&get_magic_quotes_gpc());
define('STR_IREPLACE',function_exists('str_ireplace'));

$ecms_config=array();
$ecms_adminloginr=array();
$ecms_hashur=array();
$emoreport_r=array();
$public_r=array();
$public_diyr=array();
$emod_pubr=array();
$etable_r=array();
$emod_r=array();
$notcj_r=array();
$fun_r=array();
$message_r=array();
$qmessage_r=array();
$enews_r=array();
$class_r=array();
$class_zr=array();
$class_tr=array();
$eyh_r=array();
$schalltb_r=array();
$level_r=array();
$r=array();
$addr=array();
$search='';
$start=0;
$addgethtmlpath='';
$string='';
$notcjnum=0;
$editor=0;
$ecms_gr=array();
$navinfor=array();
$pagefunr=array();
$navclassid='';
$navnewsid='';
$cjnewsurl='';
$formattxt='';
$link='';
$linkrd='';
$efileftp='';
$efileftp_fr=array();
$efileftp_dr=array();
$doetran=0;
$ecmsvar_mbr=array();
$ecms_config['sets']['selfmoreportid']=0;
$ecms_config['sets']['mainportpath']='';
$ecms_config['sets']['pagemustdt']=0;
$emoreport_r[1]['ppath']='';

require_once ECMS_PATH.'e/config/config.php';

if(!defined('EmpireCMSConfig'))
{
	exit();
}

//超时设置
if($public_r['php_outtime'])
{
	@set_time_limit($public_r['php_outtime']);
}

//页面编码
if($ecms_config['sets']['setpagechar']==1)
{
	if($ecms_config['sets']['pagechar']=='gb2312'||$ecms_config['sets']['pagechar']=='big5'||$ecms_config['sets']['pagechar']=='utf-8')
	{
		@header('Content-Type: text/html; charset='.$ecms_config['sets']['pagechar']);
	}
}

//时区
if(function_exists('date_default_timezone_set'))
{
	@date_default_timezone_set("PRC");
}

//禁止IP
eCheckAccessIp(0);
DoSafeCheckFromurl();

if(defined('EmpireCMSAdmin'))
{
	eCheckAccessIp(1);//禁止IP
	//FireWall
	if(!empty($ecms_config['fw']['eopen']))
	{
		DoEmpireCMSFireWall();
	}
	if(!empty($ecms_config['esafe']['ckhsession']))
	{
		session_start();
		define('EmpireCMSDefSession',TRUE);
	}
}
else
{
	if(!empty($public_r['closeqdt']))
	{
		echo $public_r['closeqdtmsg'];
		exit();
	}
}

if($ecms_config['sets']['selfmoreportid']>1)
{
	EcmsDefMoreport($ecms_config['sets']['selfmoreportid']);
}

//--------------- 数据库 ---------------

function db_connect(){
	global $ecms_config;
	$dblink=do_dbconnect($ecms_config['db']['dbserver'],$ecms_config['db']['dbport'],$ecms_config['db']['dbusername'],$ecms_config['db']['dbpassword'],$ecms_config['db']['dbname']);
	return $dblink;
}

function do_dbconnect($dbhost,$dbport,$dbusername,$dbpassword,$dbname){
	global $ecms_config;
	$dblocalhost=$dbhost;
	//端口
	if($dbport)
	{
		$dblocalhost.=':'.$dbport;
	}
	$dblink=@mysql_connect($dblocalhost,$dbusername,$dbpassword);
	if(!$dblink)
	{
		echo"Cann't connect to DB!";
		exit();
	}
	//编码
	if($ecms_config['db']['dbver']>='4.1')
	{
		$q='';
		if($ecms_config['db']['setchar'])
		{
			$q='character_set_connection='.$ecms_config['db']['setchar'].',character_set_results='.$ecms_config['db']['setchar'].',character_set_client=binary';
		}
		if($ecms_config['db']['dbver']>='5.0')
		{
			$q.=(empty($q)?'':',').'sql_mode=\'\'';
		}
		if($q)
		{
			@mysql_query('SET '.$q,$dblink);
		}
	}
	@mysql_select_db($dbname,$dblink);
	return $dblink;
}

function return_dblink($query){
	$dblink=$GLOBALS['link'];
	return $dblink;
}

//设置编码
function DoSetDbChar($dbchar){
	global $link;
	if($dbchar&&$dbchar!='auto')
	{
		//@mysql_query("set names '".$dbchar."';");
		@mysql_query('set character_set_connection='.$dbchar.',character_set_results='.$dbchar.',character_set_client=binary;',$link);
	}
}

function db_close(){
	global $link;
	if($link)
	{
		@mysql_close($link);
	}
}


//--------------- 公共 ---------------

//设置COOKIE
function esetcookie($var,$val,$life=0,$ecms=0){
	global $ecms_config;
	$varpre=empty($ecms)?$ecms_config['cks']['ckvarpre']:$ecms_config['cks']['ckadminvarpre'];
	return setcookie($varpre.$var,$val,$life,$ecms_config['cks']['ckpath'],$ecms_config['cks']['ckdomain']);
}

//返回cookie
function getcvar($var,$ecms=0){
	global $ecms_config;
	$tvar=empty($ecms)?$ecms_config['cks']['ckvarpre'].$var:$ecms_config['cks']['ckadminvarpre'].$var;
	return $_COOKIE[$tvar];
}

//错误提示
function printerror($error="",$gotourl="",$ecms=0,$noautourl=0,$novar=0){
	global $empire,$editor,$public_r,$ecms_config;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($ecms==1||$ecms==9)
	{
		$a=ECMS_PATH.'e/data/';
	}
	if(strstr($gotourl,"(")||empty($gotourl))
	{
		if(strstr($gotourl,"(-2"))
		{
			$gotourl_js="history.go(-2)";
			$gotourl="javascript:history.go(-2)";
		}
		else
		{
			$gotourl_js="history.go(-1)";
			$gotourl="javascript:history.go(-1)";
		}
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if(empty($error))
	{$error="DbError";}
	if($ecms==9)//前台弹出对话框
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==8)//后台弹出对话框
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==7)//前台弹出对话框并关闭窗口
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		echo"<script>alert('".$error."');window.close();</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==6)//后台弹出对话框并关闭窗口
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		echo"<script>alert('".$error."');window.close();</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==0)
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		@include($a."message.php");
	}
	else
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		@include($a."../message/index.php");
	}
	db_close();
	$empire=null;
	exit();
}

//错误提示2：直接文字
function printerror2($error='',$gotourl='',$ecms=0,$noautourl=0){
	global $empire,$public_r;
	if(strstr($gotourl,"(")||empty($gotourl))
	{
		if(strstr($gotourl,"(-2"))
		{
			$gotourl_js="history.go(-2)";
			$gotourl="javascript:history.go(-2)";
		}
		else
		{
			$gotourl_js="history.go(-1)";
			$gotourl="javascript:history.go(-1)";
		}
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if($ecms==9)//弹出对话框
	{
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
	}
	elseif($ecms==7)//弹出对话框并关闭窗口
	{
		echo"<script>alert('".$error."');window.close();</script>";
	}
	else
	{
		@include(ECMS_PATH.'e/message/index.php');
	}
	db_close();
	exit();
}

//ajax错误提示
function ajax_printerror($result='',$ajaxarea='ajaxarea',$error='',$ecms=0,$novar=0){
	global $empire,$editor,$public_r,$ecms_config;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($ecms==1)
	{
		$a=ECMS_PATH.'e/data/';
	}
	if($ecms==0)
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
	}
	else
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
	}
	if(empty($ajaxarea))
	{
		$ajaxarea='ajaxarea';
	}
	$ajaxarea=ehtmlspecialchars($ajaxarea,ENT_QUOTES);
	$string=$result.'|'.$ajaxarea.'|'.$error;
	echo $string;
	db_close();
	$empire=null;
	exit();
}

//直接转向
function printerrortourl($gotourl='',$error='',$sec=0){
	global $empire,$editor,$public_r,$ecms_config;
	echo'<meta http-equiv="refresh" content="'.$sec.';url='.$gotourl.'">'.$error;
	db_close();
	$empire=null;
	exit();
}

//编码转换
function DoIconvVal($code,$targetcode,$str,$inc=0){
	global $editor;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($inc)
	{
		@include_once(ECMS_PATH."e/class/doiconv.php");
	}
	$iconv=new Chinese($a);
	$str=$iconv->Convert($code,$targetcode,$str);
	return $str;
}

//初始化访问端
function EcmsDefMoreport($pid){
	global $public_r,$ecms_config,$emoreport_r;
	$pid=(int)$pid;
	if($pid<=1||!$emoreport_r[$pid]['pid'])
	{
		return '';
	}
	if($emoreport_r[$pid]['isclose'])
	{
		echo'This visit port is close!';
		exit();
	}
	$ecms_config['sets']['deftempid']=$emoreport_r[$pid]['tempgid'];
	$ecms_config['sets']['pagemustdt']=$emoreport_r[$pid]['mustdt'];
	$ecms_config['sets']['mainportpath']=$emoreport_r[1]['ppath'];
	if($emoreport_r[$pid]['closeadd'])
	{
		$public_r['addnews_ok']=$emoreport_r[$pid]['closeadd'];
	}
}

//重置为主访问端模板组ID
function Moreport_ResetMainTempGid(){
	global $ecms_config,$public_r,$emoreport_r;
	$pid=(int)$ecms_config['sets']['selfmoreportid'];
	if($pid<=1||!$emoreport_r[$pid]['pid'])
	{
		return '';
	}
	$ecms_config['sets']['deftempid']=$public_r['deftempid']?$public_r['deftempid']:1;
}

//返回是否强制动态页
function Moreport_ReturnMustDt(){
	global $ecms_config;
	return $ecms_config['sets']['pagemustdt'];
}

//返回是否强制动态页(加状态)
function Moreport_ReturnMustDtAnd(){
	global $ecms_config;
	if(defined('ECMS_SELFPATH')&&$ecms_config['sets']['pagemustdt'])
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//返回强制动态页状态
function Moreport_ReturnDtStatus($dt){
	global $ecms_config;
	if($ecms_config['sets']['pagemustdt'])
	{
		return 1;
	}
	else
	{
		return $dt;
	}
}

//返回内容页地址(访问端)
function Moreport_ReturnTitleUrl($classid,$id){
		$rewriter=eReturnRewriteInfoUrl($classid,$id,1);
		$titleurl=$rewriter['pageurl'];
		return $titleurl;
}

//返回栏目页地址(访问端)
function Moreport_ReturnClassUrl($classid){
	global $public_r,$class_r;
	if($class_r[$classid]['wburl'])
	{
		$classurl=$class_r[$classid]['wburl'];
	}
	else
	{
		$rewriter=eReturnRewriteClassUrl($classid,1);
		$classurl=$rewriter['pageurl'];
	}
	return $classurl;
}

//返回标题分类页地址(访问端)
function Moreport_ReturnInfoTypeUrl($typeid){
	$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
	$url=$rewriter['pageurl'];
	return $url;
}

//返回首页地址(访问端)
function Moreport_ReturnIndexUrl(){
	global $public_r;
	$file=$public_r['newsurl'].'index.php';
	return $file;
}

//模板表转换
function GetTemptb($temptb){
	global $public_r,$ecms_config,$dbtbpre;
	if(!empty($ecms_config['sets']['deftempid']))
	{
		$tempid=$ecms_config['sets']['deftempid'];
	}
	else
	{
		$tempid=$public_r['deftempid'];
	}
	if(!empty($tempid)&&$tempid!=1)
	{
		$en="_".$tempid;
	}
	return $dbtbpre.$temptb.$en;
}

//返回操作模板表
function GetDoTemptb($temptb,$gid){
	global $dbtbpre;
	if(!empty($gid)&&$gid!=1)
	{
		$en="_".$gid;
	}
	return $dbtbpre.$temptb.$en;
}

//返回当前使用模板组ID
function GetDoTempGid(){
	global $ecms_config,$public_r;
	if($ecms_config['sets']['deftempid'])
	{
		$gid=$ecms_config['sets']['deftempid'];
	}
	elseif($public_r['deftempid'])
	{
		$gid=$public_r['deftempid'];
	}
	else
	{
		$gid=1;
	}
	return $gid;
}

//导入语言包
function LoadLang($file){
	global $ecms_config;
	return "../data/language/".$ecms_config['sets']['elang']."/".$file;
}

//取得IP
function egetip(){
	if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')) 
	{
		$ip=getenv('HTTP_CLIENT_IP');
	} 
	elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown'))
	{
		$ip=getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown'))
	{
		$ip=getenv('REMOTE_ADDR');
	}
	elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown'))
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	$ip=RepPostVar(preg_replace("/^([\d\.]+).*/","\\1",$ip));
	return $ip;
}

//取得端口
function egetipport(){
	$ipport=(int)$_SERVER['REMOTE_PORT'];
	return $ipport;
}

//返回地址
function DoingReturnUrl($url,$from=''){
	if(empty($from))
	{
		return RepPostStrUrl($url);
	}
	elseif($from==9)
	{
		$from=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$url;
	}
	return RepPostStrUrl($from);
}

//htmlspecialchars处理
function ehtmlspecialchars($val,$flags=ENT_COMPAT){
	global $ecms_config;
	if(PHP_VERSION>='5.4.0')
	{
		if($ecms_config['sets']['pagechar']=='utf-8')
		{
			$char='UTF-8';
		}
		else
		{
			$char='ISO-8859-1';
		}
		$val=htmlspecialchars($val,$flags,$char);
	}
	else
	{
		$val=htmlspecialchars($val,$flags);
	}
	return $val;
}

//addslashes处理
function eaddslashes($val,$ckmq=1){
	if($ckmq==1&&MAGIC_QUOTES_GPC)
	{
		return $val;
	}
	$val=addslashes($val);
	return $val;
}

//addslashes处理
function eaddslashes2($val,$ckmq=1){
	if($ckmq==1&&MAGIC_QUOTES_GPC)
	{
		return addslashes($val);
	}
	$val=addslashes(addslashes($val));
	return $val;
}

//stripSlashes处理
function estripSlashes($val,$ckmq=1){
	if($ckmq==1&&!MAGIC_QUOTES_GPC)
	{
		return $val;
	}
	$val=stripSlashes($val);
	return $val;
}

//stripSlashes处理
function estripSlashes2($val,$ckmq=1){
	if($ckmq==1&&!MAGIC_QUOTES_GPC)
	{
		return stripSlashes($val);
	}
	$val=stripSlashes(stripSlashes($val));
	return $val;
}

//变量正数型处理
function RepPIntvar($val){
	$val=intval($val);
	if($val<0)
	{
		$val=0;
	}
	return $val;
}

//参数处理函数
function RepPostVar($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace("%","",$val);
	$val=str_replace(" ","",$val);
	$val=str_replace("\t","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	$val=RepPostStr($val,1);
	$val=addslashes($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//参数处理函数2
function RepPostVar2($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace("%","",$val);
	$val=str_replace("\t","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	$val=RepPostStr($val,1);
	$val=addslashes($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//处理提交字符
function RepPostStr($val,$ecms=0){
	$val=ehtmlspecialchars($val,ENT_QUOTES);
	if($ecms==0)
	{
		CkPostStrChar($val);
		$val=AddAddsData($val);
		//FireWall
		FWClearGetText($val);
	}
	return $val;
}

//处理提交字符2
function RepPostStr2($val){
	CkPostStrChar($val);
	$val=AddAddsData($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//处理地址
function RepPostStrUrl($val){
	$val=str_replace('&amp;','&',RepPostStr($val,1));
	return $val;
}

//处理提交字符
function hRepPostStr($val,$ecms=0){
	if($ecms==1)
	{
		$val=ehtmlspecialchars($val,ENT_QUOTES);
	}
	CkPostStrChar($val);
	$val=AddAddsData($val);
	return $val;
}

//处理提交字符2
function hRepPostStr2($val){
	CkPostStrChar($val);
	$val=AddAddsData($val);
	return $val;
}

//处理编码字符
function CkPostStrChar($val){
	if(substr($val,-1)=="\\")
	{
		exit();
	}
}

//返回转义
function egetzy($n='2'){
	if($n=='rn')
	{
		$str="\r\n";
	}
	elseif($n=='n')
	{
		$str="\n";
	}
	elseif($n=='r')
	{
		$str="\r";
	}
	elseif($n=='t')
	{
		$str="\t";
	}
	elseif($n=='syh')
	{
		$str="\\\"";
	}
	elseif($n=='dyh')
	{
		$str="\'";
	}
	else
	{
		for($i=0;$i<$n;$i++)
		{
			$str.="\\";
		}
	}
	return $str;
}

//验证字符是否空
function CheckValEmpty($val){
	return strlen($val)==0?1:0;
}

//返回ID列表
function eReturnInids($ids){
	if(empty($ids))
	{
		return 0;
	}
	$dh='';
	$retids='';
	$r=explode(',',$ids);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$r[$i];
		if(!$id)
		{
			continue;
		}
		$retids.=$dh.$id;
		$dh=',';
	}
	if(empty($retids))
	{
		return 0;
	}
	return $retids;
}

//数组返回ID列表
function eArrayReturnInids($r){
	$count=count($r);
	if(!$count)
	{
		return 0;
	}
	$dh='';
	$retids='';
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$r[$i];
		if(!$id)
		{
			continue;
		}
		$retids.=$dh.$id;
		$dh=',';
	}
	if(empty($retids))
	{
		return 0;
	}
	return $retids;
}

//取得表里的模型ID
function eGetTableModids($tid,$tbname){
	global $empire,$dbtbpre;
	$mids='';
	$where=$tid?"tid='$tid'":"tbname='$tbname'";
	$sql=$empire->query("select mid from {$dbtbpre}enewsmod where ".$where);
	while($r=$empire->fetch($sql))
	{
		$mids.=$dh.$r['mid'];
		$dh=',';
	}
	if(empty($mids))
	{
		$mids=0;
	}
	return $mids;
}

//替换模板变量字符
function RepTempvarPostStr($val){
	$val=str_replace('[!--','[!---',$val);
	return $val;
}

//替换模板变量字符
function RepTempvarPostStrT($val,$ispagef=0){
	if($ispagef==1)
	{
		$val=str_replace('[!--empirenews.page--]','[!!!-empirecms.page-!!]',$val);
	}
	$val=str_replace('[!--','&#091;!--',$val);
	if($ispagef==1)
	{
		$val=str_replace('[!!!-empirecms.page-!!]','[!--empirenews.page--]',$val);
	}
	return $val;
}

//取得文件扩展名
function GetFiletype($filename){
	$filer=explode(".",$filename);
	$count=count($filer)-1;
	return strtolower(".".RepGetFiletype($filer[$count]));
}

function RepGetFiletype($filetype){
	$filetype=str_replace('|','_',$filetype);
	$filetype=str_replace(',','_',$filetype);
	$filetype=str_replace('.','_',$filetype);
	return $filetype;
}

//取得文件名
function GetFilename($filename){
	if(strstr($filename,"\\"))
	{
		$exp="\\";
	}
	else
	{
		$exp='/';
	}
	$filer=explode($exp,$filename);
	$count=count($filer)-1;
	return $filer[$count];
}

//返回目录函数
function eReturnCPath($path,$ypath=''){
	if(strstr($path,'..')||strstr($path,"\\")||strstr($path,'%')||strstr($path,':'))
	{
		return $ypath;
	}
	return $path;
}

//验证文件名格式函数
function eReturnCkCFile($path){
	if(strstr($path,'..')||strstr($path,"\\")||strstr($path,'/')||strstr($path,'%')||strstr($path,':'))
	{
		return 0;
	}
	return 1;
}

//字符截取函数
function sub($string,$start=0,$length,$mode=false,$dot='',$rephtml=0){
	global $ecms_config;
	$strlen=strlen($string);
	if($strlen<=$length)
	{
		return $string;
	}

	if($rephtml==0)
	{
		$string = str_replace(array('&nbsp;','&amp;','&quot;','&lt;','&gt;','&#039;'), array(' ','&','"','<','>',"'"), $string);
	}

	$strcut = '';
	if(strtolower($ecms_config['sets']['pagechar']) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < $strlen) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	if($rephtml==0)
	{
		$strcut = str_replace(array('&','"','<','>',"'"), array('&amp;','&quot;','&lt;','&gt;','&#039;'), $strcut);
	}

	return $strcut.$dot;
}

//截取字数
function esub($string,$length,$dot='',$rephtml=0){
	return sub($string,0,$length,false,$dot,$rephtml);
}

//取得随机数
function make_password($pw_length){
	$low_ascii_bound=48;
	$upper_ascii_bound=122;
	$notuse=array(58,59,60,61,62,63,64,91,92,93,94,95,96);
	while($i<$pw_length)
	{
		if(PHP_VERSION<'4.2.0')
		{
			mt_srand((double)microtime()*1000000);
		}
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//取得随机数(数字)
function no_make_password($pw_length){
	$low_ascii_bound=48;
	$upper_ascii_bound=57;
	$notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
	while($i<$pw_length)
	{
		if(PHP_VERSION<'4.2.0')
		{
			mt_srand((double)microtime()*1000000);
		}
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//颜色转RGB
function ToReturnRGB($rgb){
	$rgb=str_replace('#','',ehtmlspecialchars($rgb));
    return array(
        base_convert(substr($rgb,0,2),16,10),
        base_convert(substr($rgb,2,2),16,10),
        base_convert(substr($rgb,4,2),16,10)
    );
}

//前台分页
function page1($num,$line,$page_line,$start,$page,$search){
	global $fun_r;
	if($num<=$line)
	{
		return '';
	}
	$search=RepPostStr($search,1);
	$url=eReturnSelfPage(0).'?page';
	$snum=2;//最小页数
	$totalpage=ceil($num/$line);//取得总页数
	$firststr='<a title="'.$fun_r['trecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//上一页
	if($page<>0)
	{
		$toppage='<a href="'.$url.'=0'.$search.'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="'.$url.'='.$pagepr.$search.'">'.$fun_r['pripage'].'</a>';
	}
	//下一页
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.$url.'='.$pagenex.$search.'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.$url.'='.($totalpage-1).$search.'">'.$fun_r['lastpage'].'</a>';
	}
	$starti=$page-$snum<0?0:$page-$snum;
	$no=0;
	for($i=$starti;$i<$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		else
		{
			$is_1='<a href="'.$url.'='.$i.$search.'">';
			$is_2="</a>";
		}
		$pagenum=$i+1;
		$returnstr.="&nbsp;".$is_1.$pagenum.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	return $returnstr;
}

//---------- 伪静态 ----------

//返回内容伪静态
function eReturnRewriteInfoUrl($classid,$id,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteinfo']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/ShowInfo.php?classid=$classid&id=$id";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--id--]','[!--page--]'),array($classid,$id,0),$public_r['rewriteinfo']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--id--]'),array($classid,$id),$public_r['rewriteinfo']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//返回栏目列表伪静态
function eReturnRewriteClassUrl($classid,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteclass']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/ListInfo/?classid=$classid";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--page--]'),array($classid,0),$public_r['rewriteclass']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--classid--]',$classid,$public_r['rewriteclass']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//返回标题分类列表伪静态
function eReturnRewriteTitleTypeUrl($ttid,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteinfotype']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/InfoType/?ttid=$ttid";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--ttid--]','[!--page--]'),array($ttid,0),$public_r['rewriteinfotype']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--ttid--]',$ttid,$public_r['rewriteinfotype']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//返回TAGS列表伪静态
function eReturnRewriteTagsUrl($tagid,$tagname,$ecms=0){
	global $public_r;
	$tagname=urlencode($tagname);
	if(empty($public_r['rewritetags']))
	{
		$r['pageurl']=$public_r['newsurl']."e/tags/?tagname=".$tagname;
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--tagname--]','[!--page--]'),array($tagname,0),$public_r['rewritetags']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--tagname--]',$tagname,$public_r['rewritetags']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//返回评论列表伪静态
function eReturnRewritePlUrl($classid,$id,$doaction='doinfo',$myorder=0,$tempid=0,$ecms=0){
	global $public_r;
	if(empty($public_r['rewritepl']))
	{
		if($doaction=='dozt')
		{
			$r['pageurl']=$public_r['plurl']."?doaction=dozt&classid=$classid".($myorder?'&myorder='.$myorder:'').($tempid?'&tempid='.$tempid:'');
		}
		else
		{
			$r['pageurl']=$public_r['plurl']."?classid=$classid&id=$id".($myorder?'&myorder='.$myorder:'').($tempid?'&tempid='.$tempid:'');
		}
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--doaction--]','[!--classid--]','[!--id--]','[!--page--]','[!--myorder--]','[!--tempid--]'),array($doaction,$classid,$id,0,$myorder,$tempid),$public_r['rewritepl']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--doaction--]','[!--classid--]','[!--id--]','[!--myorder--]','[!--tempid--]'),array($doaction,$classid,$id,$myorder,$tempid),$public_r['rewritepl']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//伪静态链接地址中转
function eReturnRewriteLink($type,$classid,$id){
	if($type=='infopage')//信息页
	{
		$url=eReturnRewriteInfoUrl($classid,$id);
	}
	elseif($type=='ttpage')//标题分类页
	{
		$url=eReturnRewriteTitleTypeUrl($classid);
	}
	elseif($type=='tagspage')//Tags列表页
	{
		$url=eReturnRewriteTagsUrl($classid,$id);
	}
	else//栏目页
	{
		$url=eReturnRewriteClassUrl($classid);
	}
	return $url;
}

//伪静态替换分页号
function eReturnRewritePageLink($r,$page){
	//动静
	$truepage=$page+1;
	if($r['repagenum']&&$truepage<=$r['repagenum'])
	{
		//文件名
		if(empty($r['dofile']))
		{
			$r['dofile']='index';
		}
		$url=$r['dolink'].$r['dofile'].($truepage==1?'':'_'.$truepage).$r['dotype'];
		return $url;
	}
	if($r['rewrite']==1)
	{
		$url=str_replace('[!--page--]',$page,$r['pageurl']);
	}
	else
	{
		$url=$r['pageurl'].'&page='.$page;
	}
	return $url;
}

//伪静态替换分页号(静态)
function eReturnRewritePageLink2($r,$page){
	if($r['rewrite']==1)
	{
		$url=str_replace('[!--page--]',$page-1,$r['pageurl']);
	}
	else
	{
		$url=$r['pageurl'].'&page='.($page-1);
	}
	return $url;
}

//前台分页(伪静态)
function InfoUsePage($num,$line,$page_line,$start,$page,$search,$add){
	global $fun_r;
	if($num<=$line)
	{
		return '';
	}
	$snum=2;//最小页数
	$totalpage=ceil($num/$line);//取得总页数
	$firststr='<a title="'.$fun_r['trecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//上一页
	if($page<>0)
	{
		$toppage='<a href="'.eReturnRewritePageLink($add,0).'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="'.eReturnRewritePageLink($add,$pagepr).'">'.$fun_r['pripage'].'</a>';
	}
	//下一页
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.eReturnRewritePageLink($add,$pagenex).'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.eReturnRewritePageLink($add,$totalpage-1).'">'.$fun_r['lastpage'].'</a>';
	}
	$starti=$page-$snum<0?0:$page-$snum;
	$no=0;
	for($i=$starti;$i<$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		else
		{
			$is_1='<a href="'.eReturnRewritePageLink($add,$i).'">';
			$is_2="</a>";
		}
		$pagenum=$i+1;
		$returnstr.="&nbsp;".$is_1.$pagenum.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	return $returnstr;
}

//时间转换函数
function to_time($datetime){
	if(strlen($datetime)==10)
	{
		$datetime.=" 00:00:00";
	}
	$r=explode(" ",$datetime);
	$t=explode("-",$r[0]);
	$k=explode(":",$r[1]);
	$dbtime=@mktime($k[0],$k[1],$k[2],$t[1],$t[2],$t[0]);
	return $dbtime;
}

//时期转日期
function date_time($time,$format="Y-m-d H:i:s"){
	$threadtime=date($format,$time);
	return $threadtime;
}

//格式化日期
function format_datetime($newstime,$format){
	if($newstime=="0000-00-00 00:00:00")
	{return $newstime;}
	$time=is_numeric($newstime)?$newstime:to_time($newstime);
	$newdate=date_time($time,$format);
	return $newdate;
}

//时间转换函数
function to_date($date){
	$date.=" 00:00:00";
	$r=explode(" ",$date);
	$t=explode("-",$r[0]);
	$k=explode(":",$r[1]);
	$dbtime=@mktime($k[0],$k[1],$k[2],$t[1],$t[2],$t[0]);
	return $dbtime;
}

//选择时间
function ToChangeTime($time,$day){
	$truetime=$time-$day*24*3600;
	$date=date_time($truetime,"Y-m-d");
	return $date;
}

//删除文件
function DelFiletext($filename){
	@unlink($filename);
}

//取得文件内容
function ReadFiletext($filepath){
	$filepath=trim($filepath);
	$htmlfp=@fopen($filepath,"r");
	//远程
	if(strstr($filepath,"://"))
	{
		while($data=@fread($htmlfp,500000))
	    {
			$string.=$data;
		}
	}
	//本地
	else
	{
		$string=@fread($htmlfp,@filesize($filepath));
	}
	@fclose($htmlfp);
	return $string;
}

//写文件
function WriteFiletext($filepath,$string){
	global $public_r;
	$string=stripSlashes($string);
	$fp=@fopen($filepath,"w");
	@fputs($fp,$string);
	@fclose($fp);
	if(empty($public_r[filechmod]))
	{
		@chmod($filepath,0777);
	}
}

//写文件
function WriteFiletext_n($filepath,$string){
	global $public_r;
	$fp=@fopen($filepath,"w");
	@fputs($fp,$string);
	@fclose($fp);
	if(empty($public_r[filechmod]))
	{
		@chmod($filepath,0777);
	}
}

//标题属性后
function DoTitleFont($titlefont,$title){
	if(empty($titlefont))
	{
		return $title;
	}
	$r=explode(',',$titlefont);
	if(!empty($r[0]))
	{
		$title="<font color='".$r[0]."'>".$title."</font>";
	}
	if(empty($r[1]))
	{return $title;}
	//粗体
	if(strstr($r[1],"b"))
	{$title="<strong>".$title."</strong>";}
	//斜体
	if(strstr($r[1],"i"))
	{$title="<i>".$title."</i>";}
	//删除线
	if(strstr($r[1],"s"))
	{$title="<s>".$title."</s>";}
	return $title;
}

//返回头条级别名称
function ReturnFirsttitleNameList($firsttitle,$isgood){
	global $empire,$dbtbpre;
	$pubr=$empire->fetch1("select firsttitlename,isgoodname from {$dbtbpre}enewspublic limit 1");
	//头条
	$first_r=explode("|",$pubr['firsttitlename']);
	$ftn='';
	for($i=1;$i<=9;$i++)
	{
		$selected='';
		if($i==$firsttitle)
		{
			$selected=' selected';
		}
		$ftn.='<option value="'.$i.'"'.$selected.'>'.$first_r[$i-1].'</option>';
	}
	//推荐
	$good_r=explode("|",$pubr['isgoodname']);
	$gn='';
	for($gi=1;$gi<=9;$gi++)
	{
		$selected='';
		if($gi==$isgood)
		{
			$selected=' selected';
		}
		$gn.='<option value="'.$gi.'"'.$selected.'>'.$good_r[$gi-1].'</option>';
	}
	$ret_r['ftname']=$ftn;
	$ret_r['ftr']=$first_r;
	$ret_r['igname']=$gn;
	$ret_r['igr']=$good_r;
	return $ret_r;
}

//替换全角逗号
function DoReplaceQjDh($text){
	return str_replace('，',',',$text);
}

//建立目录函数
function DoMkdir($path){
	global $public_r;
	//不存在则建立
	if(!file_exists($path))
	{
		//安全模式
		if($public_r[phpmode])
		{
			$pr[0]=$path;
			FtpMkdir($ftpid,$pr,0777);
			$mk=1;
		}
		else
		{
			$mk=@mkdir($path,0777);
			@chmod($path,0777);
		}
		if(empty($mk))
		{
			echo str_replace(ECMS_PATH,'/',$path);
			printerror("CreatePathFail","history.go(-1)");
		}
	}
	return true;
}

//建立上级目录
function DoFileMkDir($file){
	$path=dirname($file.'empirecms.txt');
	DoMkdir($path);
}

//设置上传文件权限
function DoChmodFile($file){
	global $public_r;
	if($public_r['filechmod']!=1)
	{
		@chmod($file,0777);
	}
}

//替换斜扛
function DoRepFileXg($file){
	$file=str_replace("\\","/",$file);
	return $file;
}

//返回栏目链接字符串
function ReturnClassLink($classid){
	global $class_r,$public_r,$fun_r;
	if(empty($class_r[$classid][featherclass]))
	{$class_r[$classid][featherclass]="|";}
	$r=explode("|",$class_r[$classid][featherclass].$classid."|");
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	for($i=1;$i<count($r)-1;$i++)
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			$class_r[$r[$i]][listdt]=1;
		}
		//静态列表
		if(empty($class_r[$r[$i]][listdt]))
		{
			//无绑定域名
			if(empty($class_r[$r[$i]][classurl]))
			{$url=$public_r[newsurl].$class_r[$r[$i]][classpath]."/";}
			else
			{$url=$class_r[$r[$i]][classurl];}
		}
		else
		{
			$rewriter=eReturnRewriteClassUrl($r[$i],1);
			$url=$rewriter['pageurl'];
		}
		$string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_r[$r[$i]][classname]."</a>";
	}
	return $string;
}

//返回专题链接字符串
function ReturnZtLink($ztid){
	global $class_zr,$public_r,$fun_r;
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	//无绑定域名
	if(empty($class_zr[$ztid][zturl]))
	{$url=$public_r[newsurl].$class_zr[$ztid][ztpath]."/";}
	else
	{$url=$class_zr[$ztid][zturl];}
    $string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_zr[$ztid][ztname]."</a>";
	return $string;
}

//返回标题分类链接字符串
function ReturnInfoTypeLink($typeid){
	global $class_tr,$public_r,$fun_r;
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	//moreport
	if(Moreport_ReturnMustDt())
	{
		$class_tr[$typeid]['listdt']=1;
	}
	if($class_tr[$typeid]['listdt'])
	{
		$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
		$url=$rewriter['pageurl'];
	}
	else
	{
		$url=$public_r[newsurl].$class_tr[$typeid][tpath]."/";
	}
    $string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_tr[$typeid][tname]."</a>";
	return $string;
}

//返回单页链接字符串
function ReturnUserPLink($title,$titleurl){
	global $public_r,$fun_r;
	$string='<a href="'.ReturnSiteIndexUrl().'">'.$fun_r['index'].'</a>&nbsp;'.$public_r[navfh].'&nbsp;'.$title;
	return $string;
}

//返回标题链接(静态)
function sys_ReturnBqTitleLink($r){
	global $public_r;
	if(empty($r['isurl']))
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			return Moreport_ReturnTitleUrl($r['classid'],$r['id']);
		}
		return $r['titleurl'];
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl'].'e/public/jump/?classid='.$r['classid'].'&id='.$r['id'];
		}
		return $titleurl;
	}
}

//返回标题链接(动态)
function sys_ReturnBqTitleLinkDt($r){
	global $public_r,$class_r;
	if(empty($r['isurl']))
	{
		if($class_r[$r[classid]][showdt]==1)//动态生成
		{
			$titleurl=$public_r[newsurl]."e/action/ShowInfo/?classid=$r[classid]&id=$r[id]";
			return $titleurl;
		}
		elseif($class_r[$r[classid]][showdt]==2)
		{
			$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],1);
			$titleurl=$rewriter['pageurl'];
			return $titleurl;
		}
		if($class_r[$r[classid]][filename]==3)
		{
			$filename=ReturnInfoSPath($r[filename]);
		}
		else
		{
			$filetype=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
			$filename=$r[filename].$filetype;
		}
		$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
		$newspath=empty($r[newspath])?'':$r[newspath]."/";
		if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//域名
		{
			$titleurl=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
		}
		else
		{
			$titleurl=$public_r[newsurl].$iclasspath.$newspath.$filename;
		}
	}
	else
	{
		$titleurl=$r['titleurl'];
	}
	return addslashes($titleurl);
}

//中转取得信息地址
function GotoGetTitleUrl($classid,$id,$newspath,$filename,$groupid,$isurl,$titleurl){
	$r['classid']=$classid;
	$r['id']=$id;
	$r['newspath']=$newspath;
	$r['filename']=$filename;
	$r['groupid']=$groupid;
	$r['isurl']=$isurl;
	$r['titleurl']=$titleurl;
	$infourl=sys_ReturnBqTitleLinkDt($r);
	return $infourl;
}

//返回标题链接(触发)
function sys_ReturnBqAutoTitleLink($r){
	global $public_r,$class_r;
	if(empty($r['isurl']))
	{
		if($class_r[$r[classid]][showdt]==2)
		{
			$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],1);
			$titleurl=$rewriter['pageurl'];
			return $titleurl;
		}
		if($class_r[$r[classid]][filename]==3)
		{
			$filename=ReturnInfoSPath($r[filename]);
		}
		else
		{
			$filetype=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
			$filename=$r[filename].$filetype;
		}
		$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
		$newspath=empty($r[newspath])?'':$r[newspath]."/";
		if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//域名
		{
			$titleurl=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
		}
		else
		{
			$titleurl=$public_r[newsurl].$iclasspath.$newspath.$filename;
		}
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl']."e/public/jump/?classid=".$r['classid']."&id=".$r['id'];
		}
	}
	return $titleurl;
}

//返回内容页地址前缀
function ReturnInfoPageQz($r){
	global $public_r,$class_r;
	$ret_r['titleurl']='';
	$ret_r['filetype']='';
	$ret_r['nametype']=0;
	//动态页面
	if($class_r[$r[classid]][showdt]==2)
	{
		$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],0);
		$ret_r['pageurl']=$rewriter['pageurl'];
		$ret_r['rewrite']=$rewriter['rewrite'];
		$ret_r['titleurl']=$rewriter['pageurl'];
		$ret_r['filetype']='';
		$ret_r['nametype']=1;
		return $ret_r;
	}
	//静态页面
	$ret_r['filetype']=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
	$filename=$r[filename];
	$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
	$newspath=empty($r[newspath])?'':$r[newspath]."/";
	if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//域名
	{
		$ret_r['titleurl']=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
	}
	else
	{
		$ret_r['titleurl']=$public_r[newsurl].$iclasspath.$newspath.$filename;
	}
	return $ret_r;
}

//返回栏目链接
function sys_ReturnBqClassname($r,$have_class=0){
	global $public_r,$class_r;
	if($have_class)
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			$class_r[$r[classid]][listdt]=1;
		}
		//外部栏目
		if($class_r[$r[classid]][wburl])
		{
			$classurl=$class_r[$r[classid]][wburl];
		}
		//动态列表
		elseif($class_r[$r[classid]][listdt])
		{
			$rewriter=eReturnRewriteClassUrl($r['classid'],1);
			$classurl=$rewriter['pageurl'];
		}
		elseif($class_r[$r[classid]][classurl])
		{
			$classurl=$class_r[$r[classid]][classurl];
		}
		else
		{
			$classurl=$public_r[newsurl].$class_r[$r[classid]][classpath]."/";
		}
		if(empty($class_r[$r[classid]][bname]))
		{$classname=$class_r[$r[classid]][classname];}
		else
		{$classname=$class_r[$r[classid]][bname];}
		$myadd="[<a href=".$classurl.">".$classname."</a>]";
		//只返回链接
		if($have_class==9)
		{$myadd=$classurl;}
	}
	else
	{$myadd="";}
	return $myadd;
}

//返回专题链接
function sys_ReturnBqZtname($r){
	global $public_r,$class_zr;
	if($class_zr[$r[ztid]][zturl])
	{
		$zturl=$class_zr[$r[ztid]][zturl];
    }
	else
	{
		$zturl=$public_r[newsurl].$class_zr[$r[ztid]][ztpath]."/";
    }
	return $zturl;
}

//返回标题分类链接
function sys_ReturnBqInfoTypeUrl($typeid){
	global $public_r,$class_tr;
	//moreport
	if(Moreport_ReturnMustDt())
	{
		$class_tr[$typeid]['listdt']=1;
	}
	if($class_tr[$typeid]['listdt'])
	{
		$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
		$url=$rewriter['pageurl'];
	}
	else
	{
		$url=$public_r['newsurl'].$class_tr[$typeid]['tpath']."/";
	}
	return $url;
}

//文件大小格式转换
function ChTheFilesize($size){
	if($size>=1024*1024)//MB
	{
		$filesize=number_format($size/(1024*1024),2,'.','')." MB";
	}
	elseif($size>=1024)//KB
	{
		$filesize=number_format($size/1024,2,'.','')." KB";
	}
	else
	{
		$filesize=$size." Bytes";
	}
	return $filesize;
}

//取得表记录
function eGetTableRowNum($tbname){
	global $empire,$dbtbpre;
	$total_r=$empire->fetch1("SHOW TABLE STATUS LIKE '".$tbname."';");
	return $total_r['Rows'];
}

//更新栏目信息数
function AddClassInfos($classid,$addallstr,$addstr,$checked=1){
	global $empire,$dbtbpre;
	$updatestr='';
	$dh='';
	if($addallstr)
	{
		$updatestr.='allinfos=allinfos'.$addallstr;
		$dh=',';
	}
	if($addstr)
	{
		if($checked)
		{
			$updatestr.=$dh.'infos=infos'.$addstr;
		}
	}
	if(empty($updatestr))
	{
		return '';
	}
	$empire->query("update {$dbtbpre}enewsclass set ".$updatestr." where classid='$classid' limit 1");
}

//返回栏目信息数
function ReturnClassInfoNum($cr,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if($cr['islast'])
	{
		$num=$ecms==0?$cr['infos']:$cr['allinfos'];
	}
	else
	{
		$f=$ecms==0?'infos':'allinfos';
		$num=$empire->gettotal("select sum(".$f.") as total from {$dbtbpre}enewsclass where ".ReturnClass($class_r[$cr[classid]][sonclass]));
		$num=(int)$num;
	}
	return $num;
}

//重置栏目信息数
function ResetClassInfos($classid){
	global $empire,$dbtbpre,$class_r;
	$infos=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid]['tbname']." where classid='$classid'");
	$checkinfos=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid]['tbname']."_check where classid='$classid'");
	$allinfos=$infos+$checkinfos;
	$empire->query("update {$dbtbpre}enewsclass set allinfos='$allinfos',infos='$infos' where classid='$classid' limit 1");
}

//单信息评论数
function UpdateSingleInfoPlnum($classid,$id,$checked=1){
	global $empire,$dbtbpre,$class_r;
	$tbname=$class_r[$classid]['tbname'];
	if(empty($tbname))
	{
		return '';
	}
	$infotb=ReturnInfoMainTbname($tbname,$checked);
	$r=$empire->fetch1("select id,restb,plnum from ".$infotb." where id='$id' limit 1");
	if(empty($r['restb']))
	{
		return '';
	}
	$pubid=ReturnInfoPubid($classid,$id);
	$plnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewspl_".$r['restb']." where pubid='$pubid' limit 1");
	if($plnum==$r['plnum'])
	{
		return '';
	}
	$empire->query("update ".$infotb." set plnum='$plnum' where id='$id' limit 1");
}

//信息数统计加1
function DoUpdateAddDataNum($type='info',$stb,$addnum=1){
	global $empire,$dbtbpre;
	if($type=='info')//信息
	{
		$lasttimef='lasttimeinfo';
		$lastnumf='lastnuminfo';
		$lastnumtbf='lastnuminfotb';
		$todaytimef='todaytimeinfo';
		$todaynumf='todaynuminfo';
		$yesterdaynumf='yesterdaynuminfo';
		$sqladdf=',todaytimeinfo,todaytimepl,todaynuminfo,todaynumpl';
	}
	elseif($type=='pl')//评论
	{
		$lasttimef='lasttimepl';
		$lastnumf='lastnumpl';
		$lastnumtbf='lastnumpltb';
		$todaytimef='todaytimepl';
		$todaynumf='todaynumpl';
		$yesterdaynumf='yesterdaynumpl';
		$sqladdf=',todaytimepl,todaytimeinfo,todaynuminfo,todaynumpl';
	}
	else
	{
		return '';
	}
	$sqladdupdate='';
	$time=time();
	$pur=$empire->fetch1("select ".$lasttimef.",".$lastnumtbf.$sqladdf." from {$dbtbpre}enewspublic_update limit 1");
	if($stb)
	{
		if(empty($pur[$lastnumtbf]))
		{
			$pur[$lastnumtbf]='|';
		}
		if(strstr($pur[$lastnumtbf],'|'.$stb.','))
		{
			$numr=explode('|'.$stb.',',$pur[$lastnumtbf]);
			$numrt=explode('|',$numr[1]);
			$newnum=$numrt[0]+$addnum;
			$tbnums=str_replace('|'.$stb.','.$numrt[0].'|','|'.$stb.','.$newnum.'|',$pur[$lastnumtbf]);
		}
		else
		{
			$tbnums=$pur[$lastnumtbf].$stb.','.$addnum.'|';
		}
		$sqladdupdate.=",".$lastnumtbf."='".$tbnums."'";
	}
	//今日统计
	if($sqladdf)
	{
		$todaydate=date('Y-m-d');
		if($todaydate<>date('Y-m-d',$pur['todaytimeinfo'])||$todaydate<>date('Y-m-d',$pur['todaytimepl']))
		{
			if($type=='info')
			{
				$todaynuminfo=$addnum;
				$todaynumpl=0;
			}
			else
			{
				$todaynuminfo=0;
				$todaynumpl=$addnum;
			}
			$yesterdaynuminfo=$pur['todaynuminfo'];
			$yesterdaynumpl=$pur['todaynumpl'];
			if($todaydate<>date('Y-m-d',$pur['todaytimeinfo']+24*3600))
			{
				$yesterdaynuminfo=0;
			}
			if($todaydate<>date('Y-m-d',$pur['todaytimepl']+24*3600))
			{
				$yesterdaynumpl=0;
			}
			$sqladdupdate.=",todaytimeinfo='$time',todaytimepl='$time',todaynuminfo='$todaynuminfo',todaynumpl='$todaynumpl',yesterdaynuminfo='$yesterdaynuminfo',yesterdaynumpl='$yesterdaynumpl'";
		}
		else
		{
			$sqladdupdate.=",".$todaynumf."=".$todaynumf."+".$addnum;
		}
	}
	$empire->query("update {$dbtbpre}enewspublic_update set ".$lastnumf."=".$lastnumf."+".$addnum.$sqladdupdate." limit 1");
}

//重置信息数统计
function DoResetAddDataNum($type='info'){
	global $empire,$dbtbpre;
	if($type=='info')//信息
	{
		$lasttimef='lasttimeinfo';
		$lastnumf='lastnuminfo';
		$lastnumtbf='lastnuminfotb';
	}
	elseif($type=='pl')//评论
	{
		$lasttimef='lasttimepl';
		$lastnumf='lastnumpl';
		$lastnumtbf='lastnumpltb';
	}
	else
	{
		return '';
	}
	$time=time();
	$empire->query("update {$dbtbpre}enewspublic_update set ".$lasttimef."='$time',".$lastnumf."=0,".$lastnumtbf."='' limit 1");
}

//更新昨日信息数统计
function DoUpdateYesterdayAddDataNum(){
	global $empire,$dbtbpre;
	$pur=$empire->fetch1("select * from {$dbtbpre}enewspublic_update limit 1");
	$todaydate=date('Y-m-d');
	if($todaydate==date('Y-m-d',$pur['todaytimeinfo'])&&$todaydate==date('Y-m-d',$pur['todaytimepl']))
	{
		return '';
	}
	$yesterdaynuminfo=$pur['todaynuminfo'];
	$yesterdaynumpl=$pur['todaynumpl'];
	if($todaydate<>date('Y-m-d',$pur['todaytimeinfo']+24*3600))
	{
		$yesterdaynuminfo=0;
	}
	if($todaydate<>date('Y-m-d',$pur['todaytimepl']+24*3600))
	{
		$yesterdaynumpl=0;
	}
	$time=time();
	$empire->query("update {$dbtbpre}enewspublic_update set todaytimeinfo='$time',todaytimepl='$time',todaynuminfo=0,yesterdaynuminfo='$yesterdaynuminfo',todaynumpl=0,yesterdaynumpl='$yesterdaynumpl' limit 1");
}

//返回栏目自定义字段内容
function ReturnClassAddField($classid,$f){
	global $empire,$dbtbpre,$navclassid;
	if(empty($classid))
	{
		$classid=$navclassid;
	}
	$fr=$empire->fetch1("select ".$f." from {$dbtbpre}enewsclassadd where classid='$classid' limit 1");
	if(strstr($f,','))
	{
		return $fr;
	}
	else
	{
		return $fr[$f];
	}
}

//返回专题自定义字段内容
function ReturnZtAddField($classid,$f){
	global $empire,$dbtbpre,$navclassid;
	if(empty($classid))
	{
		$classid=$navclassid;
	}
	$fr=$empire->fetch1("select ".$f." from {$dbtbpre}enewsztadd where ztid='$classid' limit 1");
	if(strstr($f,','))
	{
		return $fr;
	}
	else
	{
		return $fr[$f];
	}
}

//返回扩展变量值
function ReturnPublicAddVar($myvar){
	global $empire,$dbtbpre;
	if(strstr($myvar,','))
	{
		$myvr=explode(',',$myvar);
		$count=count($myvr);
		for($i=0;$i<$count;$i++)
		{
			$v=$myvr[$i];
			$vr=$empire->fetch1("select varvalue from {$dbtbpre}enewspubvar where myvar='$v' limit 1");
			$ret_vr[$v]=$vr['varvalue'];
		}
		return $ret_vr;
	}
	else
	{
		$vr=$empire->fetch1("select varvalue from {$dbtbpre}enewspubvar where myvar='$myvar' limit 1");
		return $vr['varvalue'];
	}
}

//返回排序字段
function ReturnDoOrderF($mid,$orderby,$myorder){
	global $emod_r;
	$orderby=str_replace(',','',$orderby);
	$orderf=',newstime,id,onclick,totaldown,plnum';
	if(!empty($emod_r[$mid]['orderf']))
	{
		$orderf.=$emod_r[$mid]['orderf'];
	}
	else
	{
		$orderf.=',';
	}
	if(strstr($orderf,','.$orderby.','))
	{
		$rr['returnorder']=$orderby;
		$rr['returnf']=$orderby;
	}
	else
	{
		$rr['returnorder']='newstime';
		$rr['returnf']='newstime';
	}
	if(empty($myorder))
	{
		$rr['returnorder'].=' desc';
	}
	return $rr;
}

//返回置顶
function ReturnSetTopSql($ecms){
	global $public_r;
	if(empty($public_r['settop']))
	{
		return '';
	}
	$top='istop desc,';
	if($ecms=='list')
	{
		if($public_r['settop']==1||$public_r['settop']==4||$public_r['settop']==5||$public_r['settop']==6)
		{
			return $top;
		}
	}
	elseif($ecms=='bq')
	{
		if($public_r['settop']==2||$public_r['settop']==4||$public_r['settop']==5||$public_r['settop']==7)
		{
			return $top;
		}
	}
	elseif($ecms=='js')
	{
		if($public_r['settop']==3||$public_r['settop']==4||$public_r['settop']==6||$public_r['settop']==7)
		{
			return $top;
		}
	}
	return '';
}

//返回优化方案SQL
function ReturnYhSql($yhid,$yhvar,$ecms=0){
	global $eyh_r;
	if(empty($yhid))
	{
		return '';
	}
	$query='';
	if($eyh_r[$yhid][$yhvar])
	{
		$t=time()-($eyh_r[$yhid][$yhvar]*86400);
		$query='newstime>'.$t.(empty($ecms)?'':' and ');
	}
	return $query;
}

//返回优化+条件SQL
function ReturnYhAndSql($yhadd,$where,$ecms=0){
	if($yhadd.$where=='')
	{
		return '';
	}
	elseif($yhadd&&$where)
	{
		return $ecms==1?' where '.$yhadd.$where:' where '.$yhadd.' and '.$where;
	}
	elseif($yhadd&&!$where)
	{
		return ' where '.$yhadd;
	}
	else
	{
		return $ecms==1?' where '.substr($where,5):' where '.$where;
	}
}

//返回列表查询字段
function ReturnSqlListF($mid){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f='id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard'.substr($emod_r[$mid]['listtempf'],0,-1);
	return $f;
}

//返回内容查询字段
function ReturnSqlTextF($mid,$ecms=0){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f=($ecms==0?'id,classid,':'').'ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard'.substr($emod_r[$mid]['tbmainf'],0,-1);
	return $f;
}

//返回内容副表查询字段
function ReturnSqlFtextF($mid){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f='keyid,dokey,newstempid,closepl,infotags'.substr($emod_r[$mid]['tbdataf'],0,-1);
	return $f;
}

//返回信息表
function ReturnInfoTbname($tbname,$checked=1,$stb=1){
	global $dbtbpre;
	if(empty($checked))//待审核
	{
		$r['tbname']=$dbtbpre.'ecms_'.$tbname.'_check';
		$r['datatbname']=$dbtbpre.'ecms_'.$tbname.'_check_data';
	}
	else//已审核
	{
		$r['tbname']=$dbtbpre.'ecms_'.$tbname;
		$r['datatbname']=$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
	}
	return $r;
}

//返回信息主表
function ReturnInfoMainTbname($tbname,$checked=1){
	global $dbtbpre;
	return empty($checked)?$dbtbpre.'ecms_'.$tbname.'_check':$dbtbpre.'ecms_'.$tbname;
}

//返回信息副表
function ReturnInfoDataTbname($tbname,$checked=1,$stb=1){
	global $dbtbpre;
	return empty($checked)?$dbtbpre.'ecms_'.$tbname.'_check_data':$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
}

//主表信息
function ReturnIndexTableInfo($tbname,$f,$classid,$id){
	global $dbtbpre;
	$r=$empire->fetch1("select ".$f." from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	return $r;
}

//返回评论表名
function eReturnRestb($restb){
	global $public_r,$dbtbpre;
	$restb=(int)$restb;
	if(!strstr($public_r['pldatatbs'],','.$restb.','))
	{
		$restb=$public_r['pldeftb'];
	}
	return $dbtbpre.'enewspl_'.$restb;
}

//返回附件表名
function eReturnFstb($fstb){
	global $public_r,$dbtbpre;
	$fstb=(int)$fstb;
	if(!strstr($public_r['filedatatbs'],','.$fstb.','))
	{
		$fstb=$public_r['filedeftb'];
	}
	return $dbtbpre.'enewsfile_'.$fstb;
}

//返回公共表索引ID
function ReturnInfoPubid($classid,$id,$tid=0){
	global $class_r;
	if(empty($tid))
	{
		$tid=$class_r[$classid]['tid'];
	}
	$pubid='1'.ReturnAllInt($tid,5).ReturnAllInt($id,10);
	return $pubid;
}

//是否内部表
function InfoIsInTable($tbname){
	global $etable_r;
	return $etable_r[$tbname]['intb']==1?true:false;
}

//检验字段是否存在
function eCheckTbHaveField($tid,$tbname,$f){
	global $empire,$dbtbpre;
	$where=$tid?"tid='$tid' and ":"tbname='$tbname' and ";
	if(strstr($f,','))
	{
		$fr=explode(',',$f);
		$where.="f='".$fr[0]."' or f='".$fr[1]."'";
	}
	else
	{
		$where.="f='$f'";
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where ".$where." limit 1");
	return $num;
}

//验证模板是否开启动态使用
function DtTempIsClose($tempid,$type='listtemp'){
	global $public_r;
	if($type=='listtemp')//列表模板
	{
		if($public_r['closelisttemp']&&strstr(','.$public_r['closelisttemp'].',',','.$tempid.','))
		{
			echo'ListTempID='.$tempid.' is close.';
			exit();
		}
	}
}

//补零
function ReturnAllInt($val,$num){
	$len=strlen($val);
	$zeronum=$num-$len;
	if($zeronum==1)
	{
		$val='0'.$val;
	}
	elseif($zeronum==2)
	{
		$val='00'.$val;
	}
	elseif($zeronum==3)
	{
		$val='000'.$val;
	}
	elseif($zeronum==4)
	{
		$val='0000'.$val;
	}
	elseif($zeronum==5)
	{
		$val='00000'.$val;
	}
	elseif($zeronum==6)
	{
		$val='000000'.$val;
	}
	elseif($zeronum==7)
	{
		$val='0000000'.$val;
	}
	elseif($zeronum==8)
	{
		$val='00000000'.$val;
	}
	elseif($zeronum==9)
	{
		$val='000000000'.$val;
	}
	elseif($zeronum==10)
	{
		$val='0000000000'.$val;
	}
	return $val;
}

//返回替换列表
function ReturnReplaceListF($mid){
	global $emod_r;
	$r['mid']=$mid;
	$r['fr']=explode(',',$emod_r[$mid]['listtempf']);
	$r['fcount']=count($r['fr'])-1;
	return $r;
}

//返回替换内容
function ReturnReplaceTextF($mid){
	global $emod_r;
	$r['mid']=$mid;
	$r['fr']=explode(',',$emod_r[$mid]['tempf']);
	$r['fcount']=count($r['fr'])-1;
	return $r;
}

//替换列表模板/标签模板/搜索模板
function ReplaceListVars($no,$listtemp,$subnews,$subtitle,$formatdate,$url,$haveclass=0,$r,$field,$docode=0){
	global $empire,$public_r,$class_r,$class_zr,$fun_r,$dbtbpre,$emod_r,$class_tr,$level_r,$navclassid,$etable_r;
	if($haveclass)
	{
		$add=sys_ReturnBqClassname($r,$haveclass);
	}
	if(empty($r[oldtitle]))
	{
		$r[oldtitle]=$r[title];
	}
	if($docode==1)
	{
		$listtemp=stripSlashes($listtemp);
		eval($listtemp);
	}
	$ylisttemp=$listtemp;
	$mid=$field['mid'];
	$fr=$field['fr'];
	$fcount=$field['fcount'];
	for($i=1;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$value=$r[$f];
		$spf=0;
		if($f=='title')//标题
		{
	        if(!empty($subtitle))//截取字符
	        {
				$value=sub($value,0,$subtitle,false);
	        }
			$value=DoTitleFont($r[titlefont],$value);
			$spf=1;
		}
		elseif($f=='newstime')//时间
		{
			//$value=date($formatdate,$value);
			$value=format_datetime($value,$formatdate);
			$spf=1;
		}
		elseif($f=='titlepic')//标题图片
		{
			if(empty($value))
		    {
				$value=$public_r[newsurl].'e/data/images/notimg.gif';
			}
			$spf=1;
		}
		elseif(strstr($emod_r[$mid]['smalltextf'],','.$f.','))//简介
		{
			if(!empty($subnews))//截取字符
			{
				$value=sub($value,0,$subnews,false);
			}
		}
		elseif($f=='befrom')//信息来源
		{
			$spf=1;
		}
		elseif($f=='writer')//作者
		{
			$spf=1;
		}
		if($spf==0&&!strstr($emod_r[$mid]['editorf'],','.$f.','))
		{
			if(strstr($emod_r[$mid]['tobrf'],','.$f.','))//加br
			{
				$value=nl2br($value);
			}
			if(!strstr($emod_r[$mid]['dohtmlf'],','.$f.','))//去除html
			{
				$value=RepFieldtextNbsp(ehtmlspecialchars($value));
			}
		}
		$listtemp=str_replace('[!--'.$f.'--]',$value,$listtemp);
	}
	$titleurl=sys_ReturnBqTitleLink($r);//链接
	$listtemp=str_replace('[!--id--]',$r[id],$listtemp);
	$listtemp=str_replace('[!--classid--]',$r[classid],$listtemp);
	$listtemp=str_replace('[!--class.name--]',$add,$listtemp);
	$listtemp=str_replace('[!--ttid--]',$r[ttid],$listtemp);
	$listtemp=str_replace('[!--tt.name--]',$class_tr[$r[ttid]][tname],$listtemp);
	$listtemp=str_replace('[!--tt.url--]',sys_ReturnBqInfoTypeUrl($r['ttid']),$listtemp);
	$listtemp=str_replace('[!--userfen--]',$r[userfen],$listtemp);
	$listtemp=str_replace('[!--titleurl--]',$titleurl,$listtemp);
	$listtemp=str_replace('[!--no.num--]',$no,$listtemp);
	$listtemp=str_replace('[!--plnum--]',$r[plnum],$listtemp);
	$listtemp=str_replace('[!--userid--]',$r[userid],$listtemp);
	$listtemp=str_replace('[!--username--]',$r[username],$listtemp);
	$listtemp=str_replace('[!--onclick--]',$r[onclick],$listtemp);
	$listtemp=str_replace('[!--oldtitle--]',$r[oldtitle],$listtemp);
	$listtemp=str_replace('[!--totaldown--]',$r[totaldown],$listtemp);
	//栏目链接
	if(strstr($ylisttemp,'[!--this.classlink--]'))
	{
		$thisclasslink=sys_ReturnBqClassname($r,9);
		$listtemp=str_replace('[!--this.classlink--]',$thisclasslink,$listtemp);
	}
	$thisclassname=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$listtemp=str_replace('[!--this.classname--]',$thisclassname,$listtemp);
	return $listtemp;
}

//加上防复制字符
function AddNotCopyRndStr($text){
	global $public_r;
	if($public_r['opencopytext'])
	{
		$rnd=make_password(3).$public_r['sitename'];
		$text=str_replace("<br />","<span style=\"display:none\">".$rnd."</span><br />",$text);
		$text=str_replace("</p>","<span style=\"display:none\">".$rnd."</span></p>",$text);
	}
	return $text;
}

//替换信息来源
function ReplaceBefrom($befrom){
	global $empire,$dbtbpre;
	if(empty($befrom))
	{return $befrom;}
	$befrom=addslashes($befrom);
	$r=$empire->fetch1("select befromid,sitename,siteurl from {$dbtbpre}enewsbefrom where sitename='$befrom' limit 1");
	if(empty($r[befromid]))
	{return $befrom;}
	$return_befrom="<a href='".$r[siteurl]."' target=_blank>".$r[sitename]."</a>";
	return $return_befrom;
}

//替换作者
function ReplaceWriter($writer){
	global $empire,$dbtbpre;
	if(empty($writer))
	{return $writer;}
	$writer=addslashes($writer);
	$r=$empire->fetch1("select wid,writer,email from {$dbtbpre}enewswriter where writer='$writer' limit 1");
	if(empty($r[wid])||empty($r[email]))
	{
		return $writer;
	}
	$return_writer="<a href='".$r[email]."'>".$r[writer]."</a>";
	return $return_writer;
}

//备份下载记录
function BakDown($classid,$id,$pathid,$userid,$username,$title,$cardfen,$online=0){
	global $empire,$dbtbpre;
	$truetime=time();
	$id=(int)$id;
	$pathid=(int)$pathid;
	$userid=(int)$userid;
	$cardfen=(int)$cardfen;
	$classid=(int)$classid;
	$sql=$empire->query("insert into {$dbtbpre}enewsdownrecord(id,pathid,userid,username,title,cardfen,truetime,classid,online) values($id,$pathid,$userid,'$username','".addslashes($title)."',$cardfen,$truetime,$classid,'$online');");
}

//备份充值记录
function BakBuy($userid,$username,$buyname,$userfen,$money,$userdate,$type=0){
	global $empire,$dbtbpre;
	$buytime=date("y-m-d H:i:s");
	$buyname=addslashes($buyname);
	$empire->query("insert into {$dbtbpre}enewsbuybak(userid,username,card_no,cardfen,money,buytime,userdate,type) values('$userid','$username','$buyname','$userfen','$money','$buytime','$userdate','$type');");
}

//发送短消息
function eSendMsg($title,$msgtext,$to_username,$from_userid,$from_username,$isadmin,$issys,$ecms=0){
	global $empire,$dbtbpre;
	$tbname=$ecms==1?$dbtbpre.'enewshmsg':$dbtbpre.'enewsqmsg';
	$msgtime=date("Y-m-d H:i:s");
	$empire->query("insert into ".$tbname."(title,msgtext,haveread,msgtime,to_username,from_userid,from_username,isadmin,issys) values('$title','$msgtext',0,'$msgtime','$to_username','$from_userid','$from_username','$isadmin','$issys');");
	//消息状态
	$userr=$empire->fetch1("select ".eReturnSelectMemberF('userid,havemsg')." from ".eReturnMemberTable()." where ".egetmf('username')."='$to_username' limit 1");
	if(!$userr['havemsg'])
	{
		$newhavemsg=eReturnSetHavemsg($userr['havemsg'],0);
		$empire->query("update ".eReturnMemberTable()." set ".egetmf('havemsg')."='$newhavemsg' where ".egetmf('userid')."='".$userr['userid']."' limit 1");
	}
}

//发送通知
function eSendNotice($title,$msgtext,$to_username,$from_userid,$from_username,$ecms=0){
	global $empire,$dbtbpre;
	$tbname=$ecms==1?$dbtbpre.'enewshnotice':$dbtbpre.'enewsnotice';
	$msgtime=date("Y-m-d H:i:s");
	$empire->query("insert into ".$tbname."(title,msgtext,haveread,msgtime,to_username,from_userid,from_username) values('".$title."','".$msgtext."',0,'$msgtime','$to_username','$from_userid','$from_username');");
}

//截取简介
function SubSmalltextVal($value,$len){
	if(empty($len))
	{
		return '';
	}
	$value=str_replace(array("\r\n","<br />","<br>","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","\r\n","\r\n"," ","",""),$value);
	$value=strip_tags($value);
	if($len)
	{
		$value=sub($value,0,$len,false);
	}
	$value=trim($value,"\r\n");
	$value=str_replace('&amp;ldquo;','&ldquo;',$value);
	$value=str_replace('&amp;rdquo;','&rdquo;',$value);
	$value=str_replace('&amp;mdash;','&mdash;',$value);
	return $value;
}

//全站搜索简介
function SubSchallSmalltext($value,$len){
	$value=str_replace(array("\r\n","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","","",""),$value);
	$value=strip_tags($value);
	if($len)
	{
		$value=sub($value,0,$len,false);
	}
	$value=trim($value,"\r\n");
	return $value;
}

//加红替换
function DoReplaceFontRed($text,$key){
	return str_replace($key,'<font color="red">'.$key.'</font>',$text);
}

//返回不生成html的栏目
function ReturnNreInfoWhere(){
	global $public_r;
	if(empty($public_r['nreinfo'])||$public_r['nreinfo']==',')
	{
		return '';
	}
	$cids=substr($public_r['nreinfo'],1,strlen($public_r['nreinfo'])-2);
	$where=' and classid not in ('.$cids.')';
	return $where;
}

//返回标签不调用栏目
function ReturnNottoBqWhere(){
	global $public_r;
	if(empty($public_r['nottobq'])||$public_r['nottobq']==',')
	{
		return '';
	}
	$cids=substr($public_r['nottobq'],1,strlen($public_r['nottobq'])-2);
	$where='classid not in ('.$cids.')';
	return $where;
}

//返回文件名及扩展名
function ReturnCFiletype($file){
	$r=explode('.',$file);
	$count=count($r)-1;
	$re['filetype']=strtolower($r[$count]);
	$re['filename']=substr($file,0,strlen($file)-strlen($re['filetype'])-1);
	return $re;
}

//返回栏目目录
function ReturnSaveClassPath($classid,$f=0){
	global $class_r;
	$classpath=$class_r[$classid][classpath];
	if($f==1){
		$classpath.="/index".$class_r[$classid][classtype];
	}
	return $classpath;
}

//返回专题目录
function ReturnSaveZtPath($classid,$f=0){
	global $class_zr;
	$classpath=$class_zr[$classid][ztpath];
	if($f==1){
		$classpath.="/index".$class_zr[$classid][zttype];
	}
	return $classpath;
}

//返回标题分类目录
function ReturnSaveInfoTypePath($classid,$f=0){
	global $class_tr;
	$classpath=$class_tr[$classid]['tpath'];
	if($f==1){
		$classpath.='/index'.$class_tr[$classid]['ttype'];
	}
	return $classpath;
}

//返回首页文件
function ReturnSaveIndexFile(){
	global $public_r;
	$file='index'.$public_r[indextype];
	return $file;
}

//返回首页地址
function ReturnSiteIndexUrl(){
	global $public_r;
	if(empty($public_r['indexaddpage']))
	{
		return $public_r['newsurl'];
	}
	if($public_r['indexpagedt']||Moreport_ReturnMustDt())//moreport
	{
		$public_r['indextype']='.php';
	}
	$file=$public_r['newsurl'].'index'.$public_r['indextype'];
	return $file;
}

//返回内容页存放目录
function ReturnSaveInfoPath($classid,$id){
	global $class_r;
	if($class_r[$classid][ipath]==''){
		$path=$class_r[$classid][classpath].'/';
	}
	else{
		$path=$class_r[$classid][ipath]=='/'?'':$class_r[$classid][ipath].'/';
	}
	return $path;
}

//返回内容页文件名
function GetInfoFilename($classid,$id){
	global $empire,$dbtbpre,$public_r,$class_r;
	$infor=$empire->fetch1("select isurl,groupid,classid,newspath,filename,id from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
	if(!$infor['id']||$infor['isurl'])
	{
		return '';
	}
	$filetype=$infor['groupid']?'.php':$class_r[$classid]['filetype'];
	$iclasspath=ReturnSaveInfoPath($classid,$id);
	$doclasspath=eReturnTrueEcmsPath().$iclasspath;//moreport
	$newspath='';
	if($infor['newspath'])
	{
		$newspath=$infor['newspath'].'/';
	}
	$file=$doclasspath.$newspath.$infor['filename'].$filetype;
	return $file;
}

//格式化信息目录
function FormatPath($classid,$mynewspath,$enews=0){
	global $class_r;
	if($enews)
	{
		$newspath=$mynewspath;
	}
	else
	{
		$newspath=date($class_r[$classid][newspath]);
	}
	if(empty($newspath))
	{
		return "";
	}
	$path=ECMS_PATH.ReturnSaveInfoPath($classid,$id);
	$returnpath="";
	$r=explode("/",$newspath);
	$count=count($r);
	for($i=0;$i<$count;$i++){
		if($i>0)
		{
			$returnpath.="/".$r[$i];
		}
		else
		{
			$returnpath.=$r[$i];
		}
		$createpath=$path.$returnpath;
		$mk=DoMkdir($createpath);
		if(empty($mk))
		{
			printerror("CreatePathFail","");
		}
	}
	return $returnpath;
}

//返回内容页目录
function ReturnInfoSPath($filename){
	return str_replace('/index','',$filename);
}

//返回根目录
function ReturnAbsEcmsPath(){
	$ecmspath=str_replace("\\","/",ECMS_PATH);
	return $ecmspath;
}

//返回当前根目录
function eReturnTrueEcmsPath(){
	if(defined('ECMS_SELFPATH'))
	{
		return ECMS_SELFPATH;
	}
	else
	{
		return ECMS_PATH;
	}
}

//返回主端根目录
function eReturnEcmsMainPortPath(){
	global $ecms_config;
	if($ecms_config['sets']['mainportpath'])
	{
		return $ecms_config['sets']['mainportpath'];
	}
	else
	{
		return ECMS_PATH;
	}
}


//------------- 附件 -------------

//返回附件分表
function eReturnFileStb($fstb){
	global $public_r;
	$fstb=(int)$fstb;
	if(!strstr($public_r['filedatatbs'],','.$fstb.','))
	{
		$fstb=$public_r['filedeftb'];
	}
	return $fstb;
}

//返回附件表
function eReturnFileTable($modtype,$fstb){
	global $dbtbpre;
	if($modtype==0)//信息
	{
		$fstb=eReturnFileStb($fstb);
		$table=$dbtbpre.'enewsfile_'.$fstb;
	}
	elseif($modtype==5)//公共
	{
		$table=$dbtbpre.'enewsfile_public';
	}
	elseif($modtype==6)//会员
	{
		$table=$dbtbpre.'enewsfile_member';
	}
	else//其他
	{
		$table=$dbtbpre.'enewsfile_other';
	}
	return $table;
}

//查询附件表
function eSelectFileTable($modtype,$fstb,$selectf,$where){
	global $dbtbpre;
	$query="select {$selectf} from ".eReturnFileTable($modtype,$fstb)." where ".$where;
	return $query;
}

//写入附件记录
function eInsertFileTable($filename,$filesize,$path,$adduser,$classid,$no,$type,$id,$cjid,$fpath,$pubid,$modtype=0,$fstb=1){
	global $empire,$dbtbpre,$public_r;
	$filetime=time();
	$filesize=(int)$filesize;
	$classid=(int)$classid;
	$id=(int)$id;
	$cjid=(int)$cjid;
	$fpath=(int)$fpath;
	$type=(int)$type;
	$modtype=(int)$modtype;
	$filename=addslashes(RepPostStr($filename));
	$no=addslashes(RepPostStr($no));
	$adduser=RepPostVar($adduser);
	$path=addslashes(RepPostStr($path));
	$pubid=RepPostVar($pubid);
	$fstb=(int)$fstb;
	if($modtype==0)//信息
	{
		$fstb=eReturnFileStb($fstb);
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_".$fstb."(pubid,filename,filesize,adduser,path,filetime,classid,no,type,id,cjid,onclick,fpath) values('$pubid','$filename','$filesize','$adduser','$path','$filetime','$classid','$no','$type','$id','$cjid',0,'$fpath');");
	}
	elseif($modtype==5)//公共
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_public(filename,filesize,adduser,path,filetime,modtype,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime',0,'$no','$type','$id','$cjid',0,'$fpath');");
	}
	elseif($modtype==6)//会员
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_member(filename,filesize,adduser,path,filetime,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime','$no','$type','$id','$cjid',0,'$fpath');");
	}
	else//其他
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_other(filename,filesize,adduser,path,filetime,modtype,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime','$modtype','$no','$type','$id','$cjid',0,'$fpath');");
	}
	return $sql;
}

//更新相应的附件(非信息)
function UpdateTheFileOther($modtype,$id,$checkpass,$tb='other'){
	global $empire,$dbtbpre;
	if(empty($id)||empty($checkpass))
	{
		return "";
	}
	$id=(int)$id;
	$checkpass=(int)$checkpass;
	$where='';
	if($tb=='other')
	{
		$where=" and modtype='$modtype'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$tb} set id='$id',cjid=0 where cjid='$checkpass'".$where);
}

//修改时更新附件(非信息)
function UpdateTheFileEditOther($modtype,$id,$tb='other'){
	global $empire,$dbtbpre;
	$where='';
	if($tb=='other')
	{
		$where=" and modtype='$modtype'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$tb} set cjid=0 where id='$id'".$where);
}

//返回filepass
function ReturnTranFilepass(){
	$filepass=time();
	return $filepass;
}

//返回附件域名地址
function eReturnFileUrl($ecms=0){
	global $public_r;
	if($ecms==1)
	{
		return $public_r['fileurl'];
	}
	$fileurl=$public_r['openfileserver']?$public_r['fs_purl']:$public_r['fileurl'];
	return $fileurl;
}

//返回附件目录
function ReturnFileSavePath($classid,$fpath=''){
	global $public_r,$class_r;
	$fpath=$fpath||strstr(','.$fpath.',',',0,')?$fpath:$public_r['fpath'];
	$efileurl=eReturnFileUrl();
	if($fpath==1)//p目录
	{
		$r['filepath']='d/file/p/';
		$r['fileurl']=$efileurl.'p/';
	}
	elseif($fpath==2)//file目录
	{
		$r['filepath']='d/file/';
		$r['fileurl']=$efileurl;
	}
	else
	{
		if(empty($classid))
		{
			$r['filepath']='d/file/p/';
			$r['fileurl']=$efileurl.'p/';
		}
		else
		{
			$r['filepath']='d/file/'.$class_r[$classid][classpath].'/';
			$r['fileurl']=$efileurl.$class_r[$classid][classpath].'/';
		}
	}
	return $r;
}

//格式化附件目录
function FormatFilePath($classid,$mynewspath,$enews=0){
	global $public_r;
	if($enews)
	{
		$newspath=$mynewspath;
	}
	else
	{
		$newspath=date($public_r['filepath']);
	}
	if(empty($newspath))
	{
		return "";
	}
	$fspath=ReturnFileSavePath($classid);
	$path=eReturnEcmsMainPortPath().$fspath['filepath'];//moreport
	$returnpath="";
	$r=explode("/",$newspath);
	$count=count($r);
	for($i=0;$i<$count;$i++){
		if($i>0){
			$returnpath.="/".$r[$i];
		}
		else{
			$returnpath.=$r[$i];
		}
		$createpath=$path.$returnpath;
		$mk=DoMkdir($createpath);
		if(empty($mk)){
			printerror("CreatePathFail","");
		}
	}
	return $returnpath;
}

//返回上传文件名
function ReturnDoTranFilename($file_name,$classid){
	$filename=md5(uniqid(microtime()));
	return $filename;
}

//上传文件
function DoTranFile($file,$file_name,$file_type,$file_size,$classid,$ecms=0){
	global $public_r,$class_r,$doetran,$efileftp_fr;
	$classid=(int)$classid;
	//文件类型
	$r[filetype]=GetFiletype($file_name);
	//文件名
	$r[insertfile]=ReturnDoTranFilename($file_name,$classid);
	$r[filename]=$r[insertfile].$r[filetype];
	//日期目录
	$r[filepath]=FormatFilePath($classid,$mynewspath,0);
	$filepath=$r[filepath]?$r[filepath].'/':$r[filepath];
	//存放目录
	$fspath=ReturnFileSavePath($classid);
	$r[savepath]=eReturnEcmsMainPortPath().$fspath['filepath'].$filepath;//moreport
	//附件地址
	$r[url]=$fspath['fileurl'].$filepath.$r[filename];
	//缩图文件
	$r[name]=$r[savepath]."small".$r[insertfile];
	//附件文件
	$r[yname]=$r[savepath].$r[filename];
	$r[tran]=1;
	//验证类型
	if(CheckSaveTranFiletype($r[filetype]))
	{
		if($doetran)
		{
			$r[tran]=0;
			return $r;
		}
		else
		{
			printerror('TranFail','',$ecms);
		}
	}
	//上传文件
	$cp=@move_uploaded_file($file,$r[yname]);
	if(empty($cp))
	{
		if($doetran)
		{
			$r[tran]=0;
			return $r;
		}
		else
		{
			printerror('TranFail','',$ecms);
		}
	}
	DoChmodFile($r[yname]);
	$r[filesize]=(int)$file_size;
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_fr[]=$r['yname'];
	}
	return $r;
}

//远程保存忽略地址
function CheckNotSaveUrl($url){
	global $public_r;
	if(empty($public_r['notsaveurl']))
	{
		return 0;
    }
	$r=explode("\r\n",$public_r['notsaveurl']);
	$count=count($r);
	$re=0;
	for($i=0;$i<$count;$i++)
	{
		if(empty($r[$i]))
		{continue;}
		if(stristr($url,$r[$i]))
		{
			$re=1;
			break;
	    }
    }
	return $re;
}

//远程保存
function DoTranUrl($url,$classid){
	global $public_r,$class_r,$ecms_config,$efileftp_fr;
	$classid=(int)$classid;
	//处理地址
	$url=trim($url);
	$url=str_replace(" ","%20",$url);
    $r[tran]=1;
	//附件地址
	$r[url]=$url;
	//文件类型
	$r[filetype]=GetFiletype($url);
	if(CheckSaveTranFiletype($r[filetype]))
	{
		$r[tran]=0;
		return $r;
	}
	//是否已上传的文件
	$havetr=CheckNotSaveUrl($url);
	if($havetr)
	{
		$r[tran]=0;
		return $r;
	}
	//是否地址
	if(!strstr($url,'://'))
	{
		$r[tran]=0;
		return $r;
	}
	$string=ReadFiletext($url);
	if(empty($string))//读取不了
	{
		$r[tran]=0;
		return $r;
	}
	//文件名
	$r[insertfile]=ReturnDoTranFilename($file_name,$classid);
	$r[filename]=$r[insertfile].$r[filetype];
	//日期目录
	$r[filepath]=FormatFilePath($classid,$mynewspath,0);
	$filepath=$r[filepath]?$r[filepath].'/':$r[filepath];
	//存放目录
	$fspath=ReturnFileSavePath($classid);
	$r[savepath]=eReturnEcmsMainPortPath().$fspath['filepath'].$filepath;//moreport
	//附件地址
	$r[url]=$fspath['fileurl'].$filepath.$r[filename];
	//缩图文件
	$r[name]=$r[savepath]."small".$r[insertfile];
	//附件文件
	$r[yname]=$r[savepath].$r[filename];
	WriteFiletext_n($r[yname],$string);
	$r[filesize]=@filesize($r[yname]);
	//返回类型
	if(strstr($ecms_config['sets']['tranflashtype'],','.$r[filetype].','))
	{
		$r[type]=2;
	}
	elseif(strstr($ecms_config['sets']['tranpicturetype'],','.$r[filetype].','))
	{
		$r[type]=1;
	}
	elseif(strstr($ecms_config['sets']['mediaplayertype'],','.$r[filetype].',')||strstr($ecms_config['sets']['realplayertype'],','.$r[filetype].','))//多媒体
	{
		$r[type]=3;
	}
	else
	{
		$r[type]=0;
	}
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_fr[]=$r['yname'];
	}
	return $r;
}

//删除附件
function DoDelFile($r){
	global $class_r,$public_r,$efileftp_dr;
	$path=$r['path']?$r['path'].'/':$r['path'];
	$fspath=ReturnFileSavePath($r[classid],$r[fpath]);
	$delfile=eReturnEcmsMainPortPath().$fspath['filepath'].$path.$r['filename'];//moreport
	DelFiletext($delfile);
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_dr[]=$delfile;
	}
}

//替换表前缀
function RepSqlTbpre($sql){
	global $dbtbpre;
	$sql=str_replace('[!db.pre!]',$dbtbpre,$sql);
	return $sql;
}

//反替换表前缀
function ReRepSqlTbpre($sql){
	global $dbtbpre;
	$sql=str_replace($dbtbpre,'***_',$sql);
	return $sql;
}

//验证表是否存在
function eCheckTbname($tbname){
	global $empire,$dbtbpre;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	return $num;
}

//时间转换
function ToChangeUseTime($time){
	global $fun_r;
	$usetime=time()-$time;
	if($usetime<60)
	{
		$tstr=$usetime.$fun_r['TimeSecond'];
	}
	else
	{
		$usetime=round($usetime/60);
		$tstr=$usetime.$fun_r['TimeMinute'];
	}
	return $tstr;
}

//返回栏目集合
function ReturnClass($sonclass){
	if($sonclass==''||$sonclass=='|'){
		return 'classid=0';
	}
	$where='classid in ('.RepSonclassSql($sonclass).')';
	return $where;
}

//替换子栏目子
function RepSonclassSql($sonclass){
	if($sonclass==''||$sonclass=='|'){
		return 0;
	}
	$sonclass=substr($sonclass,1,strlen($sonclass)-2);
	$sonclass=str_replace('|',',',$sonclass);
	return $sonclass;
}

//返回多栏目
function sys_ReturnMoreClass($sonclass,$son=0){
	global $class_r;
	$r=explode(',',$sonclass);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$where='';
	$or='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		if($son==1)
		{
			if($class_r[$r[$i]]['tbname']&&!$class_r[$r[$i]]['islast'])
			{
				$where.=$or."classid in (".RepSonclassSql($class_r[$r[$i]]['sonclass']).")";
			}
			else
			{
				$where.=$or."classid='".$r[$i]."'";
			}
		}
		else
		{
			$where.=$or."classid='".$r[$i]."'";
		}
		$or=' or ';
	}
	$return_r[1]=$where;
	return $return_r;
}

//返回多专题
function sys_ReturnMoreZt($zt,$ecms=0){
	$f=$ecms==1?'ztid':'cid';
	$r=explode(',',$zt);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		$ids.=$dh.$r[$i];
		$dh=',';
	}
	$return_r[1]=$f.' in ('.$ids.')';
	return $return_r;
}

//返回多标题分类
function sys_ReturnMoreTT($tt){
	$r=explode(',',$tt);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		$ids.=$dh.$r[$i];
		$dh=',';
	}
	$return_r[1]='ttid in ('.$ids.')';
	return $return_r;
}

//验证是否包含栏目
function CheckHaveInClassid($cr,$checkclass){
	global $class_r;
	if($cr['islast'])
	{
		$chclass='|'.$cr['classid'].'|';
	}
	else
	{
		$chclass=$cr['sonclass'];
	}
	$return=0;
	$r=explode('|',$chclass);
	$count=count($r);
	for($i=1;$i<$count-1;$i++)
	{
		if(strstr($checkclass,'|'.$r[$i].'|'))
		{
			$return=1;
			break;
		}
	}
	return $return;
}

//返回加前缀的下载地址
function ReturnDownQzPath($path,$urlid){
	global $empire,$dbtbpre;
	$urlid=(int)$urlid;
	if(empty($urlid))
	{
		$re['repath']=$path;
		$re['downtype']=0;
    }
	else
	{
		$r=$empire->fetch1("select urlid,url,downtype from {$dbtbpre}enewsdownurlqz where urlid='$urlid'");
		if($r['urlid'])
		{
			$re['repath']=$r['url'].$path;
		}
		else
		{
			$re['repath']=$path;
		}
		$re['downtype']=$r['downtype'];
	}
	return $re;
}

//返回带防盗链的绝对地址
function ReturnDSofturl($downurl,$qz,$path='../../',$isdown=0){
	$urlr=ReturnDownQzPath(stripSlashes($downurl),$qz);
	$url=$urlr['repath'];
	@include_once(ECMS_PATH."e/DownSys/class/enpath.php");//防盗链
	if($isdown)
	{
		$url=DoEnDownpath($url);
	}
	else
	{
		$url=DoEnOnlinepath($url);
	}
	return $url;
}

//验证提交来源
function CheckCanPostUrl(){
	global $public_r;
	if($public_r['canposturl'])
	{
		$r=explode("\r\n",$public_r['canposturl']);
		$count=count($r);
		$b=0;
		for($i=0;$i<$count;$i++)
		{
			if(strstr($_SERVER['HTTP_REFERER'],$r[$i]))
			{
				$b=1;
				break;
			}
		}
		if($b==0)
		{
			printerror('NotCanPostUrl','',1);
		}
	}
}

//验证来源
function DoSafeCheckFromurl(){
	global $ecms_config;
	if($ecms_config['esafe']['ckfromurl']==0||defined('EmpireCMSNFPage'))//不启用
	{
		return '';
	}
	$fromurl=$_SERVER['HTTP_REFERER'];
	if(!$fromurl)
	{
		return '';
	}
	$domain=eReturnDomain();
	if($ecms_config['esafe']['ckfromurl']==1)//全部启用
	{
		if(!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==2)//后台启用
	{
		if(defined('EmpireCMSAdmin')&&!stristr($fromurl,$domain.'/'))
		{
			echo"";
			exit();
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==3)//前台启用
	{
		if(!defined('EmpireCMSAdmin')&&!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
	}
}

//验证IP
function eCheckAccessIp($ecms=0){
	global $public_r;
	$userip=egetip();
	if($ecms)//后台
	{
		//允许IP
		if($public_r['hopenip'])
		{
			$close=1;
			foreach(explode("\n",$public_r['hopenip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					$close=0;
					break;
				}
			}
			if($close==1)
			{
				echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
				exit();
			}
		}
	}
	else
	{
		//允许IP
		if($public_r['openip'])
		{
			$close=1;
			foreach(explode("\n",$public_r['openip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					$close=0;
					break;
				}
			}
			if($close==1)
			{
				echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
				exit();
			}
		}
		//禁止IP
		if($public_r['closeip'])
		{
			foreach(explode("\n",$public_r['closeip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
					exit();
				}
			}
		}
	}
}

//验证提交IP
function eCheckAccessDoIp($doing){
	global $public_r,$empire,$dbtbpre;
	$pr=$empire->fetch1("select opendoip,closedoip,doiptype from {$dbtbpre}enewspublic limit 1");
	if(!strstr($pr['doiptype'],','.$doing.','))
	{
		return '';
	}
	$userip=egetip();
	//允许IP
	if($pr['opendoip'])
	{
		$close=1;
		foreach(explode("\n",$pr['opendoip']) as $ctrlip)
		{
			if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
			{
				$close=0;
				break;
			}
		}
		if($close==1)
		{
			printerror('NotCanPostIp','history.go(-1)',1);
		}
	}
	//禁止IP
	if($pr['closedoip'])
	{
		foreach(explode("\n",$pr['closedoip']) as $ctrlip)
		{
			if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
			{
				printerror('NotCanPostIp','history.go(-1)',1);
			}
		}
	}
}

//验证是否关闭相关模块
function eCheckCloseMods($mod){
	global $public_r;
	if(strstr($public_r['closemods'],','.$mod.','))
	{
		echo $mod.' is close';
		exit();
	}
}

//验证操作时间
function eCheckTimeCloseDo($ecms){
	global $public_r;
	if(stristr($public_r['timeclosedo'],','.$ecms.','))
	{
		$h=date('G');
		if(strstr($public_r['timeclose'],','.$h.','))
		{
			printerror('ThisTimeCloseDo','history.go(-1)',1);
		}
	}
}

//验证外部登录是否开启
function eCheckCloseMemberConnect(){
	global $public_r;
	if(!$public_r['memberconnectnum'])
	{
		printerror('NotOpenMemberConnect','history.go(-1)',1);
	}
}

//验证包含字符
function toCheckCloseWord($word,$closestr,$mess){
	if($closestr&&$closestr!='|')
	{
		$checkr=explode('|',$closestr);
		$ckcount=count($checkr);
		for($i=0;$i<$ckcount;$i++)
		{
			if($checkr[$i])
			{
				if(stristr($checkr[$i],'##'))//多字
				{
					$morer=explode('##',$checkr[$i]);
					if(stristr($word,$morer[0])&&stristr($word,$morer[1]))
					{
						printerror($mess,"history.go(-1)",1);
					}
				}
				else
				{
					if(stristr($word,$checkr[$i]))
					{
						printerror($mess,"history.go(-1)",1);
					}
				}
			}
		}
	}
}

//替换评论表情
function RepPltextFace($text){
	global $public_r;
	if(empty($public_r['plface'])||$public_r['plface']=='||')
	{
		return $text;
	}
	$facer=explode('||',$public_r['plface']);
	$count=count($facer);
	for($i=1;$i<$count-1;$i++)
	{
		$r=explode('##',$facer[$i]);
		$text=str_replace($r[0],"<img src='".$public_r['newsurl']."e/data/face/".$r[1]."' border=0>",$text);
	}
	return $text;
}

//替换空格
function RepFieldtextNbsp($text){
	return str_replace(array("\t",'   ','  '),array('&nbsp; &nbsp; &nbsp; &nbsp; ','&nbsp; &nbsp;','&nbsp;&nbsp;'),$text);
}

//保留扩展名验证
function CheckSaveTranFiletype($filetype){
	$savetranfiletype=',.php,.php3,.php4,.php5,.php6,.asp,.aspx,.jsp,.cgi,.phtml,.asa,.asax,.fcgi,.pl,.ascx,.ashx,.cer,.cdx,.pht,.shtml,.shtm,.stm,';
	if(stristr($savetranfiletype,','.$filetype.','))
	{
		return true;
	}
	return false;
}

//设置验证码
function ecmsSetShowKey($varname,$val,$ecms=0){
	global $public_r;
	$val=md5($val);
	$time=time();
	$checkpass=md5(md5($val.'EmpireCMS'.$time).$public_r['keyrnd']);
	$key=$time.','.$checkpass.','.$val;
	esetcookie($varname,$key,0,$ecms);
}

//检查验证码
function ecmsCheckShowKey($varname,$postval,$dopr,$ecms=0){
	global $public_r;
	$r=explode(',',getcvar($varname,$ecms));
	$cktime=$r[0];
	$pass=$r[1];
	$val=$r[2];
	$time=time();
	if($cktime>$time||$time-$cktime>$public_r['keytime']*60)
	{
		printerror('OutKeytime','',$dopr);
	}
	if(empty($postval)||md5($postval)<>$val)
	{
		printerror('FailKey','',$dopr);
	}
	$checkpass=md5(md5(md5($postval).'EmpireCMS'.$cktime).$public_r['keyrnd']);
	if($checkpass<>$pass)
	{
		printerror('FailKey','',$dopr);
	}
}

//清空验证码
function ecmsEmptyShowKey($varname,$ecms=0){
	esetcookie($varname,'',0,$ecms);
}

//设置提交码
function DoSetActionPass($userid,$username,$rnd,$other,$ecms=0){
	global $ecms_config;
	$varname='actionepass';
	$date=date("Y-m-d-H");
	$pass=md5(md5($rnd.'-'.$userid.'-'.$date.'-'.$other).$ecms_config['cks']['ckrnd'].$username);
	esetcookie($varname,$pass,0,$ecms);
}

//清除提交码
function DoEmptyActionPass($ecms=0){
	$varname='actionepass';
	esetcookie($varname,'',0,$ecms);
}

//检测提交码
function DoCheckActionPass($userid,$username,$rnd,$other,$ecms=0){
	global $ecms_config;
	$varname='actionepass';
	$date=date("Y-m-d-H");
	$checkpass=md5(md5($rnd.'-'.$userid.'-'.$date.'-'.$other).$ecms_config['cks']['ckrnd'].$username);
	$pass=getcvar($varname,$ecms);
	if($checkpass<>$pass)
	{
		exit();
	}
}

//返回字段标识
function toReturnFname($tbname,$f){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select fname from {$dbtbpre}enewsf where f='$f' and tbname='$tbname' limit 1");
	return $r[fname];
}

//返回拼音
function ReturnPinyinFun($hz){
	global $ecms_config;
	include_once(ECMS_PATH.'e/class/epinyin.php');
	//编码
	if($ecms_config['sets']['pagechar']!='gb2312')
	{
		include_once(ECMS_PATH.'e/class/doiconv.php');
		$iconv=new Chinese('');
		$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'UTF8';
		$targetchar='GB2312';
		$hz=$iconv->Convert($char,$targetchar,$hz);
	}
	return c($hz);
}

//取得字母
function GetInfoZm($hz){
	if(!trim($hz))
	{
		return '';
	}
	$py=ReturnPinyinFun($hz);
	$zm=substr($py,0,1);
	return strtoupper($zm);
}

//返回加密后的IP
function ToReturnXhIp($ip,$n=1){
	$newip='';
	$ipr=explode(".",$ip);
	$ipnum=count($ipr);
	for($i=0;$i<$ipnum;$i++)
	{
		if($i!=0)
		{$d=".";}
		if($i==$ipnum-1)
		{
			$ipr[$i]="*";
		}
		if($n==2)
		{
			if($i==$ipnum-2)
			{
				$ipr[$i]="*";
			}
		}
		$newip.=$d.$ipr[$i];
	}
	return $newip;
}

//返回当前域名2
function eReturnTrueDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return $domain;
}

//返回当前域名
function eReturnDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return 'http://'.$domain;
}

//返回域名网站地址
function eReturnDomainSiteUrl(){
	global $public_r;
	$PayReturnUrlQz=$public_r['newsurl'];
	if(!stristr($public_r['newsurl'],'://'))
	{
		$PayReturnUrlQz=eReturnDomain().$public_r['newsurl'];
	}
	return $PayReturnUrlQz;
}

//返回当前地址
function eReturnSelfPage($ecms=0){
	if(empty($ecms))
	{
		$page=$_SERVER['PHP_SELF'];
	}
	else
	{
		$page=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}
	$page=str_replace('&amp;','&',RepPostStr($page,1));
	return $page;
}

//验证当前会员权限
function sys_CheckMemberGroup($groupid){
	if(!defined('InEmpireCMSUser'))
	{
		include_once ECMS_PATH.'e/member/class/user.php';
	}
	$r=qCheckLoginAuthstr();
	if(!$r['islogin'])
	{
		return 0;
	}
	if(!strstr(','.$groupid.',',','.$r['groupid'].','))
	{
		return -1;
	}
	return 1;
}

//EMAIL地址检查
function chemail($email){
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false)
    {
        if (preg_match($chars, $email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

//去除adds
function ClearAddsData($data){
	if(MAGIC_QUOTES_GPC)
	{
		$data=stripSlashes($data);
	}
	return $data;
}

//增加adds
function AddAddsData($data){
	if(!MAGIC_QUOTES_GPC)
	{
		$data=addslashes($data);
	}
	return $data;
}

//原字符adds
function StripAddsData($data){
	$data=addslashes(stripSlashes($data));
	return $data;
}

//反增加adds
function fAddAddsData($data){
	if(MAGIC_QUOTES_GPC)
	{
		$data=addslashes($data);
	}
	return $data;
}

//------- 存文本 -------

//读取文本字段内容
function GetTxtFieldText($pagetexturl){
	global $ecms_config;
	if(empty($pagetexturl))
	{
		return '';
	}
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	$text=ReadFiletext($file);
	$text=substr($text,12);//去除exit
	return $text;
}

//取得文本地址
function GetTxtFieldTextUrl($pagetexturl){
	global $ecms_config;
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	return $file;
}

//修改文本字段内容
function EditTxtFieldText($pagetexturl,$pagetext){
	global $ecms_config;
	$pagetext="<? exit();?>".$pagetext;
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	WriteFiletext_n($file,$pagetext);
}

//删除文本字段内容
function DelTxtFieldText($pagetexturl){
	global $ecms_config;
	if(empty($pagetexturl))
	{
		return '';
	}
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	DelFiletext($file);
}

//取得随机数
function GetFileMd5(){
	$p=md5(uniqid(microtime()));
	return $p;
}

//建立存放目录
function MkDirTxtFile($date,$file){
	global $ecms_config;
	$r=explode("/",$date);
	$path=$ecms_config['sets']['txtpath'].$r[0];
	DoMkdir($path);
	$path=$ecms_config['sets']['txtpath'].$date;
	DoMkdir($path);
	$returnpath=$date."/".$file;
	return $returnpath;
}

//替换公共标记
function ReplaceSvars($temp,$url,$classid,$title,$key,$des,$add,$repvar=1){
	global $public_r,$class_r,$class_zr;
	if($repvar==1)//全局模板变量
	{
		$temp=ReplaceTempvar($temp);
	}
	$temp=str_replace('[!--class.menu--]',$public_r['classnavs'],$temp);//栏目导航
	$temp=str_replace('[!--newsnav--]',$url,$temp);//位置导航
	$temp=str_replace('[!--pagetitle--]',$title,$temp);
	$temp=str_replace('[!--pagekey--]',$key,$temp);
	$temp=str_replace('[!--pagedes--]',$des,$temp);
	$temp=str_replace('[!--self.classid--]',0,$temp);
	$temp=str_replace('[!--news.url--]',$public_r['newsurl'],$temp);
	return $temp;
}

//返回数组组合字符
function eReturnRDataStr($r){
	$count=count($r);
	if(!$count)
	{
		return '';
	}
	$str=',';
	for($i=0;$i<$count;$i++)
	{
		$str.=$r[$i].',';
	}
	return $str;
}

//------- firewall -------

//提示
function FWShowMsg($msg){
	//echo $msg;
	exit();
}

//防火墙
function DoEmpireCMSFireWall(){
	global $ecms_config;
	if(!empty($ecms_config['fw']['adminloginurl']))
	{
		$usehost=FWeReturnDomain();
		if($usehost!=$ecms_config['fw']['adminloginurl'])
		{
			FWShowMsg('Login Url');
		}
	}
	if($ecms_config['fw']['adminhour']!=='')
	{
		$h=date('G');
		if(!strstr(','.$ecms_config['fw']['adminhour'].',',','.$h.','))
		{
			FWShowMsg('Admin Hour');
		}
	}
	if($ecms_config['fw']['adminweek']!=='')
	{
		$w=date('w');
		if(!strstr(','.$ecms_config['fw']['adminweek'].',',','.$w.','))
		{
			FWShowMsg('Admin Week');
		}
	}
	if(!defined('EmpireCMSAPage')&&$ecms_config['fw']['adminckpassvar']&&$ecms_config['fw']['adminckpassval'])
	{
		FWCheckPassword();
	}
}

//返回当前域名
function FWeReturnDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return 'http://'.$domain;
}

//检查敏感字符
function FWClearGetText($str){
	global $ecms_config;
	if(empty($ecms_config['fw']['eopen']))
	{
		return '';
	}
	if(empty($ecms_config['fw']['cleargettext']))
	{
		return '';
	}
	$r=explode(',',$ecms_config['fw']['cleargettext']);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		if(stristr($str,$r[$i]))
		{
			FWShowMsg('Post String');
		}
	}
}

//后台防火墙密码
function FWSetPassword(){
	global $ecms_config;
	if(!$ecms_config['fw']['eopen']||!$ecms_config['fw']['adminckpassvar']||!$ecms_config['fw']['adminckpassval'])
	{
		return '';
	}
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$ecmsckpass=md5(md5($ecms_config['fw']['adminckpassval'].'-empirecms-'.$ecms_config['fw']['epass']).'-'.$ip.'-'.$ecms_config['fw']['adminckpassval'].'-phome.net-');
	esetcookie($ecms_config['fw']['adminckpassvar'],$ecmsckpass,0,1);
}

function FWCheckPassword(){
	global $ecms_config;
	if(!$ecms_config['fw']['eopen']||!$ecms_config['fw']['adminckpassvar']||!$ecms_config['fw']['adminckpassval'])
	{
		return '';
	}
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$ecmsckpass=md5(md5($ecms_config['fw']['adminckpassval'].'-empirecms-'.$ecms_config['fw']['epass']).'-'.$ip.'-'.$ecms_config['fw']['adminckpassval'].'-phome.net-');
	if($ecmsckpass<>getcvar($ecms_config['fw']['adminckpassvar'],1))
	{
		FWShowMsg('Password');
	}
}

function FWEmptyPassword(){
	global $ecms_config;
	esetcookie($ecms_config['fw']['adminckpassvar'],'',0,1);
}
?>