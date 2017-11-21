<?php
defined('IN_ADMIN') or exit('No permission resources.');
$defaultvalue = isset($_POST['setting']['defaultvalue']) ? $_POST['setting']['defaultvalue'] : '';
$minnumber = isset($_POST['setting']['minnumber']) ? $_POST['setting']['minnumber'] : 1;
$decimaldigits = isset($_POST['setting']['decimaldigits']) ? $_POST['setting']['decimaldigits'] : '';

switch($field_type) {
	case 'varchar':
		if(!$maxlength) $maxlength = 255;
		$maxlength = min($maxlength, 255);
		$fieldtype = $issystem ? 'CHAR' : 'VARCHAR';
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` $fieldtype( $maxlength ) NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'tinyint':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` TINYINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'number':
		$minnumber = intval($minnumber);
		$defaultvalue = $decimaldigits == 0 ? intval($defaultvalue) : floatval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` ".($decimaldigits == 0 ? 'INT' : 'FLOAT')." ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'smallint':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` SMALLINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'mediumint':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` MEDIUMINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;


	case 'int':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'mediumtext':
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` MEDIUMTEXT NOT NULL";
		if (!$unrunsql) $this->db->query($sql);
	break;
	
	case 'text':
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` TEXT NOT NULL";
		if (!$unrunsql) $this->db->query($sql);
	break;

	case 'date':
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` DATE NULL";
		if (!$unrunsql) $this->db->query($sql);
	break;
	
	case 'datetime':
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` DATETIME NULL";
		if (!$unrunsql) $this->db->query($sql);
	break;
	
	case 'timestamp':
		$sql = "ALTER TABLE `$tablename` CHANGE `$oldfield` `$field` TIMESTAMP NOT NULL";
		if (!$unrunsql) $this->db->query($sql);
	break;
	//特殊自定义字段
	case 'pages':
		
	break;
	case 'readpoint':
		$defaultvalue = intval($defaultvalue);
		$this->db->query("ALTER TABLE `$tablename` CHANGE `$oldfield` `readpoint` smallint(5) unsigned NOT NULL default '$defaultvalue'");
	break;

}
?>