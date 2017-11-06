<?php
namespace app\home\controller;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;

class Entry extends Controller{
	public function index(){
		$where = isset($_GET['gid']) ? " WHERE g.gid=" . (int)$_GET['gid'] : "";
		$data = Model::query("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid {$where}");
		View::with(compact('data'))->make();
	}

	public function show(){
		$sid = (int)$_GET['sid'];
		$data = Model::query("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid WHERE sid={$sid}");
		$data = current($data);
		View::with(compact('data'))->make();
	}
}