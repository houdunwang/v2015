<?php 
if(!$maxlength) $maxlength = 255;
$maxlength = min($maxlength, 255);
$fieldtype = $issystem ? 'CHAR' : 'VARCHAR';
$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$defaultvalue'";
$db->query($sql);
?>