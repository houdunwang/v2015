<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/css/public.css">
	<title>Document</title>
</head>
<body>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	<?php 
		if(Yii::app()->user->hasFlash('success')){
			echo Yii::app()->user->getFlash('success');
		}

	 ?>
	<table class="table">
		<tr>
			<td class="th" colspan="10">修改密码</td>
		</tr>
		<tr>
			<td>用户</td>
			<td><?php echo Yii::app()->user->name ?></td>
		</tr>
		<tr>
			<td><?php echo $form->labelEx($userModel, 'password') ?></td>
			<td>
				<?php echo $form->passwordField($userModel, 'password') ?>
				<?php echo $form->error($userModel, 'password') ?>
			</td>
		</tr>
		<tr>
			<td><?php echo $form->labelEx($userModel, 'password1') ?></td>
			<td>
				<?php echo $form->passwordField($userModel, 'password1') ?>
				<?php echo $form->error($userModel, 'password1') ?>
			</td>
		</tr>
		<tr>
			<td><?php echo $form->labelEx($userModel, 'password2') ?></td>
			<td>
				<?php echo $form->passwordField($userModel, 'password2') ?>
				<?php echo $form->error($userModel, 'password2') ?> 
			</td>
		</tr>
		<tr>
			<td colspan="10">
				<input type="submit" class="input_button" value="修改" />
			</td>
		</tr>
	</table>
	<?php $this->endWidget() ?>
</body>
</html>