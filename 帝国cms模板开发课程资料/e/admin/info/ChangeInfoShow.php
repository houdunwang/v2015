<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require '../'.LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

$enews=ehtmlspecialchars($_POST['enews']);
$changeinfoid=RepPostVar($_POST['changeinfoid']);
$keyboard=RepPostVar2($_POST['keyboard']);
$show=(int)$_POST['show'];
$sear=(int)$_POST['sear'];
$tbname=RepPostVar($_POST['tbname']);
$classid=(int)$_POST['classid'];
if(!$tbname||!trim($keyboard))
{
	exit();
}
//表名
$tbr=$empire->fetch1("select tbname from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
if(!$tbr['tbname'])
{
	exit();
}
$changeinfonum=0;
if($changeinfoid)
{
	$changeinfonumr=explode(',',$changeinfoid);
	$changeinfonum=count($changeinfonumr);
}
$search="&enews=$enews&changeinfoid=$changeinfoid&keyboard=$keyboard&show=$show&sear=$sear&tbname=$tbname&classid=$classid".$ecms_hashur['ehref'];
$add='';
$and=' where ';
//分页
$page=(int)$_POST['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=6;//每页显示链接数
$offset=$page*$line;//总偏移量
//栏目
if($classid)
{
	if($class_r[$classid][islast])
	{
		$add.=$and."classid='$classid'";
	}
	else
	{
		$add.=$and."(".ReturnClass($class_r[$classid][sonclass]).")";
	}
	$and=' and ';
}
//搜索
if($keyboard)
{
	$kbr=explode(' ',$keyboard);
	$kbcount=count($kbr);
	$kbor='';
	$kbwhere='';
	for($kbi=0;$kbi<$kbcount;$kbi++)
	{
		if(!$kbr[$kbi])
		{
			continue;
		}
		if($show==1)
		{
			$kbwhere.=$kbor."title like '%".$kbr[$kbi]."%'";
		}
		elseif($show==2)
		{
			$kbwhere.=$kbor."keyboard like '%".$kbr[$kbi]."%'";
		}
		else
		{
			$kbwhere.=$kbor."id='".$kbr[$kbi]."'";
		}
		$kbor=' or ';
	}
	if($kbwhere)
	{
		$add.=$and.'('.$kbwhere.')';
	}
}
$query="select isurl,titleurl,classid,id,newstime,username,userid,title from {$dbtbpre}ecms_".$tbr['tbname'].$add;
$totalquery="select count(*) as total from {$dbtbpre}ecms_".$tbr['tbname'].$add;
$totalnum=(int)$_POST['totalnum'];
if($totalnum<1)
{
	$num=$empire->gettotal($totalquery);//取得总条数
}
else
{
	$num=$totalnum;
}
$query=$query." order by newstime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=postpage($num,$line,$page_line,$start,$page,"document.changeinfoform");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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

function AddInfoid(id){
	var inid=document.changeinfoform.changeinfoid.value;
	var dh="",cinid="",num=0,numlen=0;
	if(inid=="")
	{
		dh="";
	}
	else
	{
		dh=",";
	}
	cinid=","+inid+",";
	if(cinid.indexOf(","+id+",")==-1)
	{
		if(inid=='')
		{
			numlen=0;
		}
		else
		{
			num=inid.split(',');
			numlen=num.length;
		}
		document.changeinfoform.changeinfoid.value+=dh+id;
		parent.document.truechangeinfoform.trueinfoid.value=document.changeinfoform.changeinfoid.value;
		parent.document.getElementById("truechangeinfonum").innerHTML=numlen+1;
	}
}
function DelInfoid(id){
	var inid=","+document.changeinfoform.changeinfoid.value+",";
	var dh="",newinid="",len,num=0,numlen=0;
	if(inid=="")
	{
		return "";
	}
	if(inid.indexOf(","+id+",")!=-1)
	{
		newinid=inid.replace(","+id+",",",");
		if(newinid==",")
		{
			document.changeinfoform.changeinfoid.value="";
			parent.document.truechangeinfoform.trueinfoid.value='';
			parent.document.getElementById("truechangeinfonum").innerHTML=0;
			return "";
		}
		num=inid.split(',');
		//去掉前后,
		len=newinid.length;
		newinid=newinid.substring(1,len-1);
		document.changeinfoform.changeinfoid.value=newinid;
		parent.document.truechangeinfoform.trueinfoid.value=document.changeinfoform.changeinfoid.value;
		parent.document.getElementById("truechangeinfonum").innerHTML=num.length-1;
	}
}
</script>
</head>

<body>
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form name="changeinfoform" method="post" action="ChangeInfoShow.php">
  <?=$ecms_hashur['eform']?>
  	<input type=hidden name=totalnum value="<?=$num?>">
	<input type=hidden name=page value="<?=$page?>">
	<input type=hidden name=start value="<?=$start?>">
	<input type=hidden name=keyboard value="<?=$keyboard?>">
	<input type=hidden name=show value="<?=$show?>">
	<input type=hidden name=classid value="<?=$classid?>">
	<input type=hidden name=sear value="<?=$sear?>">
	<input type=hidden name=enews value="<?=$enews?>">
    <?php
while($infor=$empire->fetch($sql))
{
	$titleurl=sys_ReturnBqTitleLink($infor);
	$bgcolor="#FFFFFF";
	$checked='';
	if(strstr(",".$changeinfoid.",",",".$infor[id].","))
	{
		$bgcolor="#DBEAF5";
		$checked=' checked';
	}
	?>
    <tr bgcolor="<?=$bgcolor?>" id="news<?=$infor[id]?>"> 
      <td width="6%" height="25"> <div align="center"> 
          <input name="id[]" type="checkbox" id="id[]" value="<?=$infor['id']?>" onClick="if(this.checked){AddInfoid(<?=$infor[id]?>);news<?=$infor[id]?>.style.backgroundColor='#DBEAF5';}else{DelInfoid(<?=$infor[id]?>);news<?=$infor[id]?>.style.backgroundColor='#ffffff';}"<?=$checked?>>
        </div></td>
      <td width="12%"> <div align="center"> 
          <?=$infor['id']?>
        </div></td>
      <td width="66%"><a href="<?=$titleurl?>" target="_blank" title="发布时间：<?=date('Y-m-d H:i:s',$infor['newstime'])?>"> 
        <?=stripSlashes($infor['title'])?>
        </a></td>
    </tr>
    <?php
}
?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"></div></td>
      <td height="25" colspan="2"> 
        <?=$returnpage?>
        <input name="changeinfoid" type="hidden" id="changeinfoid" value="<?=$changeinfoid?>">
        <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"></td>
    </tr>
	</form>
  </table>
  <script>
  parent.document.truechangeinfoform.trueinfoid.value='<?=$changeinfoid?>';
  parent.document.truechangeinfoform.truetbname.value='<?=$tbname?>';
  parent.document.getElementById("truechangeinfonum").innerHTML=<?=$changeinfonum?>;
  </script>
</body>
</html>
<?php
db_close();
$empire=null;
?>