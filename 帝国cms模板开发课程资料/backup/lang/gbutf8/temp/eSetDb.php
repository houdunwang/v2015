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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>参数设置</title>
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

//检测默认数据库参数
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

//检测数据库参数
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

//增加数据库服务器
function EbakShowAddDbServer(){
	var i;
	var str="";
	var oldi=0;
	var j=0;
	oldi=parseInt(document.form1.dbservernum.value);
	j=oldi+1;
	str=str+"<table width='100%' border=0 cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'><tr><td bgcolor='#FFFFFF' width='3%'><div align=center>"+j+"</div></td><td height=25 bgcolor='#FFFFFF' width='10%'><select name=moredbver[] id='moredbver"+j+"'><option value='5.0'>5.0及以上</option><option value='4.1'>4.1</option><option value='4.0'>4.0.*/3.*</option></select></td><td bgcolor='#FFFFFF' width='34%'><input name=moredbhost[] type=text id='moredbhost"+j+"'> <a href='#empirebak' onclick=EbakCheckDbServer('"+j+"')>[测试]</a></td><td bgcolor='#FFFFFF' width='7%'><input name=moredbport[] type=text id='moredbport"+j+"' size=6></td><td bgcolor='#FFFFFF' width='10%'><input name=moredbuser[] type=text id='moredbuser"+j+"' size=12></td><td bgcolor='#FFFFFF' width='10%'><input name=moredbpass[] type=password id='moredbpass"+j+"' size=12></td><td bgcolor='#FFFFFF' width='9%'><input name=moredbname[] type=text id='moredbname"+j+"' size=12></td><td bgcolor='#FFFFFF' width='9%'><input name=moredbtbpre[] type=text id='moredbtbpre"+j+"' size=10></td><td bgcolor='#FFFFFF' width='8%'><input name=moredbchar[] type=text id='moredbchar"+j+"' size=8></td></tr></table>";
	document.getElementById("adddbserverdiv").innerHTML+=str;
	document.form1.dbservernum.value=oldi+1;
}

//验证默认
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
		alert('请修改默认的管理密码和验证随机码 (管理员设置)');
		return false;
	}
	if(defloginrnd==thisloginrnd)
	{
		alert('请修改默认的管理密码和验证随机码 (管理员设置)');
		return false;
	}
	<?php
	}
	?>
	return true;
}

//验证表单
function EbakCheckForm(obj){
	var isok;
	if(obj.adminpassword.value!=obj.adminrepassword.value)
	{
		alert('输入的两次管理员密码不一致 (管理员设置)');
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
    <td>位置：<a href="SetDb.php">全局参数设置</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr bgcolor="#FFFFFF"> 
    <td width="18%" height="23" id="setdbbg" onmouseover="ChangeSet('setdb');" bgcolor="#DBEAF5"> 
      <div align="center"><strong><a href="#ebak">数据库设置</a></strong></div></td>
    <td width="18%" id="setuserbg" onmouseover="ChangeSet('setuser');"> 
      <div align="center"><strong><a href="#ebak">管理员设置</a></strong></div></td>
    <td width="16%" id="setckbg" onmouseover="ChangeSet('setck');"> 
      <div align="center"><strong><a href="#ebak">COOKIE设置</a></strong></div></td>
	<td width="16%" id="setmdbsbg" onmouseover="ChangeSet('setmdbs');"> 
      <div align="center"><strong><a href="#ebak">多服务器设置</a></strong></div></td>
	<td width="16%" id="setebmabg" onmouseover="ChangeSet('setebma');"<?=$haveebma==0?' style="display:none"':''?>> 
      <div align="center"><strong><a href="#ebak">EBMA设置</a></strong></div></td>
    <td width="16%" id="setotherbg" onmouseover="ChangeSet('setother');"> 
      <div align="center"><strong><a href="#ebak">其它设置</a></strong></div></td>
  </tr>
</table>

<form name="form1" method="post" action="phome.php" onsubmit="return EbakCheckForm(document.form1);">
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setdb">
    <tr class="header"> 
      <td height="25" colspan="2">数据库设置 
        <input name="phome" type="hidden" id="phome" value="SetDb">        </td>
    </tr>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">MYSQL接口类型</td>
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
          自动选择</p></td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF"><strong>数据库服务器</strong></td>
      <td width="76%" height="25" bgcolor="#FFFFFF"><input name="dbhost" type="text" id="dbhost" value="<?=$phome_db_server?>"> 
        <font color="#666666">(比如：localhost)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">数据库服务器端口</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbport" type="text" id="dbport" value="<?=$phome_db_port?>"> 
        <font color="#666666">(一般情况下为空即可)</font> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><strong>数据库用户名</strong></td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbusername" type="text" id="dbusername" value="<?=$phome_db_username?>"> 
        <font color="#666666">(比如：root)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><strong>数据库密码</strong></td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbpassword" type="password" id="dbpassword">
        (<font color="#FF0000">不想修改请留空。无密码用“null”表示</font>)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">默认备份的数据库</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbname" type="text" id="dbname" value="<?=$phome_db_dbname?>"> 
        <font color="#666666">(可为空,如输入数据库名,备份直接转到这个库.) </font></td>
    </tr>
	<tr>
      <td height="25" bgcolor="#FFFFFF">默认备份数据表的前缀</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbaktbpre" type="text" id="sbaktbpre" value="<?=$baktbpre?>">
        <font color="#666666">(空为列出所有数据表.)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">默认编码</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dbchar" type="text" id="dbchar" value="<?=$phome_db_char?>"> 
        <font color="#666666"> 
        <select name="selectchar" onchange="document.form1.dbchar.value=this.value">
          <option value="">选择</option>
          <?php
				echo Ebak_ReturnDbCharList('');
				?>
        </select>
        (一般情况下为空即可) </font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"><strong>[<a href="#empirebak" onclick="EbakCheckDefDbServer();">测试数据库信息</a>]</strong>&nbsp;&nbsp;<font color="#666666">(填写数据库参数后，可以点击测试上面的参数是否正确)</font></td>
    </tr>
  </table>
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setuser" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">管理员设置</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">用户名</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminusername" type="text" id="adminusername" value="<?=$set_username?>">
        <font color="#666666">(修改后要重新登录，8~30个字符)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">密码</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminpassword" type="password" id="adminpassword"> 
        <font color="#666666">(不想修改请留空, 修改后要重新登录，8~30个字符，区分大小写)</font></td>
    </tr>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">重复密码</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="adminrepassword" type="password" id="adminrepassword"> 
        <font color="#666666">(不想修改请留空)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">认证码</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adminloginauth" type="password" id="adminloginauth" value="<?=$set_loginauth?>">
        <font color="#666666">(二级密码,空为不设置，不限字符数)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">验证随机码</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adminloginrnd" type="text" id="adminloginrnd" value="<?=$set_loginrnd?>">
        <font color="#666666">
        <input type="button" name="Submit3" value="随机" onclick="document.form1.adminloginrnd.value='<?=$loginauthrnd?>';">
        (修改后要重新登录，不限字符数)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">超时限制</td>
      <td height="25" bgcolor="#FFFFFF"><input name="outtime" type="text" id="outtime" value="<?=$set_outtime?>">
        分钟</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">登录是否需要验证码</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="loginkey" value="0"<?=$set_loginkey==0?' checked':''?>>
        是 
        <input type="radio" name="loginkey" value="1"<?=$set_loginkey==1?' checked':''?>>
        否</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">验证码过期时间</td>
      <td height="25" bgcolor="#FFFFFF"><input name="keytime" type="text" id="keytime" value="<?=$ebak_set_keytime?>">
        秒 <font color="#666666">(时间越短效果越好)</font></td>
    </tr>
	<tr>
      <td rowspan="2" valign="top" bgcolor="#FFFFFF">后台访问的UserAgent包含</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckuseragent" type="text" id="ckuseragent" value="<?=$ebak_set_ckuseragent?>" size="50"></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF"><font color="#666666">(区分大小写，多个用“||”半角双竖线隔开，设置后UserAgent信息必须同时包含这些字符才能访问后台)</font></td>
    </tr>
  </table>
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setck" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">COOKIE设置(通常不需要修改)</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">COOKIE作用域</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckdomain" type="text" id="ckdomain" value="<?=$phome_cookiedomain?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE作用路径</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckpath" type="text" id="ckpath" value="<?=$phome_cookiepath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE变量前缀</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckvarpre" type="text" id="ckvarpre" value="<?=$phome_cookievarpre?>"></td>
    </tr>
  </table>	
		
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setmdbs" style="display:none">
    <tr class="header"> 
      <td height="25">多数据库服务器设置(方便同时备份多台服务器的数据库)</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
        <input name="dbservernum" type="hidden" id="dbservernum" value="<?=$moredbcount?>">
        <tr>
          <td width="3%"><div align="center"></div></td>
          <td width="10%" height="25">MYSQL版本</td>
          <td width="34%">数据库服务器链接地址</td>
          <td width="7%">端口</td>
          <td width="10%">用户名</td>
          <td width="10%">密码</td>
          <td width="9%">默认数据库名</td>
          <td width="9%">默认表前缀</td>
          <td width="8%">默认编码</td>
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
            <td bgcolor="#FFFFFF" width="34%"><input name="moredbhost[]" type="text" id="moredbhost<?=$dbserverid?>" value="<?=$moredbserver_fr[1]?>"> <a href="#empirebak" onclick="EbakCheckDbServer('<?=$dbserverid?>');">[测试]</a>
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
          <td height="25" colspan="9" bgcolor="#FFFFFF"><strong><a href="#empirebak" onclick="EbakShowAddDbServer();"><font color="#FF9900">[+]增加服务器</font></a></strong></td>
        </tr>
        <tr>
          <td height="25" colspan="9" bgcolor="#FFFFFF"><font color="#666666">如果要删除服务器，只需把“服务器地址”设置为空。填写数据库信息后可以点“[测试]”检测信息是否正确。更新服务器后请刷新后台主界面以便显示更新。</font></td>
        </tr>
      </table></td>
    </tr>
  </table>		
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setother" style="display:none">
    <tr class="header"> 
      <td height="25" colspan="2">其他设置</td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">数据备份目录</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbakpath" type="text" id="sbakpath" value="<?=$bakpath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">压缩包存放目录</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sbakzippath" type="text" id="sbakzippath" value="<?=$bakzippath?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">文件生成权限设置</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="sfilechmod" value="0"<?=$filechmod0?>>
        0777 
        <input type="radio" name="sfilechmod" value="1"<?=$filechmod1?>>
        不限制<font color="#666666">(如果空间不支持运行0777的.php文件,选择不限制即可.)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">PHP运行于安全模式</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sphpsafemod" type="checkbox" id="sphpsafemod" value="1"<?=$phpsafemod==1?' checked':''?>>
        是<font color="#666666">(如果运行于安全模式，所有数据均备份到bdata/safemod目录)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">PHP超时时间设置</td>
      <td height="25" bgcolor="#FFFFFF"><input name="sphp_outtime" type="text" id="sphp_outtime" value="<?=$php_outtime?>" size="6">
        秒 <font color="#666666">(一般不需要设置，需要set_time_limit()支持才有效)</font></td>
    </tr>
    <tr> 
      <td rowspan="2" bgcolor="#FFFFFF"> <p>MYSQL支持查询方式</p></td>
      <td height="25" bgcolor="#FFFFFF"><input name="slimittype" type="checkbox" id="slimittype" value="1"<?=$checklimittype?>>
        支持 <font color="#666666">(如果备份时出现下面错误,请将打勾去掉即可解决)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><font color="#FF0000">You have an error 
        in your SQL syntax; check the manual that corresponds to your MySQL server 
        version for the right syntax to use near '-1' at line 1</font></td>
    </tr>
	<tr>
      <td height="25" bgcolor="#FFFFFF">空间不支持数据库列表</td>
      <td height="25" bgcolor="#FFFFFF"><input name="scanlistdb" type="checkbox" id="scanlistdb" value="1"<?=$canlistdb==1?' checked':''?>>
        不支持<font color="#666666">(如果空间不允许列出数据库,请打勾；并且要设置默认备份的数据库)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">隐藏数据库显示</td>
	  <td height="25" bgcolor="#FFFFFF"><input name="shidedbs" type="text" id="shidedbs" value="<?=$ebak_set_hidedbs?>">
        <font color="#666666">(多个数据库名用半角逗号&quot;,&quot;隔开，比如：dbname1,dbname2)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">导出数据处理函数</td>
	  <td height="25" bgcolor="#FFFFFF"><select name="sescapetype" id="sescapetype">
        <option value="1"<?=$ebak_set_escapetype==1?' selected':''?>>addslashes()</option>
        <option value="2"<?=$ebak_set_escapetype==2?' selected':''?>>mysql_real_escape_string()</option>
      </select>
        <font color="#666666">(通常按默认即可)</font></td>
    </tr>
  </table>		
	
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" id="setebma" style="display:none">
	<tr class="header">
	  <td height="25" colspan="2"><strong>EBMA设置 </strong>(<strong>E</strong>mpire<strong>B</strong>ak+php<strong>M</strong>y<strong>A</strong>dmin)</td>
    </tr>
	<tr>
	  <td width="24%" height="25" bgcolor="#FFFFFF">是否开启phpmyadmin</td>
	  <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ebmaopen" value="1"<?=$ebak_ebma_open==1?' checked':''?>>开启
        <input type="radio" name="ebmaopen" value="0"<?=$ebak_ebma_open==0?' checked':''?>>关闭
      <font color="#666666">(可以要使用时开启，不使用时关闭)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">phpmyadmin目录</td>
	  <td height="25" bgcolor="#FFFFFF">eapi/
      <input name="ebmapath" type="text" id="ebmapath" value="<?=$ebak_ebma_path?>">
      <font color="#666666">(修改目录：先重命名eapi/phpmyadmin目录，然后再修改这里)</font></td>
    </tr>
	<tr>
	  <td height="25" bgcolor="#FFFFFF">开启phpmyadmin二次验证</td>
	  <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ebmacklogin" value="0"<?=$ebak_ebma_cklogin==0?' checked':''?>>开启
          <input type="radio" name="ebmacklogin" value="1"<?=$ebak_ebma_cklogin==1?' checked':''?>>关闭 <font color="#666666">(开启后，进入phpmyadmin需要再次登录数据库，即：帝国备份王验证+PMA本身双重验证)</font>	  
	  </td>
    </tr>
  </table>
	<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
	<?php
	if(empty($phome_db_ver))
	{
	?>
    <tr>
      <td height="30" colspan="2" bgcolor="#FFFFFF"><font color="#FF0000">首次安装帝国备份王，请修改<strong>管理员设置</strong>里的默认<strong>管理密码</strong>和<strong>验证随机码</strong>。修改后需要重新登录后台。(至于默认<strong>用户名</strong>不强制，但官方推荐也修改)</font></td>
    </tr>
	<?php
	}
	?>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"> <div align="left"> 
          <input type="submit" name="Submit" value=" 设置 ">&nbsp;&nbsp;
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