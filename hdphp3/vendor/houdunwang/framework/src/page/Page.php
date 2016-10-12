<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\page;

class Page {

	//总条数
	protected $totalRow;

	//总页数
	protected $totalPage;

	//每页显示数
	protected $row = 15;

	//每页显示页码数
	protected $pageNum = 8;

	//当前页
	protected $selfPage;

	//页面地址
	protected $url;

	//文字描述
	protected $desc = [ 'pre' => '上一页', 'next' => '下一页', 'first' => '首页', 'end' => '尾页', 'unit' => '条' ];

	//前页页码显示样式
	protected $show;

	/**
	 * 显示条数
	 *
	 * @param $row 显示条数
	 *
	 * @return $this
	 */
	public function row( $row ) {
		$this->row = $row;

		return $this;
	}

	/**
	 * 设置页码数量
	 *
	 * @param $num 数量
	 *
	 * @return $this
	 */
	public function pageNum( $num ) {
		$this->pageNum = (int) $num;

		return $this;
	}

	/**
	 * 制作页码
	 *
	 * @param $total 总条数
	 *
	 * @return string
	 */
	public function make( $total ) {
		//总条数
		$this->totalRow = $total;
		//总页数
		$this->totalPage();
		//当前页
		$this->selfPage();
		//基本uri
		$this->setUrl();
	}

	/**
	 * 前台显示页面列表
	 * @return string
	 */
	public function show() {
		if ( $this->totalPage > 1 ) {
			return '<nav><ul class="pagination">' . $this->pre() . $this->strList() . $this->next() . '</ul></nav>';
		} else {
			return '';
		}
	}

	//返回所有分页信息
	public function all( $total ) {
		$show            = [ ];
		$show['count']   = $this->count();
		$show['first']   = $this->first();
		$show['pre']     = $this->pre();
		$show['pres']    = $this->pres();
		$show['strList'] = $this->strList();
		$show['nexts']   = $this->nexts();
		$show['next']    = $this->next();
		$show['end']     = $this->end();
		$show['nowPage'] = $this->nowPage();
		$show['select']  = $this->select();
		$show['input']   = $this->input();
		$show['picList'] = $this->picList();

		return $show;
	}

	//当前页
	private function selfPage() {
		$self           = empty( $_GET['page'] ) ? 1 : max( 1, intval( $_GET['page'] ) );
		$this->selfPage = min( $this->totalPage, $self );
	}

	//获取总页数
	private function totalPage() {
		return $this->totalPage = ceil( $this->totalRow / $this->row );
	}

	//获取总页数
	public function getTotalPage() {
		return $this->totalPage;
	}

	//配置URL地址
	private function setUrl() {
		//自定义了url时不进行处理
		if ( $this->url ) {
			return;
		}

		$url = '';
		foreach ( (array) $_GET as $k => $v ) {
			if ( $k != 'page' ) {
				$url .= "$k=$v&";
			}
		}
		//GET访问模型
		if ( defined( 'MODULE' ) ) {
			$url = "?{$url}page={page}";
		} else {
			//路由访问模式
			$url = __URL__ . "?{$url}page={page}";
		}
		$this->url = $url;
	}

	//获取URL地址
	private function getUrl( $num ) {
		return str_replace( '{page}', $num, $this->url );
	}

	//获取URL前部分
	private function getUrlBefore() {
		return substr( $this->url, 0, strpos( $this->url, '{page}' ) );
	}

	//获取URL后部分
	private function getUrlEnd() {
		return substr( $this->url, - strpos( $this->url, '{page}' ) );
	}

	/**
	 * 定义url
	 *
	 * @param  [type] $url [description]
	 *
	 * @return [type]      [description]
	 */
	public function url( $url ) {
		$this->url = $url;

		return $this;
	}

	/**
	 * 描述文字
	 *
	 * @param  [type] $desc [description]
	 *
	 * @return [type]       [description]
	 */
	public function desc( array $desc = [ ] ) {
		$this->desc = $desc;

		return $this;
	}

	/**
	 * SQL的limit语句
	 *
	 * @return string
	 */
	public function limit() {
		return max( 0, ( $this->selfPage - 1 ) * $this->row ) . "," . $this->row;
	}

	//上一页
	public function pre() {
		if ( $this->selfPage > 1 && $this->selfPage <= $this->totalPage ) {
			return "<li><a href='" . $this->getUrl( $this->selfPage - 1 ) . "' class='pre'>{$this->desc['pre']}</a></li>";
		}

		return $this->totalPage ? "<li class='disabled'><span>{$this->desc['pre']}</span></li>" : '';
	}

	//下一页
	public function next() {
		$next = $this->desc['next'];
		if ( $this->selfPage < $this->totalPage ) {
			return "<li><a href='" . $this->getUrl( $this->selfPage + 1 ) . "' class='next'>{$next}</a></li>";
		}

		return $this->totalPage ? "<li class='disabled'><span>{$next}</span></li>" : '';
	}

	//列表项
	public function pageList() {
		$start = max( 1, min( $this->selfPage - ceil( $this->pageNum / 2 ), $this->totalPage - $this->pageNum ) );
		$end   = min( $this->pageNum + $start, $this->totalPage );

		$pageList = [ ];
		//只有一页不显示页码
		if ( $end == 1 ) {
			return [ ];
		}
		for ( $i = $start;$i <= $end;$i ++ ) {
			if ( $this->selfPage == $i ) {
				$pageList [ $i ] ['url'] = '';
				$pageList [ $i ] ['str'] = $i;
				continue;
			}
			$pageList [ $i ] ['url'] = $this->getUrl( $i );
			$pageList [ $i ] ['str'] = $i;
		}

		return $pageList;
	}

	//文字页码列表
	public function strList() {
		$arr = $this->pageList();

		$str = '';
		foreach ( $arr as $v ) {
			$str .= empty( $v['url'] ) ? "<li class='active'><a href='{$v['url']}'>{$v['str']}</a></li>" : "<li><a href='{$v['url']}'>{$v['str']}</a></li>";
		}

		return $str;
	}

	//图标页码列表
	public function picList() {
		$str   = '';
		$first = $this->selfPage == 1 ? "" : "<a href='" . $this->getUrl( 1 ) . "' class='picList'><span><<</span></a>";
		$end   = $this->selfPage >= $this->totalPage ? "" : "<a href='" . $this->getUrl( $this->totalPage ) . "'  class='picList'><span>>></span></a>";
		$pre   = $this->selfPage <= 1 ? "" : "<a href='" . $this->getUrl( $this->selfPage - 1 ) . "'  class='picList'><span><</span></a>";
		$next  = $this->selfPage >= $this->totalPage ? "" : "<a href='" . $this->getUrl( $this->selfPage + 1 ) . "'  class='picList'><span>></span></a>";

		return $first . $pre . $next . $end;
	}

	//选项列表
	public function select() {
		$arr = $this->pageList();
		if ( ! $arr ) {
			return '';
		}
		$str
			= "<select name='page' class='page_select' onchange='
        javascript:
        location.href=this.options[selectedIndex].value;'>";
		foreach ( $arr as $v ) {
			$str .= empty( $v ['url'] ) ? "<option value='{$this->getUrl($v['str'])}' selected='selected'>{$v['str']}</option>" : "<option value='{$v['url']}'>{$v['str']}</option>";
		}

		return $str . "</select>";
	}

	//输入框
	public function input() {
		$str
			= "<input id='pagekeydown' type='text' name='page' value='{$this->selfPage}' class='pageinput' onkeydown = \"javascript:
        if(event.keyCode==13){
            location.href='{$this->getUrl('B')}'+this.value+'{$this->getUrl('A')}';
        }
        \"/>
        <button class='pagebt' onclick = \"javascript:
        var input = document.getElementById('pagekeydown');
        location.href='{$this->getUrlBefore()}'+input.value+'{$this->getUrlEnd()}';
        \">进入</button>
        ";

		return $str;
	}

	//前几页
	public function pres() {
		$num = max( 1, $this->selfPage - $this->pageNum );

		return $this->selfPage > $this->pageNum ? "<li><a href='" . $this->getUrl( $num ) . "' class='pres'>前{$this->pageNum}页</a></li>" : "";
	}

	//后几页
	public function nexts() {
		$num = min( $this->totalPage, $this->selfPage + $this->pageNum );

		return $this->selfPage + $this->pageNum < $this->totalPage ? "<li><a href='" . $this->getUrl( $num ) . "' class='nexts'>后{$this->pageNum}页</a></li>" : "";
	}

	//首页
	public function first() {
		$first = $this->desc ['first'];

		return $this->selfPage - $this->pageNum > 1 ? "<a href='" . $this->getUrl( 1 ) . " class='first'>{$first}</a>" : "";
	}

	//末页
	public function end() {
		$end = $this->desc ['end'];

		return $this->selfPage < $this->totalPage - $this->pageNum ? "<a href='" . $this->getUrl( $this->totalPage ) . "' class='end'>{$end}</a>" : "";
	}

	//n-m页
	public function nowPage() {
		$start = ( $this->selfPage - 1 ) * $this->row + 1; //当前页开始ID
		$end   = min( $this->selfPage * $this->row, $this->totalRow ); //当前页结束ID
		return "<span class='nowPage'>第{$start}-{$end}{$this->desc['unit']}</span>";
	}

	//count统计
	public function count() {
		return "<span class='count'>[共{$this->totalPage}页] [{$this->totalRow}条记录]</span>";
	}
}