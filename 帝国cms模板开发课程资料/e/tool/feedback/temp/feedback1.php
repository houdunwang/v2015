<?
if(!defined('InEmpireCMS'))
{exit();}
?><? include("../../data/template/cp_1.php");?>
<table width=100% align=center cellpadding=3 cellspacing=1 class="tableborder">
  <form name='feedback' method='post' enctype='multipart/form-data' action='../../enews/index.php'>
    <input name='enews' type='hidden' value='AddFeedback'>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">您的姓名:</div></td>
      <td bgcolor='ffffff'><input name='name' type='text' size='42'>
        (*)</td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">职务:</div></td>
      <td bgcolor='ffffff'><input name='job' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">公司名称:</div></td>
      <td bgcolor='ffffff'><input name='company' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">联系邮箱:</div></td>
      <td bgcolor='ffffff'><input name='email' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">联系电话:</div></td>
      <td bgcolor='ffffff'><input name='mycall' type='text' size='42'>
        (*)</td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">网站:</div></td>
      <td bgcolor='ffffff'><input name='homepage' type='text' size='42'></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">联系地址:</div></td>
      <td bgcolor='ffffff'><input name='address' type='text' size="42"></td>
    </tr>
    <tr>
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">信息标题:</div></td>
      <td bgcolor='ffffff'><input name='title' type='text' size="42"> (*)</td>
    </tr>
    <tr> 
      <td width='16%' height=25 bgcolor='ffffff'><div align="right">信息内容(*):</div></td>
      <td bgcolor='ffffff'><textarea name='saytext' cols='60' rows='12'></textarea> 
      </td>
    </tr>
    <tr>
      <td bgcolor='ffffff'></td>
      <td bgcolor='ffffff'><input type='submit' name='submit' value='提交'></td>
    </tr>
  </form>
</table>
<? include("../../data/template/cp_2.php");?>