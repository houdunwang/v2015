<?php

namespace app\common\model;

use think\Model;

class Webset extends Model
{
    protected $pk = 'webset_id';
    protected $table = 'blog_webset';

	/**
	 * 执行编辑
	 */
    public function edit($data)
	{
		$res = $this->validate([
			'webset_value'=>'require',
		],[
			'webset_value.require'=>'请输入站点配置值'
		])->save($data,[$this->pk=>$data['webset_id']]);
		if($res)
		{
			return ['valid'=>1,'msg'=>'操作成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
}
