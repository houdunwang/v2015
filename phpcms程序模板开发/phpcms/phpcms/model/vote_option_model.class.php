<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class vote_option_model extends model {
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		//$this->db_tablepre = $this->db_config[$this->db_setting]['tablepre'];
		$this->table_name = 'vote_option';
		parent::__construct();
	}
	/**
	 * 说明:添加投票选项操作
	 * @param $data 选项数组
	 * @param $subjectid 投票标题ID
	 */
	function add_options($data, $subjectid,$siteid)
	{
		//判断传递的数据类型是否正确 
		if(!is_array($data)) return FALSE;
		if(!$subjectid) return FALSE;
		foreach($data as $key=>$val)
		{
			if(trim($val)=='') continue;
			$newoption=array(
					'subjectid'=>$subjectid,
					'siteid'=>$siteid,
					'option'=>$val,
					'image'=>'',
					'listorder'=>0
			);
			$this->insert($newoption);

		}
		return TRUE;
	}

	/**
	 * 说明:更新选项  
	 * @param $data 数组  Array ( [44] => 443 [43(optionid)] => 334(option 值) )
	 * @param $subjectid
	 */
	function update_options($data)
	{
		//判断传递的数据类型是否正确 
		if(!is_array($data)) return FALSE;
		foreach($data as $key=>$val)
		{
			if(trim($val)=='') continue;
			$newoption=array(
					'option'=>$val,
			);
			$this->update($newoption,array('optionid'=>$key));

		}
		return TRUE;
	}
	/**
	 * 说明:选项排序
	 * @param  $data 选项数组
	 */
	function set_listorder($data)
	{
		if(!is_array($data)) return FALSE;
		foreach($data as $key=>$val)
		{
			$val = intval($val);
			$key = intval($key);
			$this->db->query("update $tbname set listorder='$val' where {$keyid}='$key'");
		}
		return $this->db->affected_rows();
	}
	/**
	 * 说明:删除指定 投票ID对应的选项 
	 * @param $data
	 * @param $subjectid
	 */
	function del_options($subjectid)
	{
		if(!$subjectid) return FALSE;
		$this->delete(array('subjectid'=>$subjectid));
		return TRUE;
			
	}

	/**
	 * 说明: 查询 该投票的 选项
	 * @param $subjectid 投票ID 
	 */
	function get_options($subjectid)
	{
		if(!$subjectid) return FALSE;
		return $this->select(array('subjectid'=>$subjectid),'*','',$order = 'optionid ASC');
			
	}
	/**
	 * 说明:删除单条对应ID的选项记录 
	 * @param $optionid 投票选项ID
	 */
	function del_option($optionid)
	{
		if(!$optionid) return FALSE;
		return $this->delete(array('optionid'=>$optionid));
	}
}
?>