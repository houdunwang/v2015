<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?><script>
function AddFj(str)
{var r;
var a;
a=document.add.softfj.value;
r=a.split(str);
if(r.length!=1)
{return true;}
document.add.softfj.value+="/"+str;
}
function DelFj(str)
{
var a;
a=document.add.softfj.value;
document.add.softfj.value=a.replace("/"+str,"");
}
</script>
<table width=100% align=center cellpadding=3 cellspacing=1 class="tableborder">
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>软件名称(*)</td>
    <td bgcolor=ffffff>
<input name="title" type="text" size="42" value="<?=$ecmsfirstpost==1?"":DoReqValue($mid,'title',stripSlashes($r[title]))?>">
</td>
  </tr>
  <tr>
    <td width='16%' height=25 bgcolor='ffffff'>关键字</td>
    <td bgcolor='ffffff'>
<input name="keyboard" type="text" size=42 value="<?=stripSlashes($r[keyboard])?>">
<font color="#666666">(多个请用&quot;,&quot;隔开)</font>
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>软件预览图</td>
    <td bgcolor=ffffff><input type="file" name="titlepicfile" size="45">
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>软件作者</td>
    <td bgcolor=ffffff><input name="softwriter" type="text" id="softwriter" value="<?=$ecmsfirstpost==1?"":DoReqValue($mid,'softwriter',stripSlashes($r[softwriter]))?>" size="42">
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>厂商主页</td>
    <td bgcolor=ffffff><input name="homepage" type="text" id="homepage" value="<?=$ecmsfirstpost==1?"http://":DoReqValue($mid,'homepage',stripSlashes($r[homepage]))?>" size="42">
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>系统演示</td>
    <td bgcolor=ffffff><input name="demo" type="text" id="demo" value="<?=$ecmsfirstpost==1?"http://":DoReqValue($mid,'demo',stripSlashes($r[demo]))?>" size="42">
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>运行环境</td>
    <td bgcolor=ffffff><input name="softfj" type="text" id="softfj" value="<?=$ecmsfirstpost==1?"":DoReqValue($mid,'softfj',stripSlashes($r[softfj]))?>" size="42">
</td>
  </tr>
  <tr> 
    <td height=25 bgcolor=ffffff>&nbsp;</td>
    <td bgcolor=ffffff><input type=checkbox name=check value='Win9X/Me' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      Win9X/Me&nbsp; <input type=checkbox name=check value='WinNT/2000/XP' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      WinNT/2000/XP&nbsp; <input type=checkbox name=check value='Unix' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      Unix&nbsp; <input type=checkbox name=check value='Linux' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      Linux&nbsp; <input type=checkbox name=check value='DOS' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      DOS&nbsp; <input type=checkbox name=check value='MAC OS' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      MAC OS&nbsp; <input type=checkbox name=check value='Other' onclick="if(this.checked){AddFj(this.value);}else{DelFj(this.value);}">
      Other</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>软件属性</td>
    <td bgcolor=ffffff>软件语言：<select name="language" id="language"><option value="简体中文"<?=$r[language]=="简体中文"?' selected':''?>>简体中文</option><option value="繁体中文"<?=$r[language]=="繁体中文"?' selected':''?>>繁体中文</option><option value="英文"<?=$r[language]=="英文"?' selected':''?>>英文</option><option value="多国语言"<?=$r[language]=="多国语言"?' selected':''?>>多国语言</option></select>，软件类型：<select name="softtype" id="softtype"><option value="国产软件"<?=$r[softtype]=="国产软件"?' selected':''?>>国产软件</option><option value="汉化软件"<?=$r[softtype]=="汉化软件"?' selected':''?>>汉化软件</option><option value="国外软件"<?=$r[softtype]=="国外软件"?' selected':''?>>国外软件</option></select>，授权形式：<select name="softsq" id="softsq"><option value="共享软件"<?=$r[softsq]=="共享软件"?' selected':''?>>共享软件</option><option value="免费软件"<?=$r[softsq]=="免费软件"?' selected':''?>>免费软件</option><option value="自由软件"<?=$r[softsq]=="自由软件"?' selected':''?>>自由软件</option><option value="试用软件"<?=$r[softsq]=="试用软件"?' selected':''?>>试用软件</option><option value="演示软件"<?=$r[softsq]=="演示软件"?' selected':''?>>演示软件</option><option value="商业软件"<?=$r[softsq]=="商业软件"?' selected':''?>>商业软件</option></select></td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>文件</td>
    <td bgcolor=ffffff>文件类型：<input name="filetype" type="text" id="filetype" value="<?=$ecmsfirstpost==1?"":DoReqValue($mid,'filetype',stripSlashes($r[filetype]))?>" size="10">
<select name="select2" onchange="document.add.filetype.value=this.value">
        <option value="">类型</option>
        <option value=".zip">.zip</option>
        <option value=".rar">.rar</option>
        <option value=".exe">.exe</option>
      </select>，文件大小：<input name="filesize" type="text" id="filesize" value="<?=$ecmsfirstpost==1?"":DoReqValue($mid,'filesize',stripSlashes($r[filesize]))?>" size="10">
<select name="select" onchange="document.add.filesize.value+=this.value">
        <option value="">单位</option>
        <option value=" MB">MB</option>
        <option value=" KB">KB</option>
        <option value=" GB">GB</option>
        <option value=" BYTES">BYTES</option>
      </select></td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>上传软件(*)</td>
    <td bgcolor=ffffff><input type="file" name="downpathfile" size="45">
</td>
  </tr>
  <tr> 
    <td width=16% height=25 bgcolor=ffffff>软件简介(*)</td>
    <td bgcolor=ffffff><textarea name="softsay" cols="60" rows="10" id="softsay"><?=$ecmsfirstpost==1?"":DoReqValue($mid,'softsay',stripSlashes($r[softsay]))?></textarea>
</td>
  </tr>
</table>