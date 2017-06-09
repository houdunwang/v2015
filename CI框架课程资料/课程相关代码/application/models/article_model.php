<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 文章管理模型
 */
class Article_model extends CI_Model{
	/**
	 * 发表文章
	 */
	public function add($data){
		$this->db->insert('article', $data);
	}

	/**
	 * 查看文章
	 */
	public function article_category(){
		$data = $this->db->select('aid,title,cname,time')->from('article')->join('category', 'article.cid=category.cid')->order_by('aid', 'asc')->get()->result_array();
		return $data;
	}


	/**
	 * 首页查询文章
	 */
	public function check(){
		$data['art'] = $this->db->select('aid,thumb,title,info')->order_by('time', 'desc')->get_where('article', array('type'=>0))->result_array();

		$data['hot'] = $this->db->select('aid,thumb,title,info')->order_by('time', 'desc')->get_where('article', array('type'=>1))->result_array();

		return $data;
	}

	/**
	 * 右侧文章标题调取
	 */
	public function title($limit){
		$data = $this->db->select('title,aid')->order_by('time', 'desc')->limit($limit)->get('article')->result_array();
		return $data;
	}

	/**
	 * 通过栏目调取文章
	 */
	public function category_article($cid){
		$data = $this->db->select('aid,thumb,title,info')->order_by('time', 'desc')->get_where('article', array('cid'=>$cid))->result_array();
		return $data;
	}


	/**
	 * 通过aid 调取文章
	 */
	
	public function aid_article($aid){
		$data = $this->db->join('category', 'article.cid=category.cid')->get_where('article', array('aid'=>$aid))->result_array();
		return $data;
	}












}