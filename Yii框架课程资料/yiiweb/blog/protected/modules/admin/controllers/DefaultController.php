<?php

class DefaultController extends Controller
{

	public function filters(){
		return array(
				'accessControl',
			);
	}

	public function accessRules(){
		return array(
			//更加具体化
			// array(
			// 	'allow',
			// 	'actions'=>array('del','add'),
			// 	'users'	=> array('admin')
			// 	),

			array(
				'allow',
				'actions'=>array('index', 'copy'),
				'users'	=> array('@')
				),
			array(
				'deny',
				'users' => array('*')
				),


			);
	}
	public function actionIndex()
	{
		$this->renderPartial('index');
	}

	public function actionCopy(){
		$this->render('copy');
	}
}