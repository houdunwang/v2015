<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php

//配置查询自定义字段列表,逗号开头，多个用逗号格开，格式“ui.字段名”
$useraddf=',ui.userpic';

//分页SQL
$query='select '.eReturnSelectMemberF('userid,username,email,registertime,groupid','u.').$useraddf.' from '.eReturnMemberTable().' u'.$add." order by u.".egetmf('userid')." desc limit $offset,$line";
$sql=$empire->query($query);

//导航
$public_diyr['pagetitle']='会员列表';
$url="<a href='../../../'>首页</a>&nbsp;>&nbsp;会员列表";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="memberform" method="get" action="index.php">
    <input type="hidden" name="sear" value="1">
    <input type="hidden" name="groupid" value="<?=$groupid?>">
    <tr class="header"> 
      <td width="10%"><div align="center">ID</div></td>
      <td width="38%" height="25"><div align="center">用户名</div></td>
      <td width="30%" height="25"><div align="center">注册时间</div></td>
      <td width="22%" height="25"><div align="center"></div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		//注册时间
		$registertime=eReturnMemberRegtime($r['registertime'],"Y-m-d H:i:s");
		//用户组
		$groupname=$level_r[$r['groupid']]['groupname'];
		//用户头像
		$userpic=$r['userpic']?$r['userpic']:$public_r[newsurl].'e/data/images/nouserpic.gif';
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <?=$r['userid']?>
        </div></td>
      <td height="25"> <a href='<?=$public_r[newsurl]?>e/space/?userid=<?=$r['userid']?>' target='_blank'> 
        <?=$r['username']?>
        </a> </td>
      <td height="25"><div align="center"> 
          <?=$registertime?>
        </div></td>
      <td height="25"><div align="center"> [<a href="<?=$public_r[newsurl]?>e/member/ShowInfo/?userid=<?=$r['userid']?>" target="_blank">会员资料</a>] 
          [<a href="<?=$public_r[newsurl]?>e/space/?userid=<?=$r['userid']?>" target="_blank">会员空间</a>]</div></td>
    </tr>
    <?
  	}
  	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3"> 
        <?=$returnpage?>
      </td>
      <td height="25"> <div align="center"> 
          <input name="keyboard" type="text" id="keyboard" size="10">
          <input type="submit" name="Submit" value="搜索">
        </div></td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>