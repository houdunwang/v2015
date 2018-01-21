<?php
//区位码
function SearchReturnQwm($t){
	return sprintf("%02d%02d",ord($t[0])-160,ord($t[1])-160);
}

//转换字符串
function SearchReturnSaveStr($str){
	//所有汉字后添加ASCII的0字符,此法是为了排除特殊中文拆分错误的问题
	$str=preg_replace("/[\x80-\xff]{2}/","\\0".chr(0x00),$str);
	//拆分的分割符
	$search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">", "\r", "\r\n", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "：", "）", "（", "．", "。", "，", "！", "；", "“", "”", "‘", "’", "〔", "〕", "、", "—", "　", "《", "》", "－", "…", "【", "】",);
	//替换所有的分割符为空格
	$str = str_replace($search,' ',$str);
	//用正则匹配半角单个字符或者全角单个字符,存入数组$ar
	preg_match_all("/[\x80-\xff]?./",$str,$ar);$ar=$ar[0];
	//去掉$ar中ASCII为0字符的项目
	for($i=0;$i<count($ar);$i++)
	{
		if($ar[$i]!=chr(0x00))
		{
			$ar_new[]=$ar[$i];
		}
	}
	$ar=$ar_new;
	unset($ar_new);
	$oldsw=0;
	//把连续的半角存成一个数组下标,或者全角的每2个字符存成一个数组的下标
	for($ar_str='',$i=0;$i<count($ar);$i++)
	{
		$sw=strlen($ar[$i]);
		if($i>0 and $sw!=$oldsw)
		{
			$ar_str.=" ";
		}
		if($sw==1)
		{
			$ar_str.=$ar[$i];
		}
		else
		{
			if(strlen($ar[$i+1])==2)
			{
				$ar_str.=SearchReturnQwm($ar[$i]).SearchReturnQwm($ar[$i+1]).' ';
			}
			elseif($oldsw==1 or $oldsw==0)
			{
				$ar_str.=SearchReturnQwm($ar[$i]);
			}
		}
		$oldsw=$sw;
	}
	//去掉连续的空格
	$ar_str=trim(preg_replace("# {1,}#i"," ",$ar_str));
	//返回拆分后的结果
	return $ar_str;
}

//全站搜索去除html
function ClearSearchAllHtml($value){
	$value=str_replace(array("\r\n","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","","",""),$value);
	$value=strip_tags($value);
	$value=trim($value,"\r\n");
	$value=SearchAllChangeChar($value);//转编码
	return $value;
}

//转换编码
function SearchAllChangeChar($value){
	global $ecms_config,$char,$targetchar,$iconv;
	if($ecms_config['sets']['pagechar']!='gb2312')
	{
		$value=$iconv->Convert($char,$targetchar,$value);
	}
	return $value;
}

//导入数据
function LoadSearchAll($lid,$start,$userid,$username){
	global $empire,$dbtbpre,$class_r,$fun_r,$public_r,$emod_r;
	$lid=(int)$lid;
	if(empty($lid))
	{
		printerror('ErrorUrl','');
	}
	$lr=$empire->fetch1("select tbname,titlefield,infotextfield,loadnum,lastid from {$dbtbpre}enewssearchall_load where lid='$lid'");
	if(empty($lr['tbname']))
	{
		printerror('ErrorUrl','');
	}
	//不导入栏目
	$pr=$empire->fetch1("select schallnotcid from {$dbtbpre}enewspublic limit 1");
	$line=$lr['loadnum'];
	if(empty($line))
	{
		$line=300;
	}
	$start=(int)$start;
	if($start<$lr['lastid'])
	{
		$start=$lr['lastid'];
	}
	//字段
	$selectdtf='';
	$selectf='';
	$savetxtf='';
	$fsql=$empire->query("select tid,f,savetxt,tbdataf from {$dbtbpre}enewsf where (f='$lr[titlefield]' or f='$lr[infotextfield]') and tbname='$lr[tbname]' limit 2");
	while($fr=$empire->fetch($fsql))
	{
		if($fr['tbdataf'])
		{
			$selectdtf.=','.$fr[f];
		}
		else
		{
			$selectf.=','.$fr[f];
		}
		if($fr['savetxt'])
		{
			$savetxtf=$fr[f];
		}
	}
	$b=0;
	$sql=$empire->query("select id,stb,classid,isurl,newstime".$selectf." from {$dbtbpre}ecms_".$lr['tbname']." where id>$start order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['id'];
		if($r['isurl'])
		{
			continue;
		}
		if(empty($class_r[$r[classid]]['tbname']))
		{
			continue;
		}
		if(strstr($pr['schallnotcid'],','.$r[classid].','))
		{
			continue;
		}
		//重复
		$havenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssearchall where id='$r[id]' and classid='$r[classid]' limit 1");
		if($havenum)
		{
			continue;
		}
		//副表
		if($selectdtf)
		{
			$finfor=$empire->fetch1("select id".$selectdtf." from {$dbtbpre}ecms_".$lr['tbname']."_data_".$r[stb]." where id='$r[id]'");
			$r=array_merge($r,$finfor);
		}
		//存文本
		if($savetxtf)
		{
			$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
		}
		$infotext=$r[$lr[infotextfield]];
		$title=$r[$lr[titlefield]];
		$infotime=$r[newstime];
		$title=SearchReturnSaveStr(ClearSearchAllHtml(stripSlashes($title)));
		$infotext=SearchReturnSaveStr(ClearSearchAllHtml(stripSlashes($infotext)));
		$empire->query("insert into {$dbtbpre}enewssearchall(sid,id,classid,title,infotime,infotext) values(NULL,'$r[id]','$r[classid]','".addslashes($title)."','$infotime','".addslashes($infotext)."');");
	}
	if(empty($b))
	{
		$lasttime=time();
		if(empty($newstart))
		{
			$newstart=$start;
		}
		$empire->query("update {$dbtbpre}enewssearchall_load set lasttime='$lasttime',lastid='$newstart' where lid='$lid'");
		echo "<link rel=\"stylesheet\" href=\"../../data/images/css.css\" type=\"text/css\"><center><b>".$lr['tbname'].$fun_r[LoadSearchAllIsOK]."</b></center>";
		db_close();
		$empire=null;
		exit();
	}
	echo"<link rel=\"stylesheet\" href=\"../../data/images/css.css\" type=\"text/css\"><meta http-equiv=\"refresh\" content=\"0;url=LoadSearchAll.php?enews=LoadSearchAll&lid=$lid&start=$newstart".hReturnEcmsHashStrHref(0)."\">".$fun_r[OneLoadSearchAllSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//返回搜索SQL
function ReturnSearchAllSql($add){
	global $public_r,$class_r;
	//关闭
	if(empty($public_r['openschall']))
	{
		printerror("SchallClose",'',1);
	}
	//关键字
	$keyboard=RepPostVar2($add['keyboard']);
	if(!trim($keyboard))
	{
		printerror('EmptySchallKeyboard','',1);
	}
	$strlen=strlen($keyboard);
	if($strlen<$public_r['schallminlen']||$strlen>$public_r['schallmaxlen'])
	{
		printerror('SchallMinKeyboard','',1);
	}
	$returnr['keyboard']=ehtmlspecialchars($keyboard);
	$returnr['search']="&keyboard=".$keyboard;
	//字段
	$field=(int)$add['field'];
	if($field)
	{
		$returnr['search'].="&field=".$field;
	}
	if($field==1)//标题和全文
	{
		if($public_r['schallfield']!=1)
		{
			printerror('SchallNotOpenTitleText','',1);
		}
		$sf="title,infotext";
	}
	elseif($field==2)//标题
	{
		if($public_r['schallfield']==3)
		{
			printerror('SchallNotOpenTitle','',1);
		}
		$sf="title";
	}
	elseif($field==3)//全文
	{
		if($public_r['schallfield']==2)
		{
			printerror('SchallNotOpenText','',1);
		}
		$sf="infotext";
	}
	else
	{
		$sf=ReturnSearchAllField(0);
	}
	$where='';
	//栏目
	$classid=RepPostVar($add['classid']);
	if($classid)
	{
		$returnr['search'].="&classid=".$classid;
		if(strstr($classid,","))//多栏目
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$where.='('.$son_r[1].') and ';
		}
		else
		{
			$classid=(int)$classid;
			$where.=$class_r[$classid][islast]?"classid='$classid' and ":ReturnClass($class_r[$classid][sonclass]).' and ';
		}
	}
	//关键字
	if(strstr($keyboard,' '))
	{
		$andkey='';
		$keyr=explode(' ',$keyboard);
		$kcount=count($keyr);
		for($i=0;$i<$kcount;$i++)
		{
			if(strlen($keyr[$i])<$public_r['schallminlen'])
			{
				continue;
			}
			$kb=SearchAllChangeChar($keyr[$i]);//转码
			$kb=SearchReturnSaveStr($kb);
			$kb=RepPostVar2($kb);
			if(!trim($kb))
			{
				continue;
			}
			$where.=$andkey."MATCH(".$sf.") AGAINST('".$kb."' IN BOOLEAN MODE)";
			$andkey=' and ';
		}
		if(empty($where))
		{
			printerror('SchallMinKeyboard','',1);
		}
	}
	else
	{
		$keyboard=SearchAllChangeChar($keyboard);//转码
		$keyboard=SearchReturnSaveStr($keyboard);
		$keyboard=RepPostVar2($keyboard);
		if(!trim($keyboard))
		{
			printerror('EmptySchallKeyboard','',1);
		}
		$where.="MATCH(".$sf.") AGAINST('".$keyboard."' IN BOOLEAN MODE)";
	}
	$returnr['where']=$where;
	return $returnr;
}

//返回搜索字段
function ReturnSearchAllField($field){
	global $public_r;
	if($public_r['schallfield']==1)
	{
		$sf="title,infotext";
	}
	elseif($public_r['schallfield']==3)
	{
		$sf="infotext";
	}
	else
	{
		$sf="title";
	}
	return $sf;
}
?>