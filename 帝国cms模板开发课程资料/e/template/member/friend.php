<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='好友列表';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>&nbsp;>&nbsp;好友列表";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="form1" method="post" action="">
            <tr> 
              <td width="50%" height="30" bgcolor="#FFFFFF">选择分类: 
                <select name="cid" id="select" onchange=window.location='../friend/?cid='+this.options[this.selectedIndex].value>
                  <option value="0">显示全部</option>
                  <?=$select?>
                </select></td>
              <td width="50%" bgcolor="#FFFFFF"><div align="right">[<a href="FriendClass/">管理分类</a>] [<a href="add/?fcid=<?=$cid?>">添加好友</a>]&nbsp;&nbsp;</div></td>
            </tr>
          </form>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
          <form name=favaform method=post action="../doaction.php" onsubmit="return confirm('确认要操作?');">
            <input type=hidden value=hy name=enews>
            <tr class="header"> 
              <td width="5%" height="25"><div align="center"></div></td>
              <td width="30%"><div align="center">用户名</div></td>
              <td width="45%"><div align="center">备注</div></td>
              <td width="20%"><div align="center">操作</div></td>
            </tr>
            <?php
			while($r=$empire->fetch($sql))
			{
			?>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="center"><img src="../../data/images/man.gif" width="16" height="16" border=0></div></td>
              <td> <div align="center"><a href="../ShowInfo/?username=<?=$r[fname]?>" target=_blank> 
                  <?=$r[fname]?>
                  </a></div></td>
              <td> <div align="center"> 
                  <input name="fsay[]" type="text" id="fsay[]" value="<?=stripSlashes($r[fsay])?>" size="32">
                </div></td>
              <td> <div align="center">[<a href="add/?enews=EditFriend&fid=<?=$r[fid]?>&fcid=<?=$cid?>">修改</a>] 
                  [<a href="../doaction.php?enews=DelFriend&fid=<?=$r[fid]?>&fcid=<?=$cid?>" onclick="return confirm('确认要删除?');">删除</a>]</div></td>
            </tr>
            <?php
			}
			?>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" colspan="4"> &nbsp;&nbsp;&nbsp; 
                <?=$returnpage?></td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>