<?php

namespace app\controller;

use Vaptcha\Vaptcha;

class Entry
{
	protected $vaptcha;

	public function __construct ()
	{
		$this->vaptcha = new Vaptcha( '5af2a45da485e10410d20a4d' , '0916fe1d0b484c5384a98d283fa7af6d' ); // 实例化sdk，$vid 和 $key 对应验证单元中的Vid和Key
	}

	public function index ()
	{
		include './view/index.html';
	}

	/**
	 * 获取流水号
	 */
	public function getvaptcha ()
	{
		$res = $this->vaptcha->getChallenge ();
		echo json_encode ( $res );
		exit;
	}

	/**
	 * 宕机模式
	 */
	public function getDownTime(){
		$data = $_GET["data"];
		$res = $this->vaptcha->downTime($data);
		echo json_encode ( $res );
		exit;
	}

	/**
	 * 登录
	 */
	public function login(){
		$res = $this->vaptcha->validate($_POST['challenge'], $_POST['token']);
		if(!$res){
			echo json_encode (['code'=>0,'msg'=>'请先进行人机验证']);
			exit;
		}
		if($_POST['username'] == 'houdunren' && $_POST['password']=='houdunren'){
			echo json_encode (['code'=>1,'msg'=>'登录成功']);
			exit;
		}else{
			echo json_encode (['code'=>0,'msg'=>'用户名或者密码不正确']);
			exit;
		}
	}
}