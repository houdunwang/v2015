<?php
/**
 * 前台控制器
 */
class IndexController extends Controller{
	public function filters(){
		return array(
				array(
					'system.web.widgets.COutputCache + index',
					'duration'	=> 30,

					),
			);
	}
	/**
	 * 默认方法
	 */
	public function actionIndex(){
		// $data = array(
		// 	'title'	=> '后盾网'
		// 	);
		// p($data);die;
		$sqlNew = "SELECT thumb,aid,title,info FROM {{article}} WHERE type=0 ORDER BY time DESC";
		$sqlHot = "SELECT thumb,aid,title,info FROM {{article}} WHERE type=1 ORDER BY time DESC";

		$articleModel = Article::model();

		$articleNew = $articleModel->findAllBySql($sqlNew);
		$articleHot = $articleModel->findAllBySql($sqlHot);

		$data = array(
			'articleNew'	=> $articleNew,
			'articleHot'	=> $articleHot
			);

		$this->render('index', $data);
	}

	public function actionAdd(){
		$this->renderPartial('add');
	}
}