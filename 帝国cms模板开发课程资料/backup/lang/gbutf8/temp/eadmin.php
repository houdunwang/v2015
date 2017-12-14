<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎使用帝国备份王</title>
<base onmouseover="window.status='帝国备份王';return true">
<link href="images/css.css" rel="stylesheet" type="text/css">
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
</HEAD>
<BODY scroll="no" style="MARGIN:0px">
<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
  <TBODY>
    <TR> 
      <TD rowspan="2" align="middle" vAlign="center" noWrap id="frmTitle" height="100%"> <IFRAME frameBorder=0 name="ebakleft" scrolling=auto src="left.php" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:190px;Z-INDEX:2"></IFRAME> 
      </TD>
      <TD rowspan="2" bgColor="C7D4F7" height="100%"> <TABLE border=0 cellPadding=0 cellSpacing=0 height="100%">
          <TBODY>
            <tr> 
              <TD onclick="switchSysBar()" style="HEIGHT:100%;"> <font style="COLOR:666666;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:9pt;"> 
                <SPAN id="switchPoint" title="打开/关闭左边导航栏">3</SPAN></font> 
          </TBODY>
        </TABLE></TD>
      <TD style="WIDTH:100%" height="100%"> <table border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
          <tr height=30 bgcolor="C7D4F7"> 
            <td width="40%" bgcolor="C7D4F7">
			<?php
			if($ebak_set_moredbserver)
			{
			?>
			服务器：
			  <select name="chdbserverid" id="chdbserverid" style="width:300">
				<option value='0'>默认服务器</option>
				<?=Ebak_ReturnMoreDbServerList($ebak_set_selfserverid)?>
			  </select>
			  <input type="button" name="Submit" value="切换" title="如果当前页面正在备份或恢复数据过程中请不要切换服务器." onclick="if(confirm('确认要切换服务器?')){parent.location.href='phome.php?phome=ChangeDbServer&from=admin.php&dbserverid='+document.getElementById('chdbserverid').value;}">
			<?php
			}
			?>			</td>
            <td width="25%" bgcolor="C7D4F7"><div align="center"><strong><font color="#0000FF">欢迎使用帝国备份王 [<a href="http://www.phome.net/" target="_blank"><font color="#0000FF">官方网站</font></a>]</font></strong></div></td>
            <td width="35%" bgcolor="C7D4F7"> 
              <div align="right">
                语言：
                  <select name="select" onchange="parent.location.href='phome.php?phome=ChangeLanguage&from=admin.php&l='+this.value;" style="width:300">
                  <?=Ebak_ReturnLang()?>
                </select>&nbsp;&nbsp;
            </div></td>
          </tr>
          <tr>
            <td colspan="3"><IFRAME frameBorder=0 id="ebakmain" name="ebakmain" scrolling="yes" src="main.php" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1"></IFRAME></td>
          </tr>
        </table></TD>
    </TR>
  </TBODY>
</TABLE>
</body>
</html>