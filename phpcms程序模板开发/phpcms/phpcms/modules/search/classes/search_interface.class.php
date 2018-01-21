<?php
/**
 * 搜索接口
 *
 */
class search_interface {
	
	public function __construct() {
		//初始化sphinx
		pc_base::load_app_class('sphinxapi', '', 0);
		$this->cl = new SphinxClient();
		$siteid = get_siteid();
		$search_setting = getcache('search');
		$setting = $search_setting[$siteid];
		
		$mode = SPH_MATCH_EXTENDED2;			//匹配模式
		$host = $setting['sphinxhost'];			//服务ip
		$port = intval($setting['sphinxport']);	//服务端口
		$ranker = SPH_RANK_PROXIMITY_BM25;		//统计相关度计算模式，仅使用BM25评分计算

		$this->cl->SetServer($host, $port);
		$this->cl->SetConnectTimeout(1);
		$this->cl->SetArrayResult(true);
		$this->cl->SetMatchMode($mode);
		$this->cl->SetRankingMode($ranker);
	}
	
	/**
	 * 搜索
	 * @param string $q			关键词	    	类似sql like'%$q%'
	 * @param array $siteids	站点id数组
	 * @param array $typeids	类型ids  		类似sql IN('')
	 * @param array $adddate	时间范围数组 		类似sql between start AND end		 格式:array('start','end');
	 * @param int $offset 		偏移量
	 * @param int $limit  		匹配项数目限制	类似sql limit $offset, $limit
	 * @param string $orderby	排序字段		类似sql order by $orderby {id:文章id,weight:权重}
	 */
	public function search($q, $siteids=array(1), $typeids='', $adddate='', $offset=0, $limit=20, $orderby='@id desc') {

		if(CHARSET != 'utf-8') {
			$q = iconv(CHARSET, 'utf-8', $q);
		}
		
		if($orderby) {
			//按一种类似SQL的方式将列组合起来，升序或降序排列。
			$this->cl->SetSortMode(SPH_SORT_EXTENDED, $orderby);
		}
		if($limit) {
			$this->cl->SetLimits($offset, $limit, ($limit>1000) ? $limit : 1000);
		}
		
		//过滤类型
		if($typeids) {
			$this->cl->SetFilter('typeid', $typeids);
		}
		
		//过滤站点
		if($siteids) {
			$this->cl->SetFilter('siteid', $siteids);
		}
		
		//过滤时间
		if($adddate) {
			$this->cl->SetFilterRange('adddate', $adddate[0], $adddate[1], false);
		}
		
		$res = $this->cl->Query($q, 'main, delta');

		return $res;
	}


	
	
}