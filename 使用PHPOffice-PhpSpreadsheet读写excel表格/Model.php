<?php

class Model
{
	protected static $pdo = null;

	public function __construct ( $host = '127.0.0.1' , $dbname = '' , $username , $password )
	{
		if ( is_null ( self::$pdo ) ) {
			try {
				$dsn       = 'mysql:host=' . $host . ';dbname=' . $dbname;
				self::$pdo = new PDO( $dsn , $username , $password );
				self::$pdo->query ( 'set names utf8' );
				self::$pdo->setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
			} catch ( Exception $e ) {
				die( $e->getMessage () );
			}
		}
	}

	public function query ( $sql )
	{
		try {
			$res = self::$pdo->query ( $sql );

			return $res->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( Exception $e ) {
			die( $e->getMessage () );
		}
	}

	public function exec ( $sql )
	{
		try {
			return self::$pdo->exec  ( $sql );
		} catch ( Exception $e ) {
			die( $e->getMessage () );
		}
	}
}