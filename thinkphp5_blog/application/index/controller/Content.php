<?php

namespace app\index\controller;


class Content extends Common
{
    //首页
	public function index()
	{

		//获取文章数据
		$arc_id = input('param.arc_id');
		//文章点击次数+1
		db('article')->where('arc_id',$arc_id)->setInc('arc_click');
		$articleData = db('article')->field('arc_id,arc_title,arc_author,arc_content,sendtime')->find($arc_id);
		$headConf = ['title'=>"后盾教学博客--{$articleData['arc_title']}"];
		$this->assign('headConf',$headConf);
//		dump($articleData);
		//当前文章标签
		$articleData['tags'] = db('arc_tag')->alias('at')
		->join('__TAG__ t','at.tag_id=t.tag_id')
			->where('at.arc_id',$articleData['arc_id'])->field('t.tag_id,t.tag_name')->select();
		//dump($articleData);
		$this->assign('articleData',$articleData);
		return $this->fetch();
	}
}
