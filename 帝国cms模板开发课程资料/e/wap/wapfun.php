<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

//-------- 编码转换
function DoWapIconvVal($str){
	global $ecms_config,$iconv,$pr;
	if($ecms_config['sets']['pagechar']!='utf-8')
	{
		$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'GB2312';
		$targetchar=$pr['wapchar']?'UTF8':'UNICODE';
		$str=$iconv->Convert($char,$targetchar,$str);
	}
	return $str;
}

//-------- 提示信息
function DoWapShowMsg($error,$returnurl='index.php',$ecms=0){
	global $empire,$public_r;
	$gotourl=str_replace('&amp;','&',$returnurl);
	if(strstr($gotourl,"(")||empty($gotourl))
	{
		if(strstr($gotourl,"(-2"))
		{
			$gotourl_js="history.go(-2)";
			$gotourl="javascript:history.go(-2)";
		}
		else
		{
			$gotourl_js="history.go(-1)";
			$gotourl="javascript:history.go(-1)";
		}
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if($ecms==9)//弹出对话框
	{
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
	}
	elseif($ecms==7)//弹出对话框并关闭窗口
	{
		echo"<script>alert('".$error."');window.close();</script>";
	}
	else
	{
		@include(ECMS_PATH.'e/wap/message.php');
	}
	db_close();
	$empire=null;
	exit();
}

//-------- 头部
function DoWapHeader($title){
	global $ecms_config;
	ob_start();
	header("Content-type: text/vnd.wap.wml; charset=utf-8");
	echo'<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<head>
<meta http-equiv="Cache-Control" content="max-age=180,private" />
</head>
<card id="empirecms_wml" title="<?php echo $title;?>">
<?php
}

//-------- 尾部
function DoWapFooter(){
?>
<p><br/><small>Powered by EmpireCMS</small></p>
</card></wml>
<?php
	$str=ob_get_contents();
	ob_end_clean();
	echo DoWapIconvVal($str);
}

//-------- 分页
function DoWapListPage($num,$line,$page,$search){
	if(empty($num))
	{
		return '';
	}
	$str='';
	$pagenum=ceil($num/$line);
	$search=RepPostStr($search,1);
	$phpself=eReturnSelfPage(0);
	if($page)//首页
	{
		$str.="<a href=\"".$phpself."?page=0".$search."\">首页</a>&nbsp;";
	}
	if($page)
	{
		$str.="<a href=\"".$phpself."?page=".($page-1).$search."\">上一页</a>&nbsp;";
	}
	if($page!=$pagenum-1)
	{
		$str.="<a href=\"".$phpself."?page=".($page+1).$search."\">下一页</a>&nbsp;";
	}
	if($page!=$pagenum-1)
	{
		$str.="<a href=\"".$phpself."?page=".($pagenum-1).$search."\">尾页</a>&nbsp;";
	}
	return $str;
}

//-------- 替换<p> --------
function DoWapRepPtags($text){
	$text=str_replace(array('<p>','<P>','</p>','</P>'),array('','','<br />','<br />'),$text);
	$preg_str="/<(p|P) (.+?)>/is";
	$text=preg_replace($preg_str,"",$text);
	return $text;
}

//-------- 字段属性 --------
function DoWapRepField($text,$f,$field){
	global $modid,$emod_r;
	$modid=(int)$modid;
	if(strstr($emod_r[$modid]['tobrf'],','.$f.','))//加br
	{
		$text=nl2br($text);
	}
	if(!strstr($emod_r[$modid]['dohtmlf'],','.$f.','))//去除html
	{
		$text=ehtmlspecialchars($text);
	}
	return $text;
}

//-------- 去除html代码 --------
function DoWapClearHtml($text){
	$text=stripSlashes($text);
	$text=ehtmlspecialchars(strip_tags($text));
	return $text;
}

//-------- 替换字段内容
function DoWapRepF($text,$f,$field){
	$text=stripSlashes($text);
	$text=DoWapRepPtags($text);
	$text=DoWapRepField($text,$f,$field);
	return $text;
}

//-------- 替换文章内容字段
function DoWapRepNewstext($text){
	$text=stripSlashes($text);
	$text=DoWapRepPtags($text);
	return $text;
}

//-------- 特殊字符去除
function DoWapCode($string){
	$string=str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
	return $string;
}

//-------- 返回使用模板
function ReturnWapStyle($add,$style){
	global $empire,$dbtbpre,$pr,$class_r;
	$style=(int)$style;
	$styleid=$pr['wapdefstyle'];
	$classid=0;
	if(WapPage=='index')
	{
		$classid=(int)$add['bclassid'];
	}
	elseif(WapPage=='list')
	{
		$classid=(int)$add['classid'];
	}
	elseif(WapPage=='show')
	{
		$classid=(int)$add['classid'];
	}
	if($classid&&$class_r[$classid]['tbname'])
	{
		$cr=$empire->fetch1("select wapstyleid from {$dbtbpre}enewsclass where classid='$classid'");
		if($cr['wapstyleid'])
		{
			$styleid=$cr['wapstyleid'];
		}
	}
	if($style&&$styleid==$pr['wapdefstyle'])
	{
		$styleid=$style;
	}
	$sr=$empire->fetch1("select path from {$dbtbpre}enewswapstyle where styleid='$styleid'");
	$wapstyle=$sr['path'];
	if(empty($wapstyle))
	{
		$wapstyle=1;
	}
	return $wapstyle;
}


//----------------- 模板调用区 ------------------

//返回sql语句
function ewap_ReturnBqQuery($classid,$line,$enews=0,$do=0,$ewhere='',$eorder=''){
	global $empire,$public_r,$class_r,$class_zr,$navclassid,$dbtbpre,$fun_r,$class_tr,$emod_r,$etable_r,$eyh_r;
	$navclassid=(int)$navclassid;
	if($enews==24)//按sql查询
	{
		$query_first=substr($classid,0,7);
		if(!($query_first=='select '||$query_first=='SELECT '))
		{
			return "";
		}
		$classid=RepSqlTbpre($classid);
		$sql=$empire->query1($classid);
		if(!$sql)
		{
			echo"SQL Error: ".ReRepSqlTbpre($classid);
		}
		return $sql;
	}
	if($enews==0||$enews==1||$enews==2||$enews==9||$enews==12||$enews==15)//栏目
	{
		if(strstr($classid,','))//多栏目
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			if($classid=='selfinfo')//显示当前栏目信息
			{
				$classid=$navclassid;
			}
			if($class_r[$classid][islast])
			{
				$where="classid='$classid'";
			}
			else
			{
				$where=ReturnClass($class_r[$classid][sonclass]);
			}
		}
		$tbname=$class_r[$classid][tbname];
		$mid=$class_r[$classid][modid];
		$yhid=$class_r[$classid][yhid];
    }
	elseif($enews==6||$enews==7||$enews==8||$enews==11||$enews==14||$enews==17)//专题
	{
		echo"Error：Change to use e:indexloop";
		return false;
	}
	elseif($enews==25||$enews==26||$enews==27||$enews==28||$enews==29||$enews==30)//标题分类
	{
		if(strstr($classid,','))//多标题分类
		{
			$son_r=sys_ReturnMoreTT($classid);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			if($classid=='selfinfo')//显示当前标题分类信息
			{
				$classid=$navclassid;
			}
			$where="ttid='$classid'";
		}
		$mid=$class_tr[$classid][mid];
		$tbname=$emod_r[$mid][tbname];
		$yhid=$class_tr[$classid][yhid];
	}
	$query='';
	$qand=' and ';
	if($enews==0)//栏目最新
	{
		$query=' where ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==1)//栏目热门
	{
		$query=' where ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==2)//栏目推荐
	{
		$query=' where ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==9)//栏目评论排行
	{
		$query=' where ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==12)//栏目头条
	{
		$query=' where ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==15)//栏目下载排行
	{
		$query=' where ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	elseif($enews==3)//所有最新
	{
		$qand=' where ';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==4)//所有点击排行
	{
		$qand=' where ';
		$order='onclick';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==5)//所有推荐
	{
		$query=' where isgood>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==10)//所有评论排行
	{
		$qand=' where ';
		$order='plnum';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==13)//所有头条
	{
		$query=' where firsttitle>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==16)//所有下载排行
	{
		$qand=' where ';
		$order='totaldown';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==18)//各表最新
	{
		$qand=' where ';
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==19)//各表热门
	{
		$qand=' where ';
		$order='onclick';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==20)//各表推荐
	{
		$query=' where isgood>0';
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==21)//各表评论排行
	{
		$qand=' where ';
		$order='plnum';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==22)//各表头条信息
	{
		$query=' where firsttitle>0';
		$order="newstime";
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==23)//各表下载排行
	{
		$qand=' where ';
		$order='totaldown';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==25)//标题分类最新
	{
		$query=' where ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==26)//标题分类点击排行
	{
		$query=' where ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==27)//标题分类推荐
	{
		$query=' where ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==28)//标题分类评论排行
	{
		$query=' where ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==29)//标题分类头条
	{
		$query=' where ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==30)//标题分类下载排行
	{
		$query=' where ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	//优化
	$yhadd='';
	if(!empty($eyh_r[$yhid]['dobq']))
	{
		$yhadd=ReturnYhSql($yhid,$yhvar);
		if(!empty($yhadd))
		{
			$query.=$qand.$yhadd;
			$qand=' and ';
		}
	}
	//不调用
	if(!strstr($public_r['nottobq'],','.$classid.','))
	{
		$notbqwhere=ReturnNottoBqWhere();
		if(!empty($notbqwhere))
		{
			$query.=$qand.$notbqwhere;
			$qand=' and ';
		}
	}
	//图片信息
	if(!empty($do))
	{
		$query.=$qand.'ispic=1';
		$qand=' and ';
    }
	//附加条件
	if(!empty($ewhere))
	{
		$query.=$qand.'('.$ewhere.')';
		$qand=' and ';
	}
	//中止
	if(empty($tbname))
	{
		echo "ClassID=<b>".$classid."</b> Table not exists.(DoType=".$enews.")";
		return false;
	}
	//排序
	$addorder=empty($eorder)?$order.' desc':$eorder;
	$query='select '.ReturnSqlListF($mid).' from '.$dbtbpre.'ecms_'.$tbname.$query.' order by '.ReturnSetTopSql('bq').$addorder.' limit '.$line;
	$sql=$empire->query1($query);
	if(!$sql)
	{
		echo"SQL Error: ".ReRepSqlTbpre($query);
	}
	return $sql;
}

//灵动标签：返回SQL内容函数
function ewap_eloop($classid=0,$line=10,$enews=3,$doing=0,$ewhere='',$eorder=''){
	return ewap_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
}

//灵动标签：返回特殊内容函数
function ewap_eloop_sp($r){
	global $class_r;
	$sr['titleurl']=ewap_ReturnTitleUrl($r);
	$sr['classname']=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$sr['classurl']=ewap_ReturnClassUrl($r);
	return $sr;
}

//返回wap内容页地址
function ewap_ReturnTitleUrl($r){
	global $public_r,$class_r,$ecmsvar_mbr,$wapstyle;
	if(empty($r['isurl']))
	{
		$titleurl='show.php?classid='.$r[classid].'&amp;id='.$r[id].'&amp;style='.$wapstyle.'&amp;bclassid='.$class_r[$r[classid]][bclassid].'&amp;cid='.$r[classid].'&amp;cpage=0';
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl'].'e/public/jump/?classid='.$r['classid'].'&amp;id='.$r['id'];
		}
	}
	return $titleurl;
}

//返回栏目页地址
function ewap_ReturnClassUrl($r){
	global $public_r,$class_r,$ecmsvar_mbr,$wapstyle;
	//外部栏目
	if($class_r[$r[classid]][wburl])
	{
		$classurl=$class_r[$r[classid]][wburl];
	}
	else
	{
		$classurl='list.php?classid='.$r[classid].'&amp;style='.$wapstyle.'&amp;bclassid='.$class_r[$r[classid]][bclassid];
	}
	return $classurl;
}

//链接附加参数
function ewap_UrlAddCs(){
	global $ecmsvar_mbr;
	$wapstyle=(int)$ecmsvar_mbr['wapstyle'];
	$fbclassid=(int)$ecmsvar_mbr['fbclassid'];
	$fclassid=(int)$ecmsvar_mbr['fclassid'];
	$fcpage=(int)$ecmsvar_mbr['fcpage'];
	$addcs='';
	if($wapstyle)
	{
		$addcs.='&amp;style='.$wapstyle;
	}
	if($fbclassid)
	{
		$addcs.='&amp;bclassid='.$fbclassid;
	}
	if($fclassid)
	{
		$addcs.='&amp;cid='.$fclassid;
	}
	if($fcpage)
	{
		$addcs.='&amp;cpage='.$fcpage;
	}
	return $addcs;
}


$pr=$empire->fetch1("select wapopen,wapdefstyle,wapshowmid,waplistnum,wapsubtitle,wapshowdate,wapchar from {$dbtbpre}enewspublic limit 1");

//导入编码文件
$iconv='';
if($ecms_config['sets']['pagechar']!='utf-8')
{
	@include_once("../class/doiconv.php");
	$iconv=new Chinese('');
}

if(empty($pr['wapopen']))
{
	DoWapShowMsg('网站没有开启WAP功能','index.php');
}

$wapstyle=intval($_GET['style']);
//返回使用模板
$usewapstyle=ReturnWapStyle($_GET,$wapstyle);
if(!file_exists('template/'.$usewapstyle))
{
	$usewapstyle=1;
}
?>