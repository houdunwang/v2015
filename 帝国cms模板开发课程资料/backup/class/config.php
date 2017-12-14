<?php
if(!defined('InEmpireBak'))
{
	exit();
}
define('EmpireBakConfig',TRUE);

//Database
$phome_db_dbtype='mysql';
$phome_db_ver='5.0';
$phome_db_server='localhost';
$phome_db_port='';
$phome_db_username='root';
$phome_db_password='root';
$phome_db_dbname='';
$baktbpre='';
$phome_db_char='';

//USER
$set_username='admin';
$set_password='0b77520f93de693bdab0060746e38165';
$set_loginauth='';
$set_loginrnd='U2UPs8yisrmqPPGrGHr8jfJw6wdjKJ';
$set_outtime='60';
$set_loginkey='1';
$ebak_set_keytime=60;
$ebak_set_ckuseragent='';

//COOKIE
$phome_cookiedomain='';
$phome_cookiepath='/';
$phome_cookievarpre='ajdxll_';

//LANGUAGE
$langr=ReturnUseEbakLang();
$ebaklang=$langr['lang'];
$ebaklangchar=$langr['langchar'];

//BAK
$bakpath='bdata';
$bakzippath='zip';
$filechmod='1';
$phpsafemod='';
$php_outtime='1000';
$limittype='';
$canlistdb='';
$ebak_set_moredbserver='';
$ebak_set_hidedbs='';
$ebak_set_escapetype='1';

//EBMA
$ebak_ebma_open=1;
$ebak_ebma_path='phpmyadmin';
$ebak_ebma_cklogin=0;

//SYS
$ebak_set_ckrndvar='fldbxtvufmnc';
$ebak_set_ckrndval='46bb19eb89637bc190e9cc2f3407f964';
$ebak_set_ckrndvaltwo='f4a8a67c4e9d950805240663061af8a4';
$ebak_set_ckrndvalthree='7f0fd725610c1439e5a8780c6fe0ec45';
$ebak_set_ckrndvalfour='2beb79fc080a99cf3fa0b8c61abb5250';

//------------ SYSTEM ------------
HeaderIeChar();
?>