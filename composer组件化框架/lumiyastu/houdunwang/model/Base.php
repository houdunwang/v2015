<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 24/10/2017
 * Time: 15:34
 * Email: 410004417@qq.com
 */

namespace houdunwang\model;
use PDO;
use PDOException;

class Base {
	private static $pdo;
	private $table;

	public function __construct($table) {
		$this->connect();
		$this->table = $table;
	}

	private function connect(){
		if(is_null(self::$pdo)){
			$dsn = 'mysql:host='.config('database.DB_HOST').';dbname=' . config('database.DB_NAME');
			try{
				$pdo = new PDO($dsn,config('database.DB_USER'),config('database.DB_PASSWORD'));
				$pdo->exec("SET NAMES " . config('database.DB_CHARSET'));
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				self::$pdo = $pdo;
			}catch (PDOException $e){
				echo $e->getMessage();
				exit;
			}
		}

	}


	public function query($sql){
		try{
			$result = self::$pdo->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			//p($rows);
		}catch (PDOException $e){
			echo $e->getMessage();
			exit;
		}

		return $rows;
	}


	public function exec($sql){
		try{
			$afRows = self::$pdo->exec($sql);
			return $afRows;
		}catch (PDOException $e){
			echo $e->getMessage();
			exit;
		}

	}


	public function get(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->query($sql);
	}

	public function all(){
		return $this->get();
	}


	public function find($pri){
		$prikey  = $this->getPriKey();
		$sql = "SELECT * FROM {$this->table} WHERE {$prikey}={$pri}";
		$rows = $this->query($sql);
		if($rows){
			return current($rows);
		}else{
			return [];
		}
	}


	public function insert(){
		$field = array_keys($_POST);
		$field = implode(',',$field);
		$value = array_values($_POST);
		$value = "'" . implode("','",$value) . "'";
		$sql = "INSERT INTO {$this->table} ({$field}) VALUES ($value)";
		return $this->exec($sql);
	}


	public function delete($pri){
		$prikey  = $this->getPriKey();
		$sql = "DELETE FROM {$this->table} WHERE $prikey={$pri}";
		return $this->exec($sql);
	}

	public function update(){
		//id
		$prikey  = $this->getPriKey();
		if(!isset($_POST[$prikey])){
			echo 'update miss primary key';exit;
		}else{
			$fields = '';
			foreach ( $_POST as $field => $value ) {
				$fields .= $field . "='" . $value . "',";
			}
			$fields = rtrim($fields,',');

			$sql = "UPDATE {$this->table} SET {$fields} WHERE {$prikey}={$_POST[$prikey]}";
			return $this->exec($sql);
		}

	}


	private function getPriKey(){
		$data = $this->query("DESC {$this->table}");
		foreach ( $data as $v ) {
			if($v['Key'] == 'PRI'){
				$prikey = $v['Field'];
			}
		}
		return $prikey;
	}

}











