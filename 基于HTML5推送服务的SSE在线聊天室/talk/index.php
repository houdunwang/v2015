<?php 
class TalkController{
	private static $pdo = NULL;
	public function __construct(){
		if($_GET['a'] != 'login' && !isset($_SESSION['nickname'])){
			header('Location:index.php?a=login');
		}
		if(is_null(self::$pdo)){
			try {
			  	$dsn = "mysql:host=127.0.0.1;dbname=talk";
				$pdo = new PDO($dsn,'root','',array(PDO::ATTR_PERSISTENT=>TRUE));
				$pdo->query("SET NAMES UTF8");
				self::$pdo = $pdo;    
			} catch (Exception $e) {
			    die("Connect Error");   
			}
		}
	}
	
	public function index(){
		include "./show.html";
	}
	
	public function get(){
		header('Content-Type:text/event-stream');
		header('Cache-Control:no-cache');
		$sql = "SELECT * FROM message ORDER BY time ASC LIMIT 15";
		$result = self::$pdo->query($sql);
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $v) {
			$time = date('H:i:s',$v['time']);
			echo "data:[$time] <span style='color:red'>{$v['nickname']}</span> : {$v['content']}<br/>\n";
		}
		echo "retry:1000\n";
		echo "\n\n";
		ob_flush();
		flush();
	}
	
	public function login(){
		if(!empty($_POST)){
			$_SESSION['nickname'] = $_POST['nickname'];
			header('Location:index.php');
		}
		include "./login.html";
	}

	public function put(){
		$content = $_POST['content'];
		$time = time();
		$nickname = $_SESSION['nickname'];
		$sql = "INSERT INTO message (content,time,nickname) VALUES ('{$content}',{$time},'{$nickname}')";
		self::$pdo->exec($sql);
	}
	
	
}

session_start();
date_default_timezone_set('PRC');
$action = $_GET['a'] = isset($_GET['a']) ? $_GET['a'] : 'index';
$controller = new TalkController;

$controller->$action();

 ?>