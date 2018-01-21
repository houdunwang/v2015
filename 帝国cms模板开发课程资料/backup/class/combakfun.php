<?php

//验证是否使用默认密码和默认验证随机码
function Ebak_CheckIsDefPass($add){
	global $set_password,$set_loginrnd;
	//默认密码
	$defpass='14e1b600b1fd579f47433b88e8d85291';
	$newpass=$add['adminpassword']?md5(md5($add['adminpassword'])):$set_password;
	if($newpass==$defpass)
	{
		printerror("NotToUseDefPass","history.go(-1)");
	}
	//默认验证随机码
	$defloginrnd='EmpireCMS-EmpireBak-EmpireDown';
	$newloginrnd=$add['adminloginrnd'];
	if($newloginrnd==$defloginrnd)
	{
		printerror("NotToUseDefPass","history.go(-1)");
	}
}

//测试数据库链接
function Ebak_CheckConnectDbServer($add,$ecms=0){
	global $link,$empire,$phome_db_ver,$phome_db_password,$defphome_db_password;
	$serverid=$add['checkdbserverid'];
	$dbver=$add['checkdbver'];
	$dbhost=$add['checkdbhost'];
	$dbport=$add['checkdbport'];
	$dbuser=$add['checkdbuser'];
	$dbpass=$add['checkdbpass'];
	$dbname=$add['checkdbname'];
	$dbtbpre=$add['checkdbtbpre'];
	$dbchar=$add['checkdbchar'];
	$serverid=(int)$serverid;
	if($ecms==1)
	{
		$pr=9;
		$showsuccess=0;
	}
	else
	{
		$pr=9;
		$showsuccess=1;
	}
	if(empty($dbhost))
	{
		printerror("CheckFailDbuser","history.go(-1)",$pr);
	}
	if(empty($serverid))
	{
		if(!$dbpass)
		{
			$dbpass=$defphome_db_password;
		}
		elseif($dbpass=='null')
		{
			$dbpass='';
		}
		else
		{}
	}
	$link=do_dbconnect_common($dbhost,$dbport,$dbuser,$dbpass);
	if(empty($link))
	{
		printerror("CheckFailDbuser","history.go(-1)",$pr);
	}
	$empire=new mysqlquery();
	//默认数据库
	if($dbname)
	{
		$usedb=do_dbquery_common("use `".$dbname."`");
		if(!$usedb)
		{
			printerror("CheckNotDb","history.go(-1)",$pr);
		}
	}
	$thisdbver=Ebak_GetMysqlVerForDb(1);
	$phome_db_ver=$thisdbver;
	if($thisdbver)
	{
		if($thisdbver<>$dbver&&$dbver<>'auto')
		{
			printerror("CheckErrorDbVer","history.go(-1)",$pr);
		}
	}
	if($showsuccess)
	{
		printerror("CheckConnectDbSuccess","history.go(-1)",$pr);
	}
}

//返回多服务器集合
function Ebak_ReturnUpdateMoreDbServer($add){
	$mdbver=$add['moredbver'];
	$mdbhost=$add['moredbhost'];
	$mdbport=$add['moredbport'];
	$mdbuser=$add['moredbuser'];
	$mdbpass=$add['moredbpass'];
	$mdbname=$add['moredbname'];
	$mdbtbpre=$add['moredbtbpre'];
	$mdbchar=$add['moredbchar'];
	//集合
	$rexp='|ebak|';
	$fexp='!ebak!';
	$count=count($mdbver);
	if(!$count)
	{
		return '';
	}
	$alldbserver='';
	$addrexp='';
	for($i=0;$i<$count;$i++)
	{
		if(empty($mdbhost[$i]))
		{
			continue;
		}
		$alldbserver.=$addrexp.$mdbver[$i].$fexp.$mdbhost[$i].$fexp.$mdbport[$i].$fexp.$mdbuser[$i].$fexp.$mdbpass[$i].$fexp.$mdbname[$i].$fexp.$mdbtbpre[$i].$fexp.$mdbchar[$i];
		$addrexp=$rexp;
	}
	return $alldbserver;
}

//返回随机字符
function Ebak_CkrndReturnVar($post){
	global $ebak_set_ckrndvar,$ebak_set_ckrndval,$ebak_set_ckrndvaltwo,$ebak_set_ckrndvalthree,$ebak_set_ckrndvalfour,$set_username,$set_loginrnd,$phome_cookievarpre;
	$changernd=0;
	if($post['adminpassword'])
	{
		$changernd=1;
	}
	if($set_username<>$post['adminusername'])
	{
		$changernd=1;
	}
	if($set_loginrnd<>$post['adminloginrnd'])
	{
		$changernd=1;
	}
	if($phome_cookievarpre<>$post['ckvarpre']||$post['ckvarpre']=='ebak_')
	{
		$changernd=1;
	}
	if($changernd)
	{
		$r['ckrndvar']=strtolower(make_password_zm(12));
		$r['ckrndval']=md5(md5(make_password(25)));
		$r['ckrndvaltwo']=md5(md5(make_password(20)));
		$r['ckrndvalthree']=md5(md5(make_password(18)));
		$r['ckrndvalfour']=md5(md5(make_password(16)));
	}
	else
	{
		$r['ckrndvar']=$ebak_set_ckrndvar;
		$r['ckrndval']=$ebak_set_ckrndval;
		$r['ckrndvaltwo']=$ebak_set_ckrndvaltwo;
		$r['ckrndvalthree']=$ebak_set_ckrndvalthree;
		$r['ckrndvalfour']=$ebak_set_ckrndvalfour;
	}
	return $r;
}

//参数设置
function Ebak_SetDb($add){
	global $phome_db_password,$set_password,$phome_db_dbname,$link,$empire,$defphome_db_password;
	//验证是否使用默认密码与默认验证随机码
	Ebak_CheckIsDefPass($add);
	$addrnd_r=Ebak_CkrndReturnVar($_POST);
	if(strstr($add['ebmapath'],'/')||strstr($add['ebmapath'],"\\")||strstr($add['ebmapath'],':'))
	{
		printerror("NotPmaPath","history.go(-1)");
	}
	if(empty($add['outtime']))
	{
		$add['outtime']=60;
	}
	//修改密码
	if(empty($add['dbpassword']))
	{
		$add['dbpassword']=$defphome_db_password;
    }
	elseif($add['dbpassword']=='null')
	{
		$add['dbpassword']='';
	}
	$dblocalhost=$add['dbhost'];
	//端口
	if($add['dbport'])
	{
		$dblocalhost.=":".$add['dbport'];
    }
	$link=do_dbconnect_common($add['dbhost'],$add['dbport'],$add['dbusername'],$add['dbpassword']);
	if(empty($link))
	{
		printerror("FailDbuser","history.go(-1)");
	}
	$empire=new mysqlquery();
	//默认数据库
	if($add['dbname'])
	{
		if($add['dbname']!=$phome_db_dbname)
		{
			$usedb=do_dbquery_common("use `".$add['dbname']."`");
			if(!$usedb)
			{
				printerror("NotDb","history.go(-1)");
			}
		}
	}
	//mysql版本
	if($add['mysqlver']=='auto')
	{
		$add['mysqlver']=Ebak_GetMysqlVerForDb(1);
		if(empty($add['mysqlver']))
		{
			printerror("NotAutoDbVer","history.go(-1)");
		}
	}
	//修改密码
	if($add['adminpassword'])
	{
		if($add['adminpassword']<>$add['adminrepassword'])
		{
			printerror("DiffAdminPassword","history.go(-1)");
		}
		$add['adminpassword']=md5(md5($add['adminpassword']));
		$a="\$set_password='".addslashes($add['adminpassword'])."';\r\n";
	}
	else
	{
		$add['adminpassword']=$set_password;
	}
	//目录
	if(empty($add['sbakpath']))
	{
		$add['sbakpath']="bdata";
	}
	if(!file_exists(RepPathStr($add['sbakpath'])))
	{
		printerror("NotBakpath","history.go(-1)");
	}
	if(empty($add['sbakzippath']))
	{
		$add['sbakzippath']="zip";
	}
	if(!file_exists(RepPathStr($add['sbakzippath'])))
	{
		printerror("NotZippath","history.go(-1)");
	}
	//COOKIE前缀
	if($add['ckvarpre']=='ebak_')
	{
		$rndpre=strtolower(make_password_zm(6));
		$add['ckvarpre']=$rndpre.'_';
	}
	//多服务器
	$moredbservers=Ebak_ReturnUpdateMoreDbServer($add);
	if(empty($add['sebaklang']))
	{
		$add['sebaklang']='gb,gbk';
	}
	$langr=explode(',',$add['sebaklang']);
	$string="<?php
if(!defined('InEmpireBak'))
{
	exit();
}
define('EmpireBakConfig',TRUE);

//Database
\$phome_db_dbtype='".addslashes($add['dbtype'])."';
\$phome_db_ver='".addslashes($add['mysqlver'])."';
\$phome_db_server='".addslashes($add['dbhost'])."';
\$phome_db_port='".addslashes($add['dbport'])."';
\$phome_db_username='".addslashes($add['dbusername'])."';
\$phome_db_password='".addslashes($add['dbpassword'])."';
\$phome_db_dbname='".addslashes($add['dbname'])."';
\$baktbpre='".addslashes($add['sbaktbpre'])."';
\$phome_db_char='".addslashes($add['dbchar'])."';

//USER
\$set_username='".addslashes($add['adminusername'])."';
\$set_password='".addslashes($add['adminpassword'])."';
\$set_loginauth='".addslashes($add['adminloginauth'])."';
\$set_loginrnd='".addslashes($add['adminloginrnd'])."';
\$set_outtime='".addslashes($add['outtime'])."';
\$set_loginkey='".addslashes($add['loginkey'])."';
\$ebak_set_keytime=".intval($add['keytime']).";
\$ebak_set_ckuseragent='".addslashes($add['ckuseragent'])."';

//COOKIE
\$phome_cookiedomain='".addslashes($add['ckdomain'])."';
\$phome_cookiepath='".addslashes($add['ckpath'])."';
\$phome_cookievarpre='".addslashes($add['ckvarpre'])."';

//LANGUAGE
\$langr=ReturnUseEbakLang();
\$ebaklang=\$langr['lang'];
\$ebaklangchar=\$langr['langchar'];

//BAK
\$bakpath='".addslashes($add['sbakpath'])."';
\$bakzippath='".addslashes($add['sbakzippath'])."';
\$filechmod='".addslashes($add['sfilechmod'])."';
\$phpsafemod='".addslashes($add['sphpsafemod'])."';
\$php_outtime='".addslashes($add['sphp_outtime'])."';
\$limittype='".addslashes($add['slimittype'])."';
\$canlistdb='".addslashes($add['scanlistdb'])."';
\$ebak_set_moredbserver='".addslashes($moredbservers)."';
\$ebak_set_hidedbs='".addslashes($add['shidedbs'])."';
\$ebak_set_escapetype='".addslashes($add['sescapetype'])."';

//EBMA
\$ebak_ebma_open=".intval($add['ebmaopen']).";
\$ebak_ebma_path='".addslashes($add['ebmapath'])."';
\$ebak_ebma_cklogin=".intval($add['ebmacklogin']).";

//SYS
\$ebak_set_ckrndvar='".addslashes($addrnd_r['ckrndvar'])."';
\$ebak_set_ckrndval='".addslashes($addrnd_r['ckrndval'])."';
\$ebak_set_ckrndvaltwo='".addslashes($addrnd_r['ckrndvaltwo'])."';
\$ebak_set_ckrndvalthree='".addslashes($addrnd_r['ckrndvalthree'])."';
\$ebak_set_ckrndvalfour='".addslashes($addrnd_r['ckrndvalfour'])."';

//------------ SYSTEM ------------
HeaderIeChar();
?>";
	$filename="class/config.php";
	WriteFiletext_n($filename,$string);
	printerror("SetDbSuccess","SetDb.php");
}

//修复表
function Ebak_Rep($tablename,$dbname){
	global $empire;
	$dbname=RepPostVar($dbname);
	$empire->query("use `$dbname`");
	$count=count($tablename);
	if(empty($count))
	{
		printerror("EmptyChangeTb","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$sql1=$empire->query("REPAIR TABLE `$tablename[$i]`;");
    }
	printerror("RepairTbSuccess","ChangeTable.php?mydbname=$dbname");
}

//忧化表
function Ebak_Opi($tablename,$dbname){
	global $empire;
	$dbname=RepPostVar($dbname);
	$empire->query("use `$dbname`");
	$count=count($tablename);
	if(empty($count))
	{
		printerror("EmptyChangeTb","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$sql1=$empire->query("OPTIMIZE TABLE `$tablename[$i]`;");
    }
	printerror("OptimizeTbSuccess","ChangeTable.php?mydbname=$dbname");
}

//删除数据表
function Ebak_Drop($tablename,$dbname){
	global $empire;
	$dbname=RepPostVar($dbname);
	$empire->query("use `$dbname`");
	$count=count($tablename);
	if(empty($count))
	{printerror("EmptyChangeDelTb","history.go(-1)");}
	$a="";
	$first=1;
	for($i=0;$i<$count;$i++)
	{
		if(empty($first))
		{
			$a.=",";
	    }
		else
		{
			$first=0;
		}
		$a.="`".$tablename[$i]."`";
    }
	$sql1=$empire->query("DROP TABLE IF EXISTS ".$a.";");
	printerror("DelTbSuccess","ChangeTable.php?mydbname=$dbname");
}

//删除数据库
function Ebak_DropDb($dbname){
	global $empire;
	$dbname=RepPostVar($dbname);
	if(empty($dbname))
	{
		printerror("NotChangeDelDb","history.go(-1)");
	}
	$sql=$empire->query("DROP DATABASE `$dbname`");
	if($sql)
	{
		printerror("DelDbSuccess","ChangeDb.php");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//建立数据库
function Ebak_CreatDb($dbname,$dbchar=''){
	global $empire,$phome_db_ver;
	$dbname=RepPostVar($dbname);
	if(!trim($dbname))
	{
		printerror("EmptyDbname","history.go(-1)");
	}
	$a="";
	if($dbchar&&$phome_db_ver>='4.1')
	{
		$a=" DEFAULT CHARACTER SET ".$dbchar;
	}
	$sql=$empire->query("CREATE DATABASE IF NOT EXISTS `$dbname`".$a);
	if($sql)
	{
		printerror("CreateDbSuccess","ChangeDb.php");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//清空表
function Ebak_EmptyTable($tablename,$dbname){
	global $empire;
	$dbname=RepPostVar($dbname);
	$empire->query("use `$dbname`");
	$count=count($tablename);
	if(empty($count))
	{printerror("EmptyChangeTb","history.go(-1)");}
	for($i=0;$i<$count;$i++)
	{
		$sql1=$empire->query("TRUNCATE `".$tablename[$i]."`;");
    }
	printerror("TruncateTbSuccess","ChangeTable.php?mydbname=$dbname");
}

//批量替换表名
function Ebak_ReplaceTable($tablename,$oldpre,$newpre,$dbname){
	global $empire;
	if(!$oldpre)
	{
		printerror("EmptyReplaceTablePre","history.go(-1)");
	}
	$dbname=RepPostVar($dbname);
	$empire->query("use `$dbname`");
	$count=count($tablename);
	if(empty($count))
	{
		printerror("EmptyChangeTb","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$newtbname=str_replace($oldpre,$newpre,$tablename[$i]);
		$empire->query("ALTER TABLE `".$tablename[$i]."` RENAME `".$newtbname."`;");
    }
	printerror("ReplaceTbSuccess","ChangeTable.php?mydbname=$dbname");
}

//保存设置
function Ebak_SaveSeting($add){
	$savename=$add['savename'];
	if(strstr($savename,'.')||strstr($savename,'/')||strstr($savename,"\\"))
	{
		printerror("FailSetSavename","history.go(-1)");
	}
	$baktype=(int)$add['baktype'];
	$filesize=(int)$add['filesize'];
	$bakline=(int)$add['bakline'];
	$autoauf=(int)$add['autoauf'];
	$bakstru=(int)$add['bakstru'];
	$bakstrufour=(int)$add['bakstrufour'];
	$beover=(int)$add['beover'];
	$add['waitbaktime']=(int)$add['waitbaktime'];
	$bakdatatype=(int)$add['bakdatatype'];
	//表列表
	$tblist="";
	$tablename=$add['tablename'];
	$count=count($tablename);
	if($count)
	{
		for($i=0;$i<$count;$i++)
		{
			$tblist.=$tablename[$i].",";
		}
		$tblist=",".$tblist;
	}
	$str="<?php
\$dbaktype=".$baktype.";
\$dfilesize=".$filesize.";
\$dbakline=".$bakline.";
\$dautoauf=".$autoauf.";
\$dbakstru=".$bakstru.";
\$dbakstrufour=".$bakstrufour.";
\$ddbchar='".addslashes($add['dbchar'])."';
\$dmypath='".addslashes($add['mypath'])."';
\$dreadme=\"".addslashes(stripSlashes($add['readme']))."\";
\$dautofield='".addslashes($add['autofield'])."';
\$dtblist='".addslashes($tblist)."';
\$dbeover=".$beover.";
\$dinsertf='".addslashes($add['insertf'])."';
\$dmydbname='".addslashes($add['mydbname'])."';
\$dkeyboard='".addslashes($add['keyboard'])."';
\$dwaitbaktime='".$add['waitbaktime']."';
\$dbakdatatype=".$bakdatatype.";
?>";
	$file="setsave/".$savename;
	WriteFiletext_n($file,$str);
	printerror("SetSaveSuccess","history.go(-1)");
}

//删除设置
function Ebak_DelSeting($add){
	$savename=$add['savename'];
	if(strstr($savename,'.')||strstr($savename,'/')||strstr($savename,"\\"))
	{
		printerror("FailSetSavename","history.go(-1)");
	}
	$file="setsave/".$savename;
	DelFiletext($file);
	printerror("DelSaveSetSuccess","ListSetbak.php?mydbname=$add[mydbname]&change=$add[change]");
}

//删除备份目录
function Ebak_DelBakpath($path){
	global $bakpath;
	if(strstr($path,".."))
	{printerror("NotChangeDelPath","history.go(-1)");}
	if(!trim($path))
	{printerror("NotChangeDelPath","history.go(-1)");}
	$delpath=$bakpath."/".$path;
	if(!file_exists($delpath))
	{
		printerror("DelPathNotExists","history.go(-1)");
    }
	$delpath=DelPath($delpath);
	printerror("DelPathSuccess","ChangePath.php?change=".$_GET['change']);
}

//删除压缩包
function Ebak_DelZip($file){
	global $bakzippath;
	if(strstr($file,".."))
	{printerror("FileNotExists","history.go(-1)",9);}
	if(empty($file))
	{
		printerror("FileNotExists","history.go(-1)",9);
    }
	$filename=$bakzippath."/".$file;
	if(!file_exists($filename))
	{
		printerror("FileNotExists","history.go(-1)",9);
	}
	DelFiletext($filename);
	printerror("DelZipSuccess","history.go(-1)",9);
}

//执行SQL语句
function Ebak_DoExecSql($add){
	global $empire,$phome_db_dbname,$phome_db_ver,$phome_db_char;
	$query=$add['query'];
	if(!$query)
	{
		printerror("EmptyRunSql","history.go(-1)");
    }
	//数据库
	if($add['mydbname'])
	{
		$empire->query("use `".$add['mydbname']."`");
	}
	//编码
	if($add['mydbchar'])
	{
		DoSetDbChar($add['mydbchar']);
	}
	$query=Ebak_ClearAddsData($query);
	Ebak_DoRunQuery($query,$add['mydbchar'],$phome_db_ver);
	printerror("RunSqlSuccess","DoSql.php");
}

//上传执行SQL
function Ebak_DoTranExecSql($file,$file_name,$file_type,$file_size,$add){
	global $empire,$phome_db_dbname,$phome_db_ver,$phome_db_char;
	if(!$file_name||!$file_size)
	{
		printerror("NotChangeSQLFile","history.go(-1)");
	}
	$filetype=GetFiletype($file_name);//取得扩展名
	if($filetype!=".sql")
	{
		printerror("NotTranSQLFile","history.go(-1)");
	}
	//上传文件
	$newfile='tmp/uploadsql'.time().'.sql';
	$cp=Ebak_DoTranFile($file,$newfile);
	if(empty($cp))
	{
		printerror("TranSQLFileFail","history.go(-1)");
	}
	$query=ReadFiletext($newfile);
	DelFiletext($newfile);
	if(!$query)
	{
		printerror("EmptyRunSql","history.go(-1)");
    }
	//数据库
	if($add['mydbname'])
	{
		$empire->query("use `".$add['mydbname']."`");
	}
	//编码
	if($add['mydbchar'])
	{
		DoSetDbChar($add['mydbchar']);
	}
	Ebak_DoRunQuery($query,$add['mydbchar'],$phome_db_ver);
	printerror("RunSqlSuccess","DoSql.php");
}

//替换文件内容
function Ebak_RepPathFiletext($add){
	global $bakpath;
	$mypath=trim($add['mypath']);
	$oldword=Ebak_ClearAddsData($add['oldword']);
	$newword=Ebak_ClearAddsData($add['newword']);
	$dozz=(int)$add['dozz'];
	if(empty($oldword)||empty($mypath))
	{
		printerror("EmptyRepPathFiletext","history.go(-1)");
	}
	if(strstr($mypath,".."))
	{
		printerror("NotChangeRepPathFiletext","history.go(-1)");
	}
	$path=$bakpath."/".$mypath;
	if(!file_exists($path))
	{
		printerror("PathNotExists","history.go(-1)");
    }
	$hand=@opendir($path);
	while($file=@readdir($hand))
	{
		$filename=$path."/".$file;
  		if($file!="."&&$file!=".."&&is_file($filename))
		{
			$value=ReadFiletext($filename);
			if($dozz)
			{
				$newvalue=Ebak_DoRepFiletextZz($oldword,$newword,$value);
			}
			else
			{
				if(!stristr($value,$oldword))
				{
					continue;
				}
				$newvalue=str_replace($oldword,$newword,$value);
			}
			WriteFiletext_n($filename,$newvalue);
		}
	}
	printerror("RepPathFiletextSuccess","RepFiletext.php");
}
?>