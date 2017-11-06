<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Grade as GradeModel;

class Grade extends Common {
	/**
	 * 班级列表
	 */
	public function lists(){
		$data = GradeModel::query("SELECT *,g.gid ggid,count(sid) total FROM grade g LEFT JOIN stu s ON g.gid=s.gid GROUP BY g.gid");
		View::with(compact('data'))->make();
	}

	/**
	 * 添加班级
	 */
	public function add(){
		if($_POST){
			GradeModel::insert();
			$this->message('添加成功','?s=admin/grade/lists');
		}
		View::make();
	}

	/**
	 * 编辑班级
	 */
	public function edit(){
		if($_POST){
			GradeModel::update();
			$this->message('修改成功','?s=admin/grade/lists');

		}
		$ggid = (int)$_GET['ggid'];
		$oldData = GradeModel::find($ggid);
		View::with(compact('oldData'))->make();
	}

	/**
	 * 删除班级
	 */
	public function delete(){
		$ggid = (int)$_GET['ggid'];
		//班级下面是否有学生
		$data = Model::query("SELECT * FROM stu WHERE gid={$ggid}");
		if($data){
			$this->message('请先删除该班级下面的学生','?s=admin/grade/lists');
		}
		GradeModel::delete($ggid);
		$this->message('删除成功','?s=admin/grade/lists');


	}













}