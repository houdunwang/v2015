<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=(int)$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

//变量
$leftfile=hRepPostStr($_GET['leftfile'],1);
$mainfile=hRepPostStr($_GET['mainfile'],1);
$title=hRepPostStr($_GET['title'],1);
if(empty($leftfile))
{
	$leftfile='left.php';
}
if(empty($mainfile))
{
	$mainfile='main.php';
}
if(empty($title))
{
	$title='管理';
}
?>
<HTML>
<HEAD>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</HEAD>
<script language=javascript>
var ie = (document.all) ? true : false;
function changeColor(j){
	if(j < 0) return;
	(ie)?chIE(j,idb):chNS(j,idb.document);
}
function chIE(j,obj){
with(obj){
	document.bgColor = j;
}}
function chNS(j,obj){
with(obj){
	bgColor = j;
}}
</script>
<SCRIPT>
function switchSysBar(){
if (switchPoint.innerText==3){
switchPoint.innerText=4
document.all("frmTitle").style.display="none"
}else{
switchPoint.innerText=3
document.all("frmTitle").style.display=""
}}
</SCRIPT>
<body leftmargin="0" topmargin="0">
<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
  <TBODY>
    <TR> 
      <TD rowspan="2" align=middle vAlign=center noWrap id="frmTitle"> <IFRAME frameBorder=0 id="apleft" name="apleft" scrolling=yes src="<?=$leftfile?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:190px;Z-INDEX:2"></IFRAME> 
      </TD>
      <TD rowspan="2" bgColor="#D0D0D0"> <TABLE border=0 cellPadding=0 cellSpacing=0 height="100%">
          <TBODY>
            <tr> 
              <TD onclick="switchSysBar()" style="HEIGHT:100%;"> <font style="COLOR:666666;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:9pt;"> 
                <SPAN id="switchPoint" title="打开/关闭左边导航栏">3</SPAN></font> 
          </TBODY>
        </TABLE></TD>
      <TD style="WIDTH:100%"> 
	  		<table border=0 cellPadding=0 cellSpacing=0 height=100% width=100%><tr height=30 bgcolor=C7D4F7>
            <td height="27" bgcolor="#D0D0D0"><strong><?=$title?></strong></td>
          	</tr><tr><td><IFRAME frameBorder=0 id="apmain" name="apmain" scrolling=yes src="<?=$mainfile?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1"></IFRAME></td></tr>
		 	</table>
	</TD>
    </TR>
  </TBODY>
</TABLE>
</body>
</html>
<?php
db_close();
$empire=null;
?>