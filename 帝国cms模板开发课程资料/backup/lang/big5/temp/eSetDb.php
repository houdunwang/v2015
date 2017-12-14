<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<?php
$canconnectdbtype=Ebak_ReturnMysqlConnectType();

$mrexp='|ebak|';
$mfexp='!ebak!';
$moredbserver_r=explode($mrexp,$ebak_set_moredbserver);
$moredbcount=count($moredbserver_r);
if(empty($ebak_set_moredbserver))
{
	$moredbcount=0;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>參數設置</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangeSet(cset){
	if(cset=="setuser")
	{
		setdb.style.display="none";
		setuser.style.display="";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="none";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#DBEAF5";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#ffffff";
	}
	else if(cset=="setck")
	{
		setdb.style.display="none";
		setuser.style.display="none";
		setck.style.display="";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="none";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#DBEAF5";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#ffffff";
	}
	else if(cset=="setlang")
	{
		setdb.style.display="none";
		setuser.style.display="none";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="none";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#ffffff";
	}
	else if(cset=="setother")
	{
		setdb.style.display="none";
		setuser.style.display="none";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="";
		setmdbs.style.display="none";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#DBEAF5";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#ffffff";
	}
	else if(cset=="setmdbs")
	{
		setdb.style.display="none";
		setuser.style.display="none";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#DBEAF5";
		setebmabg.style.backgroundColor="#ffffff";
	}
	else if(cset=="setebma")
	{
		setdb.style.display="none";
		setuser.style.display="none";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="none";
		setebma.style.display="";

		setdbbg.style.backgroundColor="#ffffff";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#DBEAF5";
	}
	else
	{
		setdb.style.display="";
		setuser.style.display="none";
		setck.style.display="none";
		//setlang.style.display="none";
		setother.style.display="none";
		setmdbs.style.display="none";
		setebma.style.display="none";

		setdbbg.style.backgroundColor="#DBEAF5";
		setuserbg.style.backgroundColor="#ffffff";
		setckbg.style.backgroundColor="#ffffff";
		setotherbg.style.backgroundColor="#ffffff";
		setmdbsbg.style.backgroundColor="#ffffff";
		setebmabg.style.backgroundColor="#ffffff";
	}
}

function eGetChangeMysqlVer(){
	var dbver='';
	var radios=document.getElementsByName('mysqlver');
	for(var i=0;i<radios.length;i++)
	{
		if(radios[i].checked)
		{
			dbver=radios[i].value;
		}
	}
	return dbver;
}

//檢測默認數據庫參數
function EbakCheckDefDbServer(){
	var mdbver='';
	mdbver=eGetChangeMysqlVer();
	document.checkdbconnectform.checkdbserverid.value=0;
	document.checkdbconnectform.checkdbver.value=mdbver;
	document.checkdbconnectform.checkdbhost.value=document.form1.dbhost.value;
	document.checkdbconnectform.checkdbport.value=document.form1.dbport.value;
	document.checkdbconnectform.checkdbuser.value=document.form1.dbusername.value;
	document.checkdbconnectform.checkdbpass.value=document.form1.dbpassword.value;
	document.checkdbconnectform.checkdbname.value=document.form1.dbname.value;
	document.checkdbconnectform.checkdbtbpre.value=document.form1.sbaktbpre.value;
	document.checkdbconnectform.checkdbchar.value=document.form1.dbchar.value;
	document.checkdbconnectform.submit();
}

//檢測數據庫參數
function EbakCheckDbServer(serverid){
	document.checkdbconnectform.checkdbserverid.value=serverid;
	document.checkdbconnectform.checkdbver.value=document.getElementById('moredbver'+serverid).value;
	document.checkdbconnectform.checkdbhost.value=document.getElementById('moredbhost'+serverid).value;
	document.checkdbconnectform.checkdbport.value=document.getElementById('moredbport'+serverid).value;
	document.checkdbconnectform.checkdbuser.value=document.getElementById('moredbuser'+serverid).value;
	document.checkdbconnectform.checkdbpass.value=document.getElementById('moredbpass'+serverid).value;
	document.checkdbconnectform.checkdbname.value=document.getElementById('moredbname'+serverid).value;
	document.checkdbconnectform.checkdbtbpre.value=document.getElementById('moredbtbpre'+serverid).value;
	document.checkdbconnectform.checkdbchar.value=document.getElementById('moredbchar'+serverid).value;
	document.checkdbconnectform.submit();
}

//增加數據庫服務器
function EbakShowAddDbServer(){
	var i;
	var str="";
	var oldi=0;
	var j=0;
	oldi=parseInt(document.form1.dbservernum.value);
	j=oldi+1;
	str=str+"<table width='100%' border=0 cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'><tr><td bgcolor='#FFFFFF' width='3%'><div align=center>"+j+"</div></td><td height=25 bgcolor='#FFFFFF' width='10%'><select name=moredbver[] id='moredbver"+j+"'><option value='5.0'>5.0及以上</option><option value='4.1'>4.1</option><option value='4.0'>4.0.*/3.*</option></select></td><td bgcolor='#FFFFFF' width='34%'><input name=moredbhost[] type=text id='moredbhost"+j+"'> <a href='#empirebak' onclick=EbakCheckDbServer('"+j+"')>[測試]</a></td><td bgcolor='#FFFFFF' width='7%'><input name=moredbport[] type=text id='moredbport"+j+"' size=6></td><td bgcolor='#FFFFFF' width='10%'><input name=moredbuser[] type=text id='moredbuser"+j+"' size=12></td><td bgcolor='#FFFFFF' width='10%'><input name=moredbpass[] type=password id='moredbpass"+j+"' size=12></td><td bgcolor='#FFFFFF' width='9%'><input name=moredbname[] type=text id='moredbname"+j+"' size=12></td><td bgcolor='#FFFFFF' width='9%'><input name=moredbtbpre[] type=text id='moredbtbpre"+j+"' size=10></td><td bgcolor='#FFFFFF' width='8%'><input name=moredbchar[] type=text id='moredbchar"+j+"' size=8></td></tr></table>";
	document.getElementById("adddbserverdiv").innerHTML+=str;
	document.form1.dbservernum.value=oldi+1;
}

//驗證默認
function EbakCheckIsDefPass(obj){
	<?php
	if(empty($phome_db_ver))
	{
	?>
	var defpass='';
	var defloginrnd='EmpireCMS-EmpireBak-EmpireDown';
	var thispass=obj.adminpassword.value;
	var thisloginrnd=obj.adminloginrnd.value;
	if(thispass=='')
	{
		alert('請修改默認的管理密碼和驗證隨機碼 (管理員設置)');
		return false;
	}
	if(defloginrnd==thisloginrnd)
	{
		alert('請修改默認的管理密碼和驗證隨機碼 (管理員設置)');
		return false;
	}
	<?php
	}
	?>
	return true;
}

//驗證表單
function EbakCheckForm(obj){
	var isok;
	if(obj.adminpassword.value!=obj.adminrepassword.value)
	{
		alert('輸入的兩次管理員密碼不一致 (管理員設置)');
		return false;
	}
	isok=EbakCheckIsDefPass(obj);
	return isok;
}

</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="SetDb.php">全局參數設置</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr bgcolor="#FFFFFF"> 
    <td width="18%" height="23" id="setdbbg" onmouseover="ChangeSet('setdb');" bgcolor="#DBEAF5"> 
      <div align="center"><strong><a href="#ebak">數據庫設置</a></strong></div></td>
    <td width="18%" id="setuserbg" onmouseover="ChangeSet('setuser');"> 
      <div align="center"><strong><a href="#ebak">管理員設置</a></strong></div></td>
    <td width="16%" id="setckbg" onmouseover="ChangeSet('setck');"> 
      <div align="center"><strong><a href="#ebak">COOKIE設置</a></strong></div></td>
	<td width="16%" id="setmdbsbg" onmouseover="ChangeSet('setmdbs');"> 
      <div align="center"><strong><a href="#ebak">多服務器設置</a></strong></div></td>
	<td width="16%" id="setebmabg" onmouseover="ChangeSet('setebma');"<?=$haveebma==0?' style="display:none"':''?>> 
      <div align="center"><strong><a href="#ebak">EBMA設置</a></strong></div></td>
    <td width="16%" id="setotherbg" onmouseover="ChangeSet('setother');"> 
      <div align="center"><strong><a href="#ebak">其它設置</a></strong></div></td>
  </tr>
</table>

<form name="form1" method="post" action="phome.php" onsubmit="return EbakCheckForm(document.form1);">
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setdb">
    <tr class="header"> 
      <td height="25" colspan="2">數據庫設置 
        <input name="phome" type="hidden" id="phome" value="SetDb">        </td>
    </tr>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">MYSQL接口類型</td>
      <td height="25" bgcolor="#FFFFFF">
		<select name="dbtype">
		<?php
		if($canconnectdbtype==1||$canconnectdbtype==3||$canconnectdbtype==0)
		{
		?>
          <option value="mysql"<?=$phome_db_dbtype=='mysql'||$phome_db_dbtype==''?' selected':''?>>mysql</option>
		<?php
		}
		if($canconnectdbtype==2||$canconnectdbtype==3)
		{
		?>
		  <option value="mysqli"<?=$phome_db_dbtype=='mysqli'?' selected':''?>>mysqli</option>
		<?php
		}
		?>
        </select>
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><strong>MYSQL版本</strong></td>
      <td height="25" bgcolor="#FFFFFF"><p> 
          <input type="radio" name="mysqlver" id="mysqlver" value="5.0"<?=$phome_db_ver>='5.0'?' checked':''?>>
          MYSQL5.*及以上&nbsp;&nbsp; 
          <input type="radio" name="mysqlver" id="mysqlver" value="4.1"<?=$phome_db_ver=='4.1'?' checked':''?>>
          MYSQL 4.1.*&nbsp;&nbsp; 
          <input type="radio" name="mysqlver" id="mysqlver" value="4.0"<?=$phome_db_ver=='4.0'?' checked':''?>>
          MYSQL 4.0.*/3.*&nbsp;&nbsp; 
          <input type="radio" name="mysqlver" id="mysqlver" value="auto"<?=$phome_db_ver==''?' checked':''?>>
          自動選擇</p></td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF"><strong>數據庫服務器</strong></td>
      <td width="76%" height="25" bgcolor="#FFFFFF"><input name="dbhost" type="text" id="dbhost" value="<?=$phome_db_server?>"> 
        <font color="#666666">(比如：localhost)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">數據庫服務器端口</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbport" type="text" id="dbport" value="<?=$phome_db_port?>"> 
        <font color="#666666">(一般情況下為空即可)</font> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><strong>數據庫用戶名</strong></td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbusername" type="text" id="dbusername" value="<?=$phome_db_username?>"> 
        <font color="#666666">(比如：root)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><strong>數據庫密碼</strong></td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbpassword" type="password" id="dbpassword">
        (<font color="#FF0000">不想修改請留空。無密碼用「null」表示</font>)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">默認備份的數據庫</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbname" type="text" id="dbname" value="<?=$phome_db_dbname?>"> 
        <font color="#666666">(可為空,如輸入數據庫名,備份直接轉到這個庫.) </font></td>
    </tr>
	<tr>
      <td height="25" bgcolor="#FFFFFF">默認備份數據表的前綴</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbaktbpre" type="text" id="sbaktbpre" value="<?=$baktbpre?>">
        <font color="#666666">(空為列出所有數據表.)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">默認編碼</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbchar" type="text" id="dbchar" value="<?=$phome_db_char?>"> 
        <font color="#666666"> 
        <select name="selectchar" onchange="document.form1.dbchar.value=this.value">
          <option value="">選擇</option>
          <?php
				echo Ebak_ReturnDbCharList('');
				?>
        </select>
        (一般情況下為空即可) </font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"><strong>[<a href="#empirebak" onclick="EbakCheckDefDbServer();">測試數據庫信息</a>]</strong>&nbsp;&nbsp;<font color="#666666">(填寫數據庫參數後，可以點擊測試上面的參數是否正確)</font></td>
    </tr>
  </table>
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setuser" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">管理員設置</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">用戶名</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminusername" type="text" id="adminusername" value="<?=$set_username?>">
        <font color="#666666">(修改後要重新登錄，8~30個字符)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">密碼</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminpassword" type="password" id="adminpassword"> 
        <font color="#666666">(不想修改請留空, 修改後要重新登錄，8~30個字符，區分大小寫)</font></td>
    </tr>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">重複密碼</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminrepassword" type="password" id="adminrepassword"> 
        <font color="#666666">(不想修改請留空)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">認證碼</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adminloginauth" type="password" id="adminloginauth" value="<?=$set_loginauth?>">
        <font color="#666666">(二級密碼,空為不設置，不限字符數)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">驗證隨機碼</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adminloginrnd" type="text" id="adminloginrnd" value="<?=$set_loginrnd?>">
        <font color="#666666">
        <input type="button" name="Submit3" value="隨機" onclick="document.form1.adminloginrnd.value='<?=$loginauthrnd?>';">
        (修改後要重新登錄，不限字符數)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">超時限制</td>
      <td height="25" bgcolor="#FFFFFF"><input name="outtime" type="text" id="outtime" value="<?=$set_outtime?>">
        分鐘</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">登錄是否需要驗證碼</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="loginkey" value="0"<?=$set_loginkey==0?' checked':''?>>
        是 
        <input type="radio" name="loginkey" value="1"<?=$set_loginkey==1?' checked':''?>>
        否</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">驗證碼過期時間</td>
      <td height="25" bgcolor="#FFFFFF"><input name="keytime" type="text" id="keytime" value="<?=$ebak_set_keytime?>">
        秒 <font color="#666666">(時間越短效果越好)</font></td>
    </tr>
	<tr>
      <td rowspan="2" valign="top" bgcolor="#FFFFFF">後台訪問的UserAgent包含</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckuseragent" type="text" id="ckuseragent" value="<?=$ebak_set_ckuseragent?>" size="50"></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF"><font color="#666666">(區分大小寫，多個用「||」半角雙豎線隔開，設置後UserAgent信息必須同時包含這些字符才能訪問後台)</font></td>
    </tr>
  </table>
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setck" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">COOKIE設置(通常不需要修改)</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">COOKIE作用域</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckdomain" type="text" id="ckdomain" value="<?=$phome_cookiedomain?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE作用路徑</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckpath" type="text" id="ckpath" value="<?=$phome_cookiepath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE變量前綴</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckvarpre" type="text" id="ckvarpre" value="<?=$phome_cookievarpre?>"></td>
    </tr>
  </table>	
		
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setmdbs" style="display:none">
    <tr class="header"> 
      <td height="25">多數據庫服務器設置(方便同時備份多台服務器的數據庫)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
        <input name="dbservernum" type="hidden" id="dbservernum" value="<?=$moredbcount?>">
        <tr>
          <td width="3%"><div align="center"></div></td>
          <td width="10%" height="25">MYSQL版本</td>
          <td width="34%">數據庫服務器鏈接地址</td>
          <td width="7%">端口</td>
          <td width="10%">用戶名</td>
          <td width="10%">密碼</td>
          <td width="9%">默認數據庫名</td>
          <td width="9%">默認表前綴</td>
          <td width="8%">默認編碼</td>
        </tr>
		</table>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
        <tbody id="havedbserverdiv">
          <?php
if($ebak_set_moredbserver)
{
	for($mdi=0;$mdi<$moredbcount;$mdi++)
	{
		$moredbserver_fr=explode($mfexp,$moredbserver_r[$mdi]);
		$dbserverid=$mdi+1;
	?>
          <tr>
            <td bgcolor="#FFFFFF" width="3%"><div align="center">
              <?=$dbserverid?>
            </div></td>
            <td height="25" bgcolor="#FFFFFF" width="10%"><select name="moredbver[]" id="moredbver<?=$dbserverid?>">
                <option value="5.0"<?=$moredbserver_fr[0]>='5.0'?' selected':''?>>5.0及以上</option>
                <option value="4.1"<?=$moredbserver_fr[0]=='4.1'?' selected':''?>>4.1.*</option>
                <option value="4.0"<?=$moredbserver_fr[0]=='4.0'?' selected':''?>>4.0.*/3.*</option>
              </select>
            </td>
            <td bgcolor="#FFFFFF" width="34%"><input name="moredbhost[]" type="text" id="moredbhost<?=$dbserverid?>" value="<?=$moredbserver_fr[1]?>"> <a href="#empirebak" onclick="EbakCheckDbServer('<?=$dbserverid?>');">[測試]</a>
                <input name="dbserverid[]" type="hidden" id="dbserverid<?=$dbserverid?>" value="<?=$dbserverid?>">
            </td>
            <td bgcolor="#FFFFFF" width="7%"><input name="moredbport[]" type="text" id="moredbport<?=$dbserverid?>" value="<?=$moredbserver_fr[2]?>" size="6"></td>
            <td bgcolor="#FFFFFF" width="10%"><input name="moredbuser[]" type="text" id="moredbuser<?=$dbserverid?>" value="<?=$moredbserver_fr[3]?>" size="12"></td>
            <td bgcolor="#FFFFFF" width="10%"><input name="moredbpass[]" type="password" id="moredbpass<?=$dbserverid?>" value="<?=$moredbserver_fr[4]?>" size="12"></td>
            <td bgcolor="#FFFFFF" width="9%"><input name="moredbname[]" type="text" id="moredbname<?=$dbserverid?>" value="<?=$moredbserver_fr[5]?>" size="12"></td>
            <td bgcolor="#FFFFFF" width="9%"><input name="moredbtbpre[]" type="text" id="moredbtbpre<?=$dbserverid?>" value="<?=$moredbserver_fr[6]?>" size="10"></td>
            <td bgcolor="#FFFFFF" width="8%"><input name="moredbchar[]" type="text" id="moredbchar<?=$dbserverid?>" value="<?=$moredbserver_fr[7]?>" size="8"></td>
          </tr>
          <?php
	}
}
?>
		</tbody>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td id="adddbserverdiv"></td>
		</tr>
		</table>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
        <tr>
          <td height="25" colspan="9" bgcolor="#FFFFFF"><strong><a href="#empirebak" onclick="EbakShowAddDbServer();"><font color="#FF9900">[+]增加服務器</font></a></strong></td>
        </tr>
        <tr>
          <td height="25" colspan="9" bgcolor="#FFFFFF"><font color="#666666">如果要刪除服務器，只需把「服務器地址」設置為空。填寫數據庫信息後可以點「[測試]」檢測信息是否正確。更新服務器後請刷新後台主界面以便顯示更新。</font></td>
        </tr>
      </table></td>
    </tr>
  </table>		
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setother" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">其他設置</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">數據備份目錄</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbakpath" type="text" id="sbakpath" value="<?=$bakpath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">壓縮包存放目錄</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbakzippath" type="text" id="sbakzippath" value="<?=$bakzippath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">文件生成權限設置</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="sfilechmod" value="0"<?=$filechmod0?>>
        0777 
        <input type="radio" name="sfilechmod" value="1"<?=$filechmod1?>>
        不限制<font color="#666666">(如果空間不支持運行0777的.php文件,選擇不限制即可.)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">PHP運行於安全模式</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sphpsafemod" type="checkbox" id="sphpsafemod" value="1"<?=$phpsafemod==1?' checked':''?>>
        是<font color="#666666">(如果運行於安全模式，所有數據均備份到bdata/safemod目錄)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">PHP超時時間設置</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sphp_outtime" type="text" id="sphp_outtime" value="<?=$php_outtime?>" size="6">
        秒 <font color="#666666">(一般不需要設置，需要set_time_limit()支持才有效)</font></td>
    </tr>
    <tr> 
      <td rowspan="2" bgcolor="#FFFFFF"> <p>MYSQL支持查詢方式</p></td>
      <td height="25" bgcolor="#FFFFFF"><input name="slimittype" type="checkbox" id="slimittype" value="1"<?=$checklimittype?>>
        支持 <font color="#666666">(如果備份時出現下面錯誤,請將打勾去掉即可解決)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><font color="#FF0000">You have an error 
        in your SQL syntax; check the manual that corresponds to your MySQL server 
        version for the right syntax to use near '-1' at line 1</font></td>
    </tr>
	<tr>
      <td height="25" bgcolor="#FFFFFF">空間不支持數據庫列表</td>
      <td height="25" bgcolor="#FFFFFF"><input name="scanlistdb" type="checkbox" id="scanlistdb" value="1"<?=$canlistdb==1?' checked':''?>>
        不支持<font color="#666666">(如果空間不允許列出數據庫,請打勾；並且要設置默認備份的數據庫)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">隱藏數據庫顯示</td>
	  <td height="25" bgcolor="#FFFFFF"><input name="shidedbs" type="text" id="shidedbs" value="<?=$ebak_set_hidedbs?>">
        <font color="#666666">(多個數據庫名用半角逗號&quot;,&quot;隔開，比如：dbname1,dbname2)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">導出數據處理函數</td>
	  <td height="25" bgcolor="#FFFFFF"><select name="sescapetype" id="sescapetype">
        <option value="1"<?=$ebak_set_escapetype==1?' selected':''?>>addslashes()</option>
        <option value="2"<?=$ebak_set_escapetype==2?' selected':''?>>mysql_real_escape_string()</option>
      </select>
        <font color="#666666">(通常按默認即可)</font></td>
    </tr>
  </table>		
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setebma" style="display:none">
	<tr class="header">
	  <td height="25" colspan="2"><strong>EBMA設置 </strong>(<strong>E</strong>mpire<strong>B</strong>ak+php<strong>M</strong>y<strong>A</strong>dmin)</td>
    </tr>
	<tr>
	  <td width="24%" height="25" bgcolor="#FFFFFF">是否開啟phpmyadmin</td>
	  <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ebmaopen" value="1"<?=$ebak_ebma_open==1?' checked':''?>>開啟
        <input type="radio" name="ebmaopen" value="0"<?=$ebak_ebma_open==0?' checked':''?>>關閉
      <font color="#666666">(可以要使用時開啟，不使用時關閉)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">phpmyadmin目錄</td>
	  <td height="25" bgcolor="#FFFFFF">eapi/
      <input name="ebmapath" type="text" id="ebmapath" value="<?=$ebak_ebma_path?>">
      <font color="#666666">(修改目錄：先重命名eapi/phpmyadmin目錄，然後再修改這裡)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">開啟phpmyadmin二次驗證</td>
	  <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ebmacklogin" value="0"<?=$ebak_ebma_cklogin==0?' checked':''?>>開啟
          <input type="radio" name="ebmacklogin" value="1"<?=$ebak_ebma_cklogin==1?' checked':''?>>關閉 <font color="#666666">(開啟後，進入phpmyadmin需要再次登錄數據庫，即：帝國備份王驗證+PMA本身雙重驗證)</font>	  
	  </td>
    </tr>
  </table>
	<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
	<?php
	if(empty($phome_db_ver))
	{
	?>
    <tr>
      <td height="30" colspan="2" bgcolor="#FFFFFF"><font color="#FF0000">首次安裝帝國備份王，請修改<strong>管理員設置</strong>裡的默認<strong>管理密碼</strong>和<strong>驗證隨機碼</strong>。修改後需要重新登錄後台。(至於默認<strong>用戶名</strong>不強制，但官方推薦也修改)</font></td>
    </tr>
	<?php
	}
	?>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"> <div align="left"> 
          <input type="submit" name="Submit" value=" 設置 ">&nbsp;&nbsp;
          <input type="reset" name="Submit2" value="重置">
        </div></td>
    </tr>
  </table>
</form>

  <table width="100%" border="0" cellspacing="1" cellpadding="3" style="display:none">
  <form name="checkdbconnectform" id="checkdbconnectform" method="post" action="phome.php" target="checkpostdataiframe">
    <tr>
      <td>
	  	<input name="phome" type="hidden" id="phome" value="CheckConnectDbServer">
		<input name="checkdbserverid" type="hidden" id="checkdbserverid" value="">
		<input name="checkdbver" type="hidden" id="checkdbver" value="">
		<input name="checkdbhost" type="hidden" id="checkdbhost" value="">
		<input name="checkdbport" type="hidden" id="checkdbport" value="">
		<input name="checkdbuser" type="hidden" id="checkdbuser" value="">
		<input name="checkdbpass" type="hidden" id="checkdbpass" value="">
		<input name="checkdbname" type="hidden" id="checkdbname" value="">
		<input name="checkdbtbpre" type="hidden" id="checkdbtbpre" value="">
		<input name="checkdbchar" type="hidden" id="checkdbchar" value="">
	  </td>
    </tr>
	<iframe name="checkpostdataiframe" id="checkpostdataiframe" style="display: none" src="blank.html"></iframe>
  </form>
  </table>

</body>
</html>