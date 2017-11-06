<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Stu;

class Student extends Common {
	public function lists(){
		$data = Stu::query("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid");
		//p($data);
		View::with(compact('data'))->make();
	}

	public function add(){
		if($_POST){
			$_POST['hobby'] = implode(',',$_POST['hobby']);
			Stu::insert();
			$this->message('添加成功',"?s=admin/student/lists");
		}
		$gradeData = \system\model\Grade::get();
		View::with(compact('gradeData'))->make();
	}

	public function delete(){
		$sid = (int)$_GET['sid'];
		Stu::delete($sid);
		$this->message('删除成功','?s=admin/student/lists');
	}

	public function edit(){
		if($_POST){
			$_POST['hobby'] = implode(',',$_POST['hobby']);
			Stu::update();
			$this->message('编辑成功',"?s=admin/student/lists");
		}
		$sid = (int)$_GET['sid'];
		$gradeData = \system\model\Grade::get();
		$data = Stu::find($sid);
		$data['_hobby'] = explode(',',$data['hobby']);
		View::with(compact('gradeData','data'))->make();

	}
}