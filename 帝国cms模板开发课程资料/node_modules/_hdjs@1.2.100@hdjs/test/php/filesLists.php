<?php
include '../vendor/autoload.php';
$files = glob('attachment/*');
foreach ($files as $f) {
    $file   = "php/".$f;
    $data[] = [
        'url'        => $file,
        'path'       => $file,
        'size'       => filesize($f),
        'name'       => basename($f),
        'createtime' => date('Y-m-d', filemtime($f)),
    ];
}
$json = ['data' => $data, 'page' => []];
die(json_encode($json));