<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>帝國備份王</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">我的狀態</td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr bgcolor="#FFFFFF"> 
                <td height="25"> <div align="left">登錄者:&nbsp;<b> 
                    <?=$loginin?>
                    </b></div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>
        <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <tr>             
          <td height="38" bgcolor="#FFFFFF">
<div align="center"><a href="http://www.phome.net/ecms72/" target="_blank"><strong><font color="#0000FF" size="3">帝國網站管理系統全面開源 
              － 最安全、最穩定的開源CMS系統</font></strong></a></div></td>
          </tr>
        </table>
      </td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" height="16"><strong><font color="#FFFFFF">帝國備份王(EmpireBak)版權聲明</font></strong></td>
                <td><div align="right"><strong><a href="http://ebak.phome.net" target="_blank"><font color="#FFFFFF">EBMA系統官方網站</font></a></strong></div></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td><strong>如果您想使用本系統(即：帝國備份王)，請詳細閱讀以下條款，只有在接受了以下條款的情況下您才可以使用本系統：</strong></td>
              </tr>
              <tr> 
                <td>1、本程序為免費代碼,提供個人網站免費使用，請勿非法修改、轉載、散播、或用於其他圖利行為，並請勿刪除版權聲明。</td>
              </tr>
              <tr> 
                <td>2、本程序為免費代碼,用戶自由選擇是否使用，在使用中出現任何問題而造成的損失<strong><a href="http://www.phome.net" target="_blank">帝國軟件</a></strong>不負任何責任。 
                </td>
              </tr>
              <tr> 
                <td>3、本程序不允許在沒有事先通知的情況下用於商業用途，假如您需要用於商業用途，請和<a href="http://www.phome.net" target="_blank"><u>我們聯繫</u></a>，以獲得商業使用權。 
                </td>
              </tr>
              <tr> 
                <td>4、如果違反以上條款，<strong><a href="http://www.phome.net" target="_blank">帝國軟件</a></strong>對此保留一切法律追究的權利。</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" height="16"><strong><a href="phpinfo.php" target="_blank"><font color="#FFFFFF">系統信息</font></a></strong></td>
                <td><div align="right"><strong><a href="http://www.phome.net/edown25/" target="_blank"><font color="#FFFFFF">帝國下載系統</font></a></strong></div></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr bgcolor="#FFFFFF"> 
                <td width="40%" height="26">服務器軟件: 
                  <?=EGInfo_GetUseWebServer()?>                </td>
                <td width="60%" height="26">操作系統&nbsp;&nbsp;:
				<?=EGInfo_GetUseSys()?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">PHP版本&nbsp;&nbsp; : <?=EGInfo_GetPHPVersion()?></td>
                <td height="25">MYSQL版本&nbsp;:
				<?php
				$mysqlver=EGInfo_GetMysqlVersion();
				echo $mysqlver?$mysqlver:'未知';
				?>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">全局變量&nbsp;&nbsp;: 
                  <?=EGInfo_GetPHPRGlobals()?'打開':'關閉'?>
                </td>
                <td height="25">上傳文件&nbsp;&nbsp;: 
                  <?=EGInfo_GetPHPFileUploads()?'可以':'不可以'?>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">登錄者IP&nbsp;&nbsp;:
				<?=EGInfo_GetUserIP()?></td>
                <td height="25">當前時間&nbsp;&nbsp;:
				<?=EGInfo_GetDatetime()?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">程序版本&nbsp;&nbsp;: <a href="http://www.phome.net" target="_blank"><strong><font color="#07519A">EmpireBak</font></strong> 
                  <font color="#FF9900"><strong>5.1</strong></font></a> <font color="#666666">[開源版]</font></td>
                <td height="25">安全模式&nbsp;&nbsp;: 
                  <?=EGInfo_GetPHPSafemod()?'PHP運行於安全模式':'正常模式'?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25" colspan="2">程序其它相關信息</td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td height="25">官方主頁: <a href="http://www.phome.net" target="_blank">http://www.phome.net</a></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">官方論壇: <a href="http://bbs.phome.net" target="_blank">http://bbs.phome.net</a></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">公司網站：<a href="http://www.digod.com" target="_blank">http://www.digod.com</a></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="25">帝國產品：<a href="http://www.phome.net/product" target="_blank">http://www.phome.net/product</a></td>
              </tr>
            </table></td>
          <td width="60%" height="125" valign="top" bgcolor="#FFFFFF">
<IFRAME frameBorder="0" name="getinfo" scrolling="no" src="ginfo.php" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:2"></IFRAME></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="32" valign="bottom"> 
      <div align="center">Powered by <a href="http://www.phome.net" target="_blank"><strong><font color="#07519A">EmpireBak</font></strong> 
        <font color="#FF9900"><strong>5.1</strong></font></a></div></td>
  </tr>
</table>
</body>
</html>