<?php
/**
 *  access.class.php 数据库实现类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class db_access {
	
	/**
	 * 数据库配置信息
	 */
	private $config = null;
	
	/**
	 * 数据库连接资源句柄
	 */
	public $link = null;
	
	/**
	 * 最近一次查询资源句柄
	 */
	public $lastqueryid = null;
	
	/**
	 *  统计数据库查询次数
	 */
	public $querycount = 0;
	
	public function __construct() {

	}
	
	/**
	 * 打开数据库连接,有可能不真实连接数据库
	 * @param $config	数据库连接参数
	 * 			
	 * @return void
	 */
	public function open($config) {
		$this->config = $config;
		if($config['autoconnect'] == 1) {
			$this->connect();
		}
	}

	/**
	 * 真正开启数据库连接
	 * 			
	 * @return void
	 */
	public function connect() {
		/*真正的连接程序*/
		$dbhost = $this->config['hostname'];
		$dbuser = $this->config['username'];
		$dbpwd  = $this->config['password'];
		
		$this->conn = new com('adodb.connection');
		if(!$this->conn) return false;
		$this->conn->open("DRIVER={Microsoft Access Driver (*.mdb)};dbq=$dbhost;uid=$dbuser;pwd=$dbpw");
		if($this->conn->state == 0){
			$this->conn->open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=$dbhost");
			if($this->conn->state == 0)	return false;;
		}
		define('NUM', 1);
		define('ASSOC', 2);
		define('BOTH', 3);
		return $this->conn->state; 
	}
	 
	
function select_db($dbname)
	{
		return $this->conn->state;
	} 

	function query($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$this->querynum++;
		$sql = trim($sql);
		if(preg_match("/^(select.*)limit ([0-9]+)(,([0-9]+))?$/i", $sql, $matchs))
		{
			$sql = $matchs[1];
			$offset = $matchs[2];
			$pagesize = $matchs[4];
			$query = $this->conn->Execute($sql);
			return $this->limit($query, $offset, $pagesize);
		}
		else
		{
			return $this->conn->Execute($sql);
		}
	}

	function get_one($query)
	{
		$this->querynum++;
	    $rs = $this->conn->Execute($query);
		$r = $this->fetch_array($rs);
		$this->free_result($rs);
		return $r;
	}

	function fetch_array($rs, $result_type = 3)
	{
		if(is_array($rs))
		{
			return $this->cursor < count($rs) ? $rs[$this->cursor++] : FALSE;
		}
		else
		{
			if($rs->EOF) return FALSE;
			$array = array();
			for($i = 0; $i < $this->num_fields($rs); $i++)
			{
				$fielddata = $rs->Fields[$i]->Value;
			    if($result_type == NUM || $result_type == BOTH) $array[$i] = $fielddata;
			    if($result_type == ASSOC || $result_type == BOTH) $array[$rs->Fields[$i]->Name] = $fielddata;
			}
			$rs->MoveNext();
			return $array;
		}
	}
	
	function select($sql, $keyfield = '')
	{
		$array = array();
		$result = $this->query($sql);
		while($r = $this->fetch_array($result))
		{
			if($keyfield)
			{
				$key = $r[$keyfield];
				$array[$key] = $r;
			}
			else
			{
				$array[] = $r;
			}
		}
		$this->free_result($result);
		return $array;
	}

	function num_rows($rs)
	{
	    return is_array($rs) ? count($rs) : $rs->recordcount;
	}

	function num_fields($rs)
	{
	    return $rs->Fields->Count;
	}

	function fetch_assoc($rs)
	{
	    return $this->fetch_array($rs, ASSOC);
	}

	function fetch_row($rs)
	{
	    return $this->fetch_array($rs, NUM);
	}

	function free_result($rs)
	{
	    if(is_resource($rs)) $rs->close();
	}

	function error()
	{
	    return $this->conn->Errors[$this->conn->Errors->Count-1]->Number;
	}

	function errormsg()
	{
	    return $this->conn->Errors[$this->conn->Errors->Count-1]->Description;
	}

	function close()
	{
	    $this->conn->close();
	}

	function limit($rs, $offset, $pagesize = 0)
	{
		if($pagesize > 0)
		{
			$rs->Move($offset);
		}
		else
		{
			$pagesize = $offset;
		}
		$info = array();
		for($i = 0; $i < $pagesize; $i++)
		{
			$r = $this->fetch_array($rs);
			if(!$r) break;
			$info[] = $r;
		}
		$this->free_result($rs);
		$this->cursor = 0;
		return $info;
	}
}
?>