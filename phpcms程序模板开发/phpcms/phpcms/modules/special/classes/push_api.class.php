<?php
/**
 * push_api.class.php 专题推送接口类
 * 
 */
defined('IN_PHPCMS') or exit('No permission resources.');

class push_api {
	private $special_api;
	
	public function __construct() {
		$this->special_api = pc_base::load_app_class('special_api', 'special');
	}
	
	/**
	 * 信息推荐至专题接口
	 * @param array $param 属性 请求时，为模型、栏目数组。 例：array('modelid'=>1, 'catid'=>12); 提交添加为二维信息数据 。例：array(1=>array('title'=>'多发发送方法', ....))
	 * @param array $arr 参数 表单数据，只在请求添加时传递。
	 * @return 返回专题的下拉列表 
	 */
	public function _push_special($param = array(), $arr = array()) {
		return $this->special_api->_get_special($param, $arr);
	}
	
	public function _get_type($specialid) {
		return $this->special_api->_get_type($specialid);
	}
}
?>