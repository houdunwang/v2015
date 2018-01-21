<?php
define('InEmpireBAKDbSql',TRUE);

//------------------------- 数据库 -------------------------

function do_dbconnect($dbhost,$dbport,$dbusername,$dbpassword,$dbname=''){
	global $phome_db_char,$phome_db_ver;
	$dblocalhost=$dbhost;
	//端口
	if($dbport)
	{
		$dblocalhost.=':'.$dbport;
	}
	$dblink=@mysql_connect($dblocalhost,$dbusername,$dbpassword);
	if(!$dblink)
	{
		eDbConnectError();
	}
	//编码
	if($phome_db_ver>='4.1')
	{
		//编码
		DoSetDbChar($phome_db_char);
		if($phome_db_ver>='5.0')
		{
			@mysql_query("SET sql_mode=''");
		}
	}
	if($dbname)
	{
		@mysql_select_db($dbname,$dblink);
	}
	return $dblink;
}

function do_dbclose(){
	global $link;
	if($link)
	{
		@mysql_close($link);
	}
}

//设置编码
function do_DoSetDbChar($dbchar){
	@mysql_query('set character_set_connection='.$dbchar.',character_set_results='.$dbchar.',character_set_client=binary;');
}

//取得mysql版本
function do_eGetDBVer($selectdb=0){
	global $empire;
	if($selectdb&&$empire)
	{
		$getdbver=$empire->egetdbver();
	}
	else
	{
		$getdbver=@mysql_get_server_info();
	}
	return $getdbver;
}

//普通操作
function do_dbconnect_common($dbhost,$dbport,$dbusername,$dbpassword,$dbname=''){
	global $phome_db_char,$phome_db_ver;
	$dblocalhost=$dbhost;
	//端口
	if($dbport)
	{
		$dblocalhost.=':'.$dbport;
	}
	$dblink=@mysql_connect($dblocalhost,$dbusername,$dbpassword);
	return $dblink;
}

function do_dbquery_common($query,$ecms=0){
	if($ecms==0)
	{
		$sql=@mysql_query($query);
	}
	else
	{
		$sql=mysql_query($query);
	}
	return $sql;
}

//选择数据库
function do_eUseDb($dbname,$query=0){
	if($query)
	{
		$usedb=do_dbquery_common('use `'.$dbname.'`');
	}
	else
	{
		$usedb=@mysql_select_db($dbname,return_dblink(''));
	}
	return $usedb;
}



//------------------------- 数据库操作 -------------------------

class mysqlquery
{
	var $sql;//sql语句执行结果
	var $query;//sql语句
	var $num;//返回记录数
	var $r;//返回数组
	var $id;//返回数据库id号
	//执行mysql_query()语句
	function query($query)
	{
		$this->sql=mysql_query($query) or die(mysql_error()."<br>".$query);
		return $this->sql;
	}
	//执行mysql_query()语句2
	function query1($query)
	{
		$this->sql=mysql_query($query);
		return $this->sql;
	}
	//执行mysql_fetch_array()
	function fetch($sql)//此方法的参数是$sql就是sql语句执行结果
	{
		$this->r=mysql_fetch_array($sql);
		return $this->r;
	}
	//执行fetchone(mysql_fetch_array())
	//此方法与fetch()的区别是:1、此方法的参数是$query就是sql语句 
	//2、此方法用于while(),for()数据库指针不会自动下移，而fetch()可以自动下移。
	function fetch1($query)
	{
		$this->sql=$this->query($query);
		$this->r=mysql_fetch_array($this->sql);
		return $this->r;
	}
	//执行mysql_num_rows()
	function num($query)//此类的参数是$query就是sql语句
	{
		$this->sql=$this->query($query);
		$this->num=mysql_num_rows($this->sql);
		return $this->num;
	}
	//执行numone(mysql_num_rows())
	//此方法与num()的区别是：1、此方法的参数是$sql就是sql语句的执行结果。
	function num1($sql)
	{
		$this->num=mysql_num_rows($sql);
		return $this->num;
	}
	//执行numone(mysql_num_rows())
	//统计记录数
	function gettotal($query)
	{
		$this->r=$this->fetch1($query);
		return $this->r['total'];
	}
	//执行free(mysql_result_free())
	//此方法的参数是$sql就是sql语句的执行结果。只有在用到mysql_fetch_array的情况下用
	function free($sql)
	{
		mysql_free_result($sql);
	}
	//执行seek(mysql_data_seek())
	//此方法的参数是$sql就是sql语句的执行结果,$pit为执行指针的偏移数
	function seek($sql,$pit)
	{
		mysql_data_seek($sql,$pit);
	}
	//执行id(mysql_insert_id())
	function lastid()//取得最后一次执行mysql数据库id号
	{
		$this->id=mysql_insert_id();
		return $this->id;
	}
	//执行escape_string()函数
	function EDbEscapeStr($str){
		$str=mysql_real_escape_string($str);
		return $str;
	}
	//取得数据库版本
	function egetdbver()
	{
		$this->r=$this->fetch1('select version() as version');
		return $this->r['version'];
	}
}
?>