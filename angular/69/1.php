<?php
#第一种处理方法
//$content = file_get_contents('php://input');
//print_r(json_decode($content,true));

#第二种方式
print_r($_POST);