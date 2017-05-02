<?php
$data = [
	['id'=>1, 'name' => '后盾人', 'url' => 'houdunren.com' ],
	['id'=>2, 'name' => '后盾网', 'url' => 'houdunwang.com' ],
];
echo json_encode($data,JSON_UNESCAPED_UNICODE);