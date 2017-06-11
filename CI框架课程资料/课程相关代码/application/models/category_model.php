<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 栏目管理模型
 */
class Category_model extends CI_Model{
	/**
	 * 添加
	 */
	public function add($data){
		$this->db->insert('category', $data);
	}

	/**
	 * 查看栏目
	 */
	public function check(){
		$data = $this->db->get('category')->result_array();
		return $data;
	}


	/**
	 * 查询对应栏目
	 */
	public function check_cate($cid){
		$data = $this->db->where(array('cid'=>$cid))->get('category')->result_array();
		return $data;
	}


	/**
	 * 修改栏目
	 */
	public function update_cate($cid, $data){
		$this->db->update('category', $data, array('cid'=>$cid));
	}


	/**
	 * 删除栏目
	 */
	public function del($cid){
		$this->db->delete('category', array('cid'=>$cid));
	}


	/**
	 * 调取导航栏栏目
	 */
	public function limit_category($limit){
		$data = $this->db->limit($limit)->get('category')->result_array();
		return $data;
	}















}