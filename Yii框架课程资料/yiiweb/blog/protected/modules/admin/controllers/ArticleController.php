<?php
/**
 * 文章管理控制器
 */
class ArticleController extends Controller{

	public function filters(){
		return array(
				'accessControl',
			);
	}

	public function accessRules(){
		return array(
			//更加具体化
			// array(
			// 	'deny',
			// 	'actions'=>array('del','add'),
			// 	'users'	=> array('admin')
			// 	),

			array(
				'allow',
				'actions'=>array('index', 'del','add'),
				'users'	=> array('@')
				),
			array(
				'deny',
				'users' => array('*')
				),


			);
	}


	/**
	 * 查看文章
	 */
	public function actionIndex(){
		$cri = new CDbCriteria();
		$articleModel = Article::model();
		$total = $articleModel->count($cri);

		$pager = new CPagination($total);
		$pager->pageSize = 3;
		$pager->applyLimit($cri);

		$articleInfo = $articleModel->findAll($cri);

		$data = array(
			'articleInfo'	=> $articleInfo,
			'pages'			=> $pager
			);

		$this->render('index', $data);
	}
	/**
	 * 添加文章
	 */
	public function actionAdd(){
		// $articleModel->thumb;
		// echo Yii::app()->BasePath;die;
		$articleModel = new Article();
		$category = Category::model();

		$categoryInfo = $category->findAllBySql("SELECT cid,cname FROM {{category}}");
		$cateArr = array();
		$cateArr[] = '请选择';
		foreach ($categoryInfo as $v) {
			$cateArr[$v->cid] = $v->cname;
		}

		$data = array(
			'articleModel'	=> $articleModel,
			'cateArr'		=> $cateArr
			);
		if(isset($_POST['Article'])){

			$articleModel->thumb = CUploadedFile::getInstance($articleModel, 'thumb');

			if($articleModel->thumb){
				$preRand = 'img_' . time() . mt_rand(0, 9999);
				$imgName = $preRand . '.' . $articleModel->thumb->extensionName;
				$articleModel->thumb->saveAs('uploads/' . $imgName);
				$articleModel->thumb = $imgName;

				//缩略图
				$path = dirname(Yii::app()->BasePath) . '/uploads/';

				$thumb = Yii::app()->thumb;
				$thumb->image = $path . $imgName;
				$thumb->width = 130;
				$thumb->height=95;
				$thumb->mode = 4;
				$thumb->directory = $path;
				$thumb->defaultName = $preRand;

				$thumb->createThumb();
				$thumb->save();
			}	


			$articleModel->attributes = $_POST['Article'];
			$articleModel->time = time();

			if($articleModel->save()){
				$this->redirect(array('index'));
			}
		}


		$this->render('add', $data);
	}


	public function actionDel($aid){
		$articleModel = Article::model();

		if($articleModel->deleteByPk($aid)){
			$this->redirect(array('index'));
		}
	}
}









