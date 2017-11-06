<?php
/**
 * Created by PhpStorm.
 * User: mazhenyu
 * Date: 25/10/2017
 * Time: 16:14
 * Email: 410004417@qq.com
 */

namespace houdunwang\core;


abstract class Controller {
	protected function message($msg,$url){
		$str = <<<str
<script>
alert('{$msg}');
location.href='{$url}';
</script>
str;
		echo $str;exit;

	}
}