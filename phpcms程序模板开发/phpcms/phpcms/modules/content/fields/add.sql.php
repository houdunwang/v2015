<?php
defined('IN_ADMIN') or exit('No permission resources.');
$defaultvalue = isset($_POST['setting']['defaultvalue']) ? $_POST['setting']['defaultvalue'] : '';
//正整数 UNSIGNED && SIGNED
$minnumber = isset($_POST['setting']['minnumber']) ? $_POST['setting']['minnumber'] : 1;
$decimaldigits = isset($_POST['setting']['decimaldigits']) ? $_POST['setting']['decimaldigits'] : '';

switch($field_type) {
	case 'varchar':
		if(!$maxlength) $maxlength = 255;
		$maxlength = min($maxlength, 255);
		$sql = "ALTER TABLE `$tablename` ADD `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$defaultvalue'";
		$this->db->query($sql);
	break;

	case 'tinyint':
		if(!$maxlength) $maxlength = 3;
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` TINYINT( $maxlength ) ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'");
	break;
	
	case 'number':
		$minnumber = intval($minnumber);
		$defaultvalue = $decimaldigits == 0 ? intval($defaultvalue) : floatval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` ADD `$field` ".($decimaldigits == 0 ? 'INT' : 'FLOAT')." ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		$this->db->query($sql);
	break;

	case 'smallint':
		$minnumber = intval($minnumber);
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` SMALLINT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL");
	break;

	case 'int':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` ADD `$field` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		$this->db->query($sql);
	break;

	case 'mediumint':
		$minnumber = intval($minnumber);
		$defaultvalue = intval($defaultvalue);
		$sql = "ALTER TABLE `$tablename` ADD `$field` INT ".($minnumber >= 0 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$defaultvalue'";
		$this->db->query($sql);
	break;

	case 'mediumtext':
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` MEDIUMTEXT NOT NULL");
	break;
	
	case 'text':
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` TEXT NOT NULL");
	break;

	case 'date':
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` DATE NULL");
	break;
	
	case 'datetime':
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` DATETIME NULL");
	break;
	
	case 'timestamp':
		$this->db->query("ALTER TABLE `$tablename` ADD `$field` TIMESTAMP NOT NULL");
	break;
	//特殊自定义字段
	case 'pages':
		$this->db->query("ALTER TABLE `$tablename` ADD `paginationtype` TINYINT( 1 ) NOT NULL DEFAULT '0'");
		$this->db->query("ALTER TABLE `$tablename` ADD `maxcharperpage` MEDIUMINT( 6 ) NOT NULL DEFAULT '0'");
	break;
	case 'readpoint':
		$defaultvalue = intval($defaultvalue);
		$this->db->query("ALTER TABLE `$tablename` ADD `readpoint` smallint(5) unsigned NOT NULL default '$defaultvalue'");
		$this->db->query("ALTER TABLE `$tablename` ADD `paytype` tinyint(1) unsigned NOT NULL default '0'");
	break;
}
?>