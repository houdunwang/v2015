<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
hCheckEcmsRHash();
db_close();
$empire=null;

//取得汉字
$hz=ehtmlspecialchars($_GET['hz']);
$returnform=RepPostVar($_GET['returnform']);
if(empty($hz)||empty($returnform))
{
	echo"<script>alert('没输入汉字!');window.close();</script>";
	exit();
}

$py=ReturnPinyinFun($hz);
?>
<script>
<?=$returnform?>="<?=$py?>";
window.close();
</script>
