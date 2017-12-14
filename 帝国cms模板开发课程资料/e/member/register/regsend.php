<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
if($public_r['regacttype']!=1)
{
	printerror('CloseRegAct','',1);
}
//导入模板
require(ECMS_PATH.'e/template/member/regsend.php');
db_close();
$empire=null;
?>