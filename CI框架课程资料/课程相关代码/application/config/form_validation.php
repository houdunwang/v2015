<?php

$config = array(
	'article'	=>	array(
			array(
				'field'	=>	'title',
				'label'	=> '标题',
				'rules'	=> 'required|min_length[5]'
				),
			array(
				'field'	=>	'type',
				'label'	=> '类型',
				'rules'	=> 'required|integer'
				),
			array(
				'field'	=>	'cid',
				'label'	=> '栏目',
				'rules'	=> 'integer'
				),
			array(
				'field'	=>	'info',
				'label'	=> '摘要',
				'rules'	=> 'required|max_length[155]'
				),
			array(
				'field'	=>	'content',
				'label'	=> '内容',
				'rules'	=> 'required|max_length[2000]'
				)

		),
	'cate'	=> array(
			array(
				'field'	=> 'cname',
				'label'	=> '栏目名称',
				'rules'	=> 'required|max_length[20]'
				),

		),

	);









