<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='管理留言';
$url="<a href='../../../'>首页</a>&nbsp;>&nbsp;<a href='../cp/'>会员中心</a>&nbsp;>&nbsp;管理留言";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<form name="gbookform" method="post" action="index.php" onsubmit="return confirm('确认要删除?');">
		<?php
		while($r=$empire->fetch($sql))
		{
			$i++;
			$bgcolor=" class='tableborder'";
			if($i%2==0)
			{
				$bgcolor=" bgcolor='#ffffff'";
			}
			$private='';
			if($r['isprivate'])
			{
				$private='*悄悄话* / ';
			}
			$msg='';
			if($r['uid'])
			{
				$msg=" / <a href='../msg/AddMsg/?username=$r[uname]' target='_blank'>消息回复</a>";
				$r['uname']="<b><a href='../../space/?userid=$r[uid]' target='_blank'>$r[uname]</a></b>";
			}
			$gbuname=$private.$r[uname]." / 留言于 ".$r[addtime]." / ip: ".$r[ip].":".$r[eipport].$msg;
		?>
          <tr> 
            <td height="25">
			<table width="100%" border="0" cellspacing="1" cellpadding="3"<?=$bgcolor?>>
                <tr> 
                  <td width="5%"><div align="center"> 
                      <input name="gid[]" type="checkbox" id="gid[]" value="<?=$r[gid]?>">
                    </div></td>
                  <td width="78%">
                    <?=$gbuname?>                  </td>
                  <td width="17%"><div align="center">[<a href="#ecms" onclick="window.open('ReGbook.php?gid=<?=$r[gid]?>','','width=600,height=380,scrollbars=yes');">回复</a>]&nbsp;&nbsp;[<a href="index.php?enews=DelMemberGbook&gid=<?=$r[gid]?>" onclick="return confirm('确认要删除?');">删除</a>]</div></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td colspan="2"> <table border=0 width=100% cellspacing=1 cellpadding=10 bgcolor='#cccccc'>
                      <tr> 
                        <td width='100%' bgcolor='#FFFFFF' style='word-break:break-all'> 
                          <?=nl2br($r['gbtext'])?>                        </td>
                      </tr>
                    </table>
					<?
					if($r['retext'])
					{
					?>
                    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                      <tr> 
                        <td><img src="../../data/images/regb.gif" width="18" height="18"><strong><font color="#FF0000">回复:</font></strong>
                          <?=nl2br($r['retext'])?>                        </td>
                      </tr>
                    </table>
					<?
					}
					?>				  </td>
                </tr>
              </table>
			<br></td>
          </tr>
		  <?
		  }
		  ?>
          <tr> 
            <td height="23"> 
              <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="5%"><div align="center"><input type='checkbox' name='chkall' value='on' onClick='CheckAll(this.form)'></div></td>
                  <td width="95%">
                    <?=$returnpage?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='批量删除'>
                    <input name="enews" type="hidden" id="enews" value="DelMemberGbook_All"> </td>
                </tr>
              </table></td>
          </tr>
		</form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>