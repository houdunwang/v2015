<?php
/**
 * 后台用户管理控制器
 */
class UserController extends Controller{
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
				'actions'=>array('passwd'),
				'users'	=> array('@')
				),
			array(
				'deny',
				'users' => array('*')
				),


			);
	}
	/**
	 * 修改密码
	 */
	public function actionPasswd(){
		$userModel = User::model();
		if(isset($_POST['User'])){

			$userInfo = $userModel->find('username=:name', array(':name'=>Yii::app()->user->name));

			$userModel->attributes = $_POST['User'];
			if($userModel->validate()){
				$password = md5($_POST['User']['password1']);

				if($userModel->updateByPk($userInfo->uid, array('password'=>$password))){
					Yii::app()->user->setFlash('success', '修改密码成功');
				}
			}
		}
		// p($_POST);
		$this->render('index', array('userModel'=>$userModel));
	}
}