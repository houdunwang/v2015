<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>選擇數據表</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
function reverseCheckAll(form)
{
  for (var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
	{
		continue;
	}
	if (e.name != 'chkall')
	{
	   if(e.checked==true)
	   {
       		e.checked = false;
	   }
	   else
	   {
	  		e.checked = true;
	   }
	}
  }
}
function SelectCheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
	  	e.checked = true;
    }
  }
function check()
{
	var ok;
	var oktwo;
	var okthree;
	var formdoaction;
	var saystr;
	formdoaction=document.ebakchangetb.phome.value;
	ok=confirm("確認要執行此操作?");
	if(ok==false)
	{
		return false;
	}
	if(formdoaction=='DoDrop'||formdoaction=='EmptyTable')
	{
		if(formdoaction=='DoDrop')
		{
			saystr='刪除數據表';
		}
		else
		{
			saystr='清空數據表';
		}
		oktwo=confirm("再次確認要執行此操作("+saystr+")?");
		if(oktwo==false)
		{
			return false;
		}
		okthree=confirm("最後確認要執行此操作("+saystr+")?");
		if(okthree==false)
		{
			return false;
		}
	}
	else
	{
		oktwo=true;
		okthree=true;
	}
	if(ok&&oktwo&&okthree)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="51%">位置：備份數據 -&gt; <a href="ChangeDb.php">選擇數據庫</a>(<b><?=$mydbname?></b>) -&gt; <a href="ChangeTable.php?mydbname=<?=$mydbname?>">選擇備份表</a></td>
    <td width="49%"><div align="right"> </div></td>
  </tr>
  <tr> 
    <td height="25" colspan="2"><div align="center">備份步驟：選擇數據庫 -&gt; <font color="#FF0000">選擇要備份的表</font> 
        -&gt; 開始備份 -&gt; 完成</div></td>
  </tr>
</table>
<br>
<table id="checkmaxinput" width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder" style="display:none">
	<tr>
      <td height="50" bgcolor="#FFFF00"><div align="center">系統檢測到<strong> 當前表單變量數 </strong>超過 <strong>PHP允許最大表單變量數(<span id="ckmaxinputnum"></span>)</strong>。請修改PHP配置文件 php.ini 裡的 max_input_vars 參數。或者按表前綴搜索減少表再備份。</div></td>
    </tr>
	</table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="ebakchangetb" method="post" action="phomebak.php" onsubmit="return check();">
    <tr class="header"> 
      <td height="25">備份參數設置： 
        <input name="phome" type="hidden" id="phome" value="DoEbak">        <input name="mydbname" type="hidden" id="mydbname" value="<?=$mydbname?>">        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="22%">&nbsp;</td>
            <td> [<a href="#ebak" onclick="javascript:window.open('ListSetbak.php?mydbname=<?=$mydbname?>&change=1','','width=550,height=380,scrollbars=yes');">導入設置</a>]&nbsp;&nbsp;&nbsp;[<a href="#ebak" onclick="javascript:showsave.style.display='';">保存設置</a>]&nbsp;&nbsp;&nbsp;[<a href="#ebak" onclick="javascript:showreptable.style.display='';">批量替換表名</a>]</td>
          </tr>
          <tr id="showsave" style="display:none">
            <td>&nbsp;</td>
            <td>保存文件名:setsave/ 
              <input name="savename" type="text" id="savename" value="<?=$_GET['savefilename']?>">
              <input name="Submit4" type="submit" id="Submit4" onClick="document.ebakchangetb.phome.value='DoSave';document.ebakchangetb.action='phome.php';" value="保存設置">
              <font color="#666666">(文件名請用英文字母,如：test)</font></td>
          </tr>
		  <tr id="showreptable" style="display:none">
            <td>&nbsp;</td>
            <td> 原字符: 
              <input name="oldtablepre" type="text" id="oldtablepre" size="18">
              新字符:
              <input name="newtablepre" type="text" id="newtablepre" size="18"> 
              <input name="Submit4" type="submit" id="Submit4" onClick="document.ebakchangetb.phome.value='ReplaceTable';document.ebakchangetb.action='phome.php';" value="替換選中表名">
            </td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="22%"><input type="radio" name="baktype" value="0"<?=$dbaktype==0?' checked':''?>> 
              <strong>按文件大小備份</strong> </td>
            <td width="78%" height="23"> 每組備份大小: 
              <input name="filesize" type="text" id="filesize" value="<?=$dfilesize?>" size="6">
              KB <font color="#666666">(1 MB = 1024 KB)</font></td>
          </tr>
          <tr> 
            <td><input type="radio" name="baktype" value="1"<?=$dbaktype==1?' checked':''?>> 
              <strong>按記錄數備份</strong></td>
            <td height="23">每組備份 
              <input name="bakline" type="text" id="bakline" value="<?=$dbakline?>" size="6">
              條記錄， 
              <input name="autoauf" type="checkbox" id="autoauf" value="1"<?=$dautoauf==1?' checked':''?>>
              自動識別自增字段<font color="#666666">(此方式效率更高)</font></td>
          </tr>
          <tr> 
            <td>備份數據庫結構</td>
            <td height="23"><input name="bakstru" type="checkbox" id="bakstru" value="1"<?=$dbakstru==1?' checked':''?>>
              是 <font color="#666666">(沒特殊情況，請選擇)</font></td>
          </tr>
          <tr> 
            <td>數據編碼</td>
            <td height="23"> <select name="dbchar" id="dbchar">
                <option value="auto"<?=$ddbchar=='auto'?' selected':''?>>自動識別編碼</option>
                <option value=""<?=$ddbchar==''?' selected':''?>>不設置</option>
                <?php
				echo Ebak_ReturnDbCharList($ddbchar);
				?>
              </select> <font color="#666666">(從mysql4.0導入mysql4.1以上版本需要選擇固定編碼，不能選自動)</font></td>
          </tr>
          <tr>
            <td>數據存放格式</td>
            <td height="23"><input type="radio" name="bakdatatype" value="0"<?=$dbakdatatype==0?' checked':''?>>
              正常
              <input type="radio" name="bakdatatype" value="1"<?=$dbakdatatype==1?' checked':''?>>
              十六進制方式<font color="#666666">(十六進制備份文件會佔用更多的空間)</font></td>
          </tr>
          <tr> 
            <td>存放目錄</td>
            <td height="23"> 
              <?=$bakpath?>
              / 
              <input name="mypath" type="text" id="mypath" value="<?=$mypath?>" size="28"> 
              <font color="#666666"> 
              <input type="button" name="Submit2" value="選擇目錄" onclick="javascript:window.open('ChangePath.php?change=1&toform=ebakchangetb','','width=750,height=500,scrollbars=yes');">
              (目錄不存在，系統會自動建立)</font></td>
          </tr>
          <tr> 
            <td>備份選項</td>
            <td height="23">導入方式: 
              <select name="insertf" id="select">
                <option value="replace"<?=$dinsertf=='replace'?' selected':''?>>REPLACE</option>
                <option value="insert"<?=$dinsertf=='insert'?' selected':''?>>INSERT</option>
              </select>
              , 
              <input name="beover" type="checkbox" id="beover" value="1"<?=$dbeover==1?' checked':''?>>
              完整插入，
              <input name="bakstrufour" type="checkbox" id="bakstrufour" value="1"<?=$dbakstrufour==1?' checked':''?>>
              <a title="需要轉換數據表編碼時選擇">轉成MYSQL4.0格式</a>, 每組備份間隔： 
              <input name="waitbaktime" type="text" id="waitbaktime" value="<?=$dwaitbaktime?>" size="2">
              秒</td>
          </tr>
          <tr> 
            <td valign="top">備份說明<br> <font color="#666666">(系統會生成一個readme.txt)</font></td>
            <td height="23"><textarea name="readme" cols="80" rows="5" id="readme"><?=$dreadme?></textarea></td>
          </tr>
          <tr> 
            <td valign="top">去除自增值的字段列表：<br> <font color="#666666">(格式：<strong>表名.字段名</strong><br>
              多個請用&quot;,&quot;格開)</font></td>
            <td height="23"><textarea name="autofield" cols="80" rows="5" id="autofield"><?=$dautofield?></textarea></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="header"> 
      <td height="25">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%"><font color="#FFFFFF">選擇要備份的表：( <a href="#ebak" onclick="SelectCheckAll(document.ebakchangetb)"><font color="#FFFFFF"><u>全選</u></font></a> 
              | <a href="#ebak" onclick="reverseCheckAll(document.ebakchangetb);"><font color="#FFFFFF"><u>反選</u></font></a> )</font></td>
            <td><div align="right"><font color="#FFFFFF">查詢: 
                <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
                <input type="button" name="Submit32" value="顯示數據表" onclick="self.location.href='ChangeTable.php?sear=1&mydbname=<?=$mydbname?>&keyboard='+document.ebakchangetb.keyboard.value;">
              </font></div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr bgcolor="#DBEAF5"> 
            <td width="5%" height="23"> <div align="center">選擇</div></td>
            <td width="27%" height="23" bgcolor="#DBEAF5"> 
              <div align="center">表名(點擊查看字段)</div></td>
            <td width="13%" height="23" bgcolor="#DBEAF5"> 
              <div align="center">類型</div></td>
            <td width="15%" bgcolor="#DBEAF5">
<div align="center">編碼</div></td>
            <td width="15%" height="23"> 
              <div align="center">記錄數</div></td>
            <td width="14%" height="23"> 
              <div align="center">大小</div></td>
            <td width="11%" height="23"> 
              <div align="center">碎片</div></td>
          </tr>
          <?php
		  $tbchecked=' checked';
		  if($dtblist)
		  {
		  	$check=1;
		  }
		  $totaldatasize=0;//總數據大小
		  $tablenum=0;//總表數
		  $datasize=0;//數據大小
		  $rownum=0;//總記錄數
		  while($r=$empire->fetch($sql))
		  {
		  	$rownum+=$r[Rows];
		  	$tablenum++;
		  	$datasize=$r[Data_length]+$r[Index_length];
		  	$totaldatasize+=$r[Data_length]+$r[Index_length]+$r[Data_free];
			if($check==1)
			{
				if(strstr($dtblist,','.$r[Name].','))
				{
					$tbchecked=' checked';
				}
				else
				{
					$tbchecked='';
				}
			}
			$collation=$r[Collation]?$r[Collation]:'---';
		  ?>
          <tr id=tb<?=$r[Name]?>> 
            <td height="23"> <div align="center"> 
                <input name="tablename[]" type="checkbox" id="tablename[]" value="<?=$r[Name]?>" onclick="if(this.checked){tb<?=$r[Name]?>.style.backgroundColor='#F1F7FC';}else{tb<?=$r[Name]?>.style.backgroundColor='#ffffff';}"<?=$tbchecked?>>
              </div></td>
            <td height="23"> <div align="left"><a href="#ebak" onclick="window.open('ListField.php?mydbname=<?=$mydbname?>&mytbname=<?=$r[Name]?>','','width=660,height=500,scrollbars=yes');" title="點擊查看表字段列表"> 
                <?=$r[Name]?>
                </a></div></td>
            <td height="23"> <div align="center">
                <?=$r[Type]?$r[Type]:$r[Engine]?>
              </div></td>
            <td><div align="center">
				<?=$collation?>
              </div></td>
            <td height="23"> <div align="right">
                <?=$r[Rows]?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($datasize)?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($r[Data_free])?>
              </div></td>
          </tr>
          <?
		  }
		  ?>
          <tr bgcolor="#DBEAF5"> 
            <td height="23"> <div align="center">
                <input type=checkbox name=chkall value=on onclick="CheckAll(this.form)"<?=$check==0?' checked':''?>>
              </div></td>
            <td height="23"> <div align="center"> 
                <?=$tablenum?>
              </div></td>
            <td height="23"> <div align="center">---</div></td>
            <td><div align="center">---</div></td>
            <td height="23"> <div align="center">
                <?=$rownum?>
              </div></td>
            <td height="23" colspan="2"> <div align="center">
                <?=Ebak_ChangeSize($totaldatasize)?>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr class="header"> 
      <td height="25">
<div align="center">
          <input type="submit" name="Submit" value="開始備份" onclick="document.ebakchangetb.phome.value='DoEbak';document.ebakchangetb.action='phomebak.php';">
          &nbsp;&nbsp; &nbsp;&nbsp;
          <input type="submit" name="Submit2" value="修復數據表" onclick="document.ebakchangetb.phome.value='DoRep';document.ebakchangetb.action='phome.php';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="優化數據表" onclick="document.ebakchangetb.phome.value='DoOpi';document.ebakchangetb.action='phome.php';">
        &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="刪除數據表" onclick="document.ebakchangetb.phome.value='DoDrop';document.ebakchangetb.action='phome.php';">
		&nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="清空數據表" onclick="document.ebakchangetb.phome.value='EmptyTable';document.ebakchangetb.action='phome.php';">
		</div></td>
    </tr>
	</form>
  </table>
<br>
<?php
$ckmaxinputnum=Ebak_CheckFormVarNum($tablenum);
if($ckmaxinputnum)
{
?>
	<script>
	document.getElementById("ckmaxinputnum").innerHTML="<font color=red><?=$ckmaxinputnum?></font>";
	checkmaxinput.style.display="";
	</script>
<?php
}
?>
</body>
</html>