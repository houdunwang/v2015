<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/css/public.css">
	<title>Document</title>
	<style type="text/css">
		span{
			color: #f00;
		}
	</style>
</head>
<body>
	<?php $form = $this->beginWidget('CActiveForm',array(
		'enableClientValidation'=> true,
		'clientOptions' => array(
				'validateOnsubmit'	=> true
			),
	)) ?>
	<table class="table">
		<tr>
			<td class="th" colspan="10">添加栏目</td>
		</tr>
		<tr>
			<td><?php echo $form->labelEx($categoryModel, 'cname') ?></td>
			<td>
				<?php echo $form->textField($categoryModel, 'cname') ?>
				<?php echo $form->error($categoryModel, 'cname') ?>
			</td>
		</tr>
		<tr>
			<td colspan="10"><input type="submit" value="添加" class="input_button"/></td>
		</tr>
	</table>
	<?php $this->endWidget() ?>
</body>
</html>