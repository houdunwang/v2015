<?php 
header('Content-Type:text/event-stream');
header('Cache-Control:no-cache');
$num = mt_rand(0, 1000);
echo "data:$num\n\n";
ob_flush();
flush();

 ?>