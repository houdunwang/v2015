<?php namespace system\model;

use hdphp\Model\Model;

class Goods extends Model {

	//数据表
	protected $table = "goods";

	//完整表名
	protected $full = FALSE;

	//自动验证
	protected $validate
		= [
			//['字段名','验证方法','提示信息',验证条件,验证时间]
			[ 'title', 'required', '菜品名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
			[ 'price', 'required', '价格不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
			[ 'thumb', 'required', '图片不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
			[ 'content', 'required', '内容介绍不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ]
		];

	//自动完成
	protected $auto
		= [
			//['字段名','处理方法','方法类型',验证条件,验证时机]
		];

	//自动过滤
	protected $filter
		= [
			//[表单字段名,过滤条件,处理时间]
		];
}