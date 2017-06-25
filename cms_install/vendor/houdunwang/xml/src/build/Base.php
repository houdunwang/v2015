<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\xml\build;

use Exception;

class Base
{
    /**
     * 数组转为xml数据
     *
     * @param $rootNode
     * @param $phpArray
     *
     * @return string
     */
    public function toXml($rootNode, $phpArray)
    {
        $xml = Array2XML::createXML($rootNode, $phpArray);
        return $xml->saveXML();
    }

    /**
     * xml转为数组
     *
     * @param $xml
     *
     * @return \DOMDocument
     * @throws Exception
     */
    public function toArray($xml)
    {
        return XML2Array::createArray($xml);
    }

    /**
     * 生成xml字符,不能分析复杂的XML数据比如有属性的XML
     *
     * @param array $data
     * @param int   $level
     *
     * @return string
     * @throws Exception
     */
    public function toSimpleXml(array $data, $level = 0)
    {
        if ( ! is_array($data)
            || count($data) <= 0
        ) {
            throw new \Exception("数组数据异常！");
        }
        if ($level == 0) {
            $xml = "<xml>";
        }
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $xml .= "<".$key.">".$this->toSimpleXml($val, 1)."</".$key.">";
            } else if (is_numeric($val)) {
                $xml .= "<".$key.">".$val."</".$key.">";
            } else {
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        if ($level == 0) {
            $xml .= "</xml>";
        }

        return $xml;
    }

    /**
     * 将xml转为array,不分析XML属性等数据
     *
     * @param $xml
     *
     * @return mixed
     * @throws \Exception
     */
    public function toSimpleArray($xml)
    {
        if ( ! $xml) {
            throw new \Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml,
            'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}