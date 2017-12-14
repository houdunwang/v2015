<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
DoWapHeader('提示信息');
?>
<p><?php echo $error;?><br /><a href="<?php echo $returnurl;?>">返回</a></p>
<?php
DoWapFooter();
?>