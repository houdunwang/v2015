<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 默认前台控制器
 */
class Home extends CI_Controller{
	public $category;
	public $title;

	public function __construct(){
		parent::__construct();

		$this->load->model('article_model', 'art');
		$this->load->model('category_model', 'cate');

		$this->category = $this->cate->limit_category(4);
		$this->title = $this->art->title(10);
	}
	/**
	 * 默认首页显示方法
	 */
	public function index(){
		$this->output->enable_profiler(TRUE);
		// echo base_url() . 'style/index/';
		// echo site_url() . '/index/home/category';

		$data = $this->art->check();

		$data['category'] = $this->category;

		$data['title'] = $this->title;
		$this->output->cache(5/60);
		$this->load->view('index/home.html', $data);
	}


	/**
	 * 分类页显示
	 */
	public function category(){
		$data['category'] = $this->category;

		$data['title'] = $this->title;

		$cid = $this->uri->segment(2);
		$data['article'] = $this->art->category_article($cid);


		$this->load->view('index/category.html', $data);
	}


	/**
	 * 文章阅读页显示
	 */
	public function article(){
		$aid = $this->uri->segment(2);

		$data['category'] = $this->category;

		$data['title'] = $this->title;

		$data['article'] = $this->art->aid_article($aid);

		// p($data);

		$this->load->view('index/article.html', $data);
	}

















}