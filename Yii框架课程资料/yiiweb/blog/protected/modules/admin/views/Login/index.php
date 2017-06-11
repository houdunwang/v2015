<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/css/login.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/js/login.js"></script>
	<title></title>
</head>
<body>
	<div id="divBox">
		<?php $form = $this->beginWidget('CActiveForm') ?>
			<?php echo $form->textField($loginForm, 'username', array('id'=>'userName')) ?>
			<?php echo $form->passwordField($loginForm, 'password', array('id'=>'psd')) ?>
			<?php echo $form->textField($loginForm, 'captcha', array('id'=>'verify')) ?>
			<input type="submit" id="sub" value=""/>
			<!-- 验证码 -->
			<div class="captcha">
				<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer'))); ?>
			</div>
		<?php $this->endWidget() ?>
		<div class="four_bj">
			
			<p class="f_lt"></p>
			<p class="f_rt"></p>
			<p class="f_lb"></p>
			<p class="f_rb"></p>
		</div>
		<ul id="peo">
			<li class="error"><?php echo $form->error($loginForm,'username') ?></li>
		</ul>
		<ul id="psd">
			<li class="error"><?php echo $form->error($loginForm,'password') ?></li>
		</ul>
		<ul id="ver">
			<li class="error"><?php echo $form->error($loginForm,'captcha') ?></li>
		</ul>
	</div>
<!--[if IE 6]>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/js/iepng.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('form','background');
    </script>
<![endif]-->
</body>
</html>