<?php
/**
 * 单一入口
 */
include './vendor/autoload.php';
session_id () || session_start ();
$action = isset($_GET['a']) ? $_GET['a'] : 'index';
(new \app\controller\Entry())->$action();