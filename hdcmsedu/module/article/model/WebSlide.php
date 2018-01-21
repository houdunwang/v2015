<?php namespace module\article\model;
use houdunwang\model\Model;

/**
 * 幻灯片管理
 * Class WebSlide
 * @package system\model
 * @author 向军 <2300071698@qq.com>
 * @site www.houdunwang.com
 */
class WebSlide extends Model {
	protected $table = 'web_slide';
	protected $allowFill = [ '*' ];
	protected $denyInsertFields = [ 'id' ];
	protected $validate = [
		[ 'title', 'required', '标题不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH ],
		[ 'url', 'required', '链接不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH ],
		[ 'displayorder', 'num:0,255', '排序只能为0~255', self::EXIST_VALIDATE, self::MODEL_BOTH ],
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH ]
	];
}