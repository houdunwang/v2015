<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 19/10/2017
 * Time: 17:19
 * Email: 410004417@qq.com
 */

namespace app\home\controller;


use houdunwang\core\Controller;
use houdunwang\model\Model;
use houdunwang\view\View;
use system\model\Hdr;
use Gregwar\Captcha\CaptchaBuilder;

class Entry extends Controller {
	public function index(){
		//$var =  config('database.DB_NAME');
		//var_dump($var);

		$houdunren = 'www.houdunren.com';
		$houdun = ['houdunren.com','hdr','www.houdunren.com'];
		//Model::exec("INSERT INTO hdr SET name='test'");
		//Model::exec("DELETE FROM hdr WHERE name='test'");
		//$data = Model::query("SELECT * FROM hdr");
		$data = Hdr::get();
		//$data = Hdr::all();
		//$data = Hdr::find(2);
		//p($data);exit;
		View::with(compact('houdun','houdunren','data'))->make();
	}


	public function add(){
		if($_POST){
			Hdr::insert();
			$this->message('添加成功，返回首页','index.php');
		}
		View::make();
	}


	public function delete(){
		Hdr::delete($_GET['id']);
		$this->message('删除成功，返回首页','index.php');

	}

	public function edit(){
		$id = (int)$_GET['id'];
		if($_POST){
			Hdr::update();
			$this->message('修改成功，返回首页','index.php');
		}

		$data = Hdr::find($id);
		View::with(compact('data'))->make();
	}


	public function login(){

	}

	public function captcha(){
		$builder = new CaptchaBuilder;
		$builder->build();
		header('Content-type: image/jpeg');
		$builder->output();
		$_SESSION['phrase'] = strtolower($builder->getPhrase());
	}
}