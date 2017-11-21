 <?php 
defined('IN_PHPCMS') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');
$type_db = pc_base::load_model('type_model');
$typeid = $type_db->delete(array('module'=>'upgrade'));
if(!$typeid) return FALSE;
 ?>