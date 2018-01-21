<?php
/**
 *  contentpage.class.php 文章内容页分页类
 *  
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-12
 */

class contentpage {
	private $additems = array (); //定义需要补全的开头html代码
	private $bottonitems = array (); //定义需要补全的结尾HTML代码
	private $html_tag = array (); //HTML标记数组
	private $surplus; //剩余字符数
	public $content; //定义返回的字符
	
	public function __construct() {
		//定义HTML数组
		$this->html_tag = array ('p', 'div', 'h', 'span', 'strong', 'ul', 'ol', 'li', 'table', 'tr', 'tbody', 'dl', 'dt', 'dd');
		$this->html_end_tag = array ('/p', '/div', '/h', '/span', '/strong', '/ul', '/ol', '/li', '/table', '/tr', '/tbody', '/dl', '/dt', '/dd');
		$this->content = ''; //临时内容存储器
		$this->data = array(); //内容存储
	}
	
	/**
	 * 处理并返回字符串
	 * 
	 * @param string $content 待处理的字符串
	 * @param intval $maxwords 每页最大字符数。去除HTML标记后字符数
	 * @return 处理后的字符串
	 */
	public function get_data($content = '', $maxwords = 10000) {
		if (!$content) return '';
		$this->data = array();
		$this->content = '';
		//exit($maxwords);
		$this->surplus = $maxwords; //开始时将剩余字符设置为最大
		//判断是否存在html标记，不存在直接按字符数分页；如果存在HTML标记，需要补全缺失的HTML标记
		if (strpos($content, '<')!==false) {
			$content_arr = explode('<', $content); //将字符串按‘<’分割成数组
			$this->total = count($content_arr); //计算数组值的个数，便于计算是否执行到字符串的尾部
			foreach ($content_arr as $t => $c) {
				if ($c) {
					$s = strtolower($c); //大小写不区分
					//$isadd = 0;
					
					if ((strpos($c, ' ')!==false) && (strpos($c, '>')===false)) {
						$min_point = intval(strpos($c, ' '));
					} elseif ((strpos($c, ' ')===false) && (strpos($c, '>')!==false)) {
						$min_point = intval(strpos($c, '>'));
					} elseif ((strpos($c, ' ')!==false) && (strpos($c, '>')!==false)) {
						$min_point = min(intval(strpos($c, ' ')), intval(strpos($c, '>')));
					}
					$find = substr($c, 0, $min_point);
					//if ($t>26) echo $s.'{}'.$find.'<br>';
					//preg_match('/(.*)([^>|\s])/i', $c, $matches);
					if (in_array(strtolower($find), $this->html_tag)) {
						$str = '<'.$c;
						$this->bottonitems[$t] = '</'.$find.'>'; //属于定义的HTML范围，将结束标记存入补全的结尾数组
						if(preg_match('/<'.$find.'(.*)>/i', $str, $match)) {
							$this->additems[$t] = $match[0]; //匹配出开始标记，存入补全的开始数组
						}
						$this->separate_content($str, $maxwords, $match[0], $t); //加入返回字符串中
					} elseif (in_array(strtolower($find), $this->html_end_tag)) { //判断是否属于定义的HTML结尾标记
						ksort($this->bottonitems); 
						ksort($this->additems);
						if (is_array($this->bottonitems) && !empty($this->bottonitems)) array_pop($this->bottonitems); //当属于是，将开始和结尾的补全数组取消一个
						if (is_array($this->additems) && !empty($this->additems)) array_pop($this->additems);
						$str = '<'.$c;
						$this->separate_content($str, $maxwords, '', $t); //加入返回字符串中
					} else {
						if($t==0){
							$tag = $c;//第一个不可能有<
						}else{
							$tag = '<'.$c;
						}
						if ($this->surplus >= 0) {
							$this->surplus = $this->surplus-strlen(strip_tags($tag));
							if ($this->surplus<0) {
								$this->surplus = 0;
							}
						}
						$this->content .= $tag; //不在定义的HTML标记范围，则将其追加到返回字符串中
						if (intval($t+1) == $this->total) { //判断是否还有剩余字符
							$this->content .= $this->bottonitem();
							$this->data[] = $this->content;
						}
					}
				}
			}
		} else {
			$this->content .= $this->separate_text($content, $maxwords); //纯文字时
		}
		return implode('[page]', $this->data);
	}
	/**
	 * 处理纯文本数据
	 * @param string $str 每条数据
	 * @param intval $max 每页的最大字符
	 */	
	private function separate_text($str = '', $max){
		$str = strip_tags($str);
		$total = ceil(strlen($str)/$max);
		$encoding = 'utf-8';
		if(strtolower(CHARSET)=='gbk') $encoding = 'gbk';

		if(function_exists("mb_strcut")){
			for ( $i=0; $i < $total; $i++ )
			{ 
				$this->data[] =mb_strcut($str,$i*$max,$max,$encoding);
			}			
		}

		return true;
	}		
	/**
	 * 处理每条数据
	 * @param string $str 每条数据
	 * @param intval $max 每页的最大字符
	 * @param string $tag HTML标记
	 * @param intval $t 处理第几个数组,方便判断是否到字符串的末尾
	 * @param intval $n 处理的次数
	 * @param intval $total 总共的次数，防止死循环
	 * @return boolen
	 */
	private function separate_content($str = '', $max, $tag = '', $t = 0, $n = 1, $total = 0) {
		$html = $str;
		$str = strip_tags($str);
		if ($str) $str = @str_replace(array('　'), '', $str);
		if ($str) {
			if ($n == 1) {
				$total = ceil((strlen($str)-$this->surplus)/$max)+1;
			}
			if ($total<$n) {
				return true;
			} else {
				$n++;
			}
			if (strlen($str)>$this->surplus) { //当前字符数超过最大分页数时
				$remove_str = str_cut($str, $this->surplus, '');
				$this->content .= $tag.$remove_str; //连同标记加入返回字符串
				$this->content .= $this->bottonitem(); //补全尾部标记
				$this->data[] = $this->content; //将临时的内容放入数组中
				$this->content = ''; //设置为空
				$this->content .= $this->additem(); //补全开始标记
				$str = str_replace($remove_str, '', $str); //去除已加入
				$this->surplus = $max;
				return $this->separate_content($str, $max, '', $t, $n, $total); //判断剩余字符
			} elseif (strlen($str)==$this->surplus) { //当前字符刚好等于时(彩票几率)
				$this->content .= $html;
				$this->content .= $this->bottonitem();
				if (intval($t+1) != $this->total) { //判断是否还有剩余字符
					$this->data[] = $this->content; //将临时的内容放入数组中
					$this->content = ''; //设置为空
					$this->content .= $this->additem();
				}
				$this->surplus = $max;
			} else { //当前字符数少于最大分页数
				$this->content .= $html;
				if (intval($t+1) == $this->total) { //判断是否还有剩余字符
					$this->content .= $this->bottonitem();
					$this->data[] = $this->content;
				}
				$this->surplus = $this->surplus-strlen($str);
			}
		} else {
			$this->content .= $html;
			if ($this->surplus == 0) {
				$this->content .= $this->bottonitem();
				if (intval($t+1) != $this->total) { //判断是否还有剩余字符
					$this->data[] = $this->content; //将临时的内容放入数组中
					$this->content = ''; //设置为空
					$this->surplus = $max;
					$this->content .= $this->additem();
				}
			}
			if (intval($t+1) == $this->total) { //判断是否还有剩余字符
					$this->content .= $this->bottonitem();
					$this->data[] = $this->content;
			}
		}
		if ($t==($this->total-1)) {
			$pop_arr = array_pop($this->data);
			if ($pop = strip_tags($pop_arr)) {
				$this->data[] = $pop_arr;
			}
		}
		return true;
	}
	
	/**
	 * 补全开始HTML标记
	 */
	private function additem() {
		$content = '';
		if (is_array($this->additems) && !empty($this->additems)) {
			ksort($this->additems);
			foreach ($this->additems as $add) {
				$content .= $add;
			}
		}
		return $content;
	}
	
	/**
	 * 补全结尾HTML标记
	 */
	private function bottonitem() {
		$content = '';
		if (is_array($this->bottonitems) && !empty($this->bottonitems)) {
			krsort($this->bottonitems);
			foreach ($this->bottonitems as $botton) {
				$content .= $botton;
			}
		}
		return $content;
	}
	
}
?> 