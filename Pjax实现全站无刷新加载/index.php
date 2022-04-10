<?php
include './vendor/autoload.php';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
(new \app\controller\Entry())->$action();