<?php
//加载助手函数库
include './helper.php';
$action = isset($_GET['a']) ? $_GET['a'] : 'index';
//实例化控制器类
(new IndexController())->$action ();