<?php
/**
 * @author				wangtiecheng(jim_@live.cn)
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			2005-2009 PHPCMS/KU6 Software LLCS
 * @license				http://www.phpcms.cn/license/
 * @datetime			Wed Aug 05 18:37:10 CST 2009
 * @lastmodify			Wed Aug 05 18:37:10 CST 2009
 * ------------------------------------------------------------
 * $xml = new xml();
 * $res = $xml->xml_unserialize($data);
 */

class xml {
    var $parser;
    var $document;
    var $parent;
    var $stack;
    var $last_opened_tag;
  
    public function xml() {
        $this->parser = xml_parser_create();    
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);    
        xml_set_object($this->parser, $this);    
        xml_set_element_handler($this->parser, 'open','close');    
        xml_set_character_data_handler($this->parser, 'data');    
    }
	
    public function destruct() {
		xml_parser_free($this->parser);
	}

	/**
	 * unserialize
	 * @param xml字符串
	 * @return array
	 */
	public function xml_unserialize($xml) {
		$data = $this->parse($xml);    
		$this->destruct();    
		return $data;    
	}

	/**
	 * serialize
	 * @param $data 数组
	 * @return string
	 */
	public function xml_serialize(&$data, $level = 0, $prior_key = NULL) {
		if($level == 0) {
			ob_start();
			echo "<?xml version=\"1.0\" encoding=\"".CHARSET."\"?>\n<root>","\n";
		}
		while(list($key, $value) = each($data)) {
			if(!strpos($key, ' attr')) {
				if(is_array($value) and array_key_exists(0, $value)) {
					$this->xml_serialize($value, $level, $key);    
				} else {
					$tag = $prior_key ? $prior_key : (is_numeric($key) ? 'item' : $key);
					echo str_repeat("\t", $level),'<',$tag;
					if(array_key_exists("$key attr", $data)) {
						while(list($attr_name, $attr_value) = each($data["$key attr"])) {
							echo ' ',$attr_name,'="',new_html_special_chars($attr_value),'"';
						}
						reset($data["$key attr"]);   
					}
					if(is_null($value)) {
						echo " />\n";
					} elseif(!is_array($value)) {
						echo '>',new_html_special_chars($value),"</$tag>\n";
					} else {
						echo ">\n",$this->xml_serialize($value, $level+1),str_repeat("\t", $level),"</$tag>\n";
					}
				}
			}
		}
		reset($data);   
		if($level == 0) {
			$str = &ob_get_contents();
			ob_end_clean();
			return $str.'</root>';
		}
	}

    public function parse(&$data){
        $this->document = array();    
        $this->stack = array();    
        $this->parent = &$this->document;    
        return xml_parse($this->parser, $data, true) ? $this->document : NULL;    
    }

    public function open(&$parser, $tag, $attributes){
        $this->data = '';
        $this->last_opened_tag = $tag;
        if(is_array($this->parent) && array_key_exists($tag, $this->parent)) {
            if(is_array($this->parent[$tag]) && array_key_exists(0,$this->parent[$tag])) {
                $key = $this->count_numeric_items($this->parent[$tag]);
            } else {
                if(array_key_exists("$tag attr", $this->parent)) {   
                    $arr = array('0 attr'=>&$this->parent["$tag attr"], &$this->parent[$tag]);   
                    unset($this->parent["$tag attr"]);   
                } else {
                    $arr = array(&$this->parent[$tag]);   
                }
                $this->parent[$tag] = &$arr;
                $key = 1;
            }
            $this->parent = &$this->parent[$tag];
        } else {
            $key = $tag;
        }

        if($attributes) {
			$this->parent["$key attr"] = $attributes;
		}
        $this->parent  = &$this->parent[$key];
        $this->stack[] = &$this->parent;
    }

   public  function data(&$parser, $data) {
        if($this->last_opened_tag != NULL) {
            $this->data .= $data;
		}
    }

    public function close(&$parser, $tag) {
        if($this->last_opened_tag == $tag) {    
            $this->parent = $this->data;    
            $this->last_opened_tag = NULL;    
        }
        array_pop($this->stack);
        if($this->stack) {
			$this->parent = &$this->stack[count($this->stack)-1];
		}
    }

	public function count_numeric_items(&$array) {
		return is_array($array) ? count(array_filter(array_keys($array), 'is_numeric')) : 0;    
	}

}

?>