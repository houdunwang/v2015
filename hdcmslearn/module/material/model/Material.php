<?php namespace module\material\model;

use houdunwang\model\Model;

/**
 * 素材管理
 * Class Material
 * @package module\material\model
 * @author 向军 <2300071698@qq.com>
 * @site www.houdunwang.com
 */
class Material extends Model {
	protected $table = 'material';

	protected $auto = [
		[ 'data', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'file', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'media_id', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'url', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'siteid', SITEID, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'createtime', 'time', 'function', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'status', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ]
	];
}