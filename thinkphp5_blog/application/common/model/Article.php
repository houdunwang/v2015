<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'arc_id';
    protected $table = 'blog_article';
    protected $auto = ['admin_id'];
    protected $insert = ['sendtime'];
    protected $update = ['updatetime'];

	protected function setAdminIdAttr($value)
	{
		return session('admin.admin_id');
	}
	protected function setSendTimeAttr($value)
	{
		return time();
	}
	protected function setUpdateTimeAttr($value)
	{
		return time();
	}
	/**
	 * 获取文章首页数据
	 */
	public function getAll()
	{
		return  db('article')->alias('a')
			->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',2)
			->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,c.cate_name,a.arc_sort')
			->order('a.arc_sort desc,a.sendtime desc,a.arc_id desc')->paginate(2);

	}
    /**
	 * 添加文章
	 */
    public function store($data)
	{
		//halt($data);
		if(!isset($data['tag']))
		{
			//说明添加的时候没有选择标签
			return ['valid'=>0,'msg'=>'请选择标签'];
		}
		//验证
		//添加数据库
		$result = $this->validate(true)->allowField(true)->save($data);
		if($result)
		{
			//文章标签中间表的添加
			foreach($data['tag'] as $v)
			{
				$arcTagData = [
					'arc_id'=>$this->arc_id,
					'tag_id'=>$v,
				];
				(new ArcTag())->save($arcTagData);
			}
			//执行成功
			return ['valid'=>1,'msg'=>'操作成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
}
