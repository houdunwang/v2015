<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MY_Controller{
	/**
	 * 查看文章
	 */
	public function index(){
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 3;

		//配置项设置
		$config['base_url'] = site_url('admin/article/index');
		$config['total_rows'] = $this->db->count_all_results('article');
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 4;
		$config['first_link'] = '第一页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '最后一页';

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		// p($data);die;
		$offset = $this->uri->segment(4);
		$this->db->limit($perPage, $offset);


		$this->load->model('article_model', 'art');
		$data['article'] = $this->art->article_category();

		// p($data);die;
		$this->load->view('admin/check_article.html', $data);
	}
	/**
	 * 发表文章模板显示
	 */
	public function send_article(){
		$this->load->model('category_model', 'cate');
		$data['category'] = $this->cate->check();

		$this->load->helper('form');
		$this->load->view('admin/article.html', $data);
	}

	/**
	 * 发表文章动作
	 */
	public function send(){

		//载入表单验证类
		$this->load->library('form_validation');
		//设置规则
		// $this->form_validation->set_rules('title', '文章标题', 'required|min_length[5]');
		// $this->form_validation->set_rules('type', '类型', 'required|integer');
		// $this->form_validation->set_rules('cid', '栏目', 'integer');
		// $this->form_validation->set_rules('info', '摘要', 'required|max_length[155]');
		// $this->form_validation->set_rules('content', '内容', 'required|max_length[2000]');
		//执行验证
		$status = $this->form_validation->run('article');

		if($status){
			//文件上传------------------------
			//配置
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '10000';
			$config['file_name'] = time() . mt_rand(1000,9999);

			//载入上传类
			$this->load->library('upload', $config);
			//执行上传
			$status = $this->upload->do_upload('thumb');
		
			$wrong = $this->upload->display_errors();

			if($wrong){
				error($wrong);
			}
			//返回信息
			$info = $this->upload->data();
			// p($info);die;

			//缩略图-----------------
			//配置
			$arr['source_image'] = $info['full_path'];
			$arr['create_thumb'] = FALSE;
			$arr['maintain_ratio'] = TRUE;
			$arr['width'] = 200;
			$arr['height'] = 200;	

			//载入缩略图类
			$this->load->library('image_lib', $arr);
			//执行动作
			$status = $this->image_lib->resize();

			if(!$status){
				error('缩略图动作失败');
			}

			$this->load->model('article_model', 'art');

			$data = array(
				'title'	=> $this->input->post('title'),
				'type'	=> $this->input->post('type'),
				'cid'	=> $this->input->post('cid'),
				'thumb'	=> $info['file_name'],
				'info'	=> $this->input->post('info'),
				'content'=> $this->input->post('content'),
				'time'	=> time()
				);	
			// p($data);die;
			$this->art->add($data);
			success('admin/article/index', '发表成功');
		}else {
			$this->load->model('category_model', 'cate');
			$data['category'] = $this->cate->check();

			$this->load->helper('form');
			$this->load->view('admin/article.html',$data);
		}
	}

	/**
	 * 编辑文章
	 */
	public function edit_article(){
		$this->load->helper('form');
		$this->load->view('admin/edit_article.html');
	}


	/**
	 * 编辑动作
	 */
	public function edit(){
		$this->load->library('form_validation');
		$status = $this->form_validation->run('article');

		if($status){
			echo '数据库操作';
		} else {
			$this->load->helper('form');
			$this->load->view('admin/edit_article.html');
		}
	}







}