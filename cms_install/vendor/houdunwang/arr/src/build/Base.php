<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\arr\build;

/**
 * 数组管理
 * Class Arr
 *
 * @package hdphp\arr
 * @author  向军
 */
class Base
{
    /**
     * 返回多层栏目
     *
     * @param        $data     操作的数组
     * @param int    $pid      一级PID的值
     * @param string $html     栏目名称前缀
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     * @param int    $level    不需要传参数（执行时调用）
     *
     * @return array
     */
    public function channelLevel(
        $data,
        $pid = 0,
        $html = "&nbsp;",
        $fieldPri = 'cid',
        $fieldPid = 'pid',
        $level = 1
    ) {
        if (empty($data)) {
            return [];
        }
        $arr = [];
        foreach ($data as $v) {
            if ($v[$fieldPid] == $pid) {
                $arr[$v[$fieldPri]]           = $v;
                $arr[$v[$fieldPri]]['_level'] = $level;
                $arr[$v[$fieldPri]]['_html']  = str_repeat($html, $level - 1);
                $arr[$v[$fieldPri]]["_data"]  = $this->channelLevel(
                    $data,
                    $v[$fieldPri],
                    $html,
                    $fieldPri,
                    $fieldPid,
                    $level + 1
                );
            }
        }

        return $arr;
    }

    /**
     * 获得栏目列表
     *
     * @param        $arr      栏目数据
     * @param int    $pid      操作的栏目
     * @param string $html     栏目名前字符
     * @param string $fieldPri 表主键
     * @param string $fieldPid 父id
     * @param int    $level    等级
     *
     * @return array
     */
    public function channelList(
        $arr,
        $pid = 0,
        $html = "&nbsp;",
        $fieldPri = 'cid',
        $fieldPid = 'pid',
        $level = 1
    ) {
        $pid  = is_array($pid) ? $pid : [$pid];
        $data = [];
        foreach ($pid as $id) {
            $res = $this->_channelList(
                $arr,
                $id,
                $html,
                $fieldPri,
                $fieldPid,
                $level
            );
            foreach ($res as $k => $v) {
                $data[$k] = $v;
            }
        }
        if (empty($data)) {
            return $data;
        }
        foreach ($data as $n => $m) {
            if ($m['_level'] == 1) {
                continue;
            }
            $data[$n]['_first'] = false;
            $data[$n]['_end']   = false;
            if ( ! isset($data[$n - 1])
                || $data[$n - 1]['_level'] != $m['_level']
            ) {
                $data[$n]['_first'] = true;
            }
            if (isset($data[$n + 1])
                && $data[$n]['_level'] > $data[$n + 1]['_level']
            ) {
                $data[$n]['_end'] = true;
            }
        }
        //更新key为栏目主键
        $category = [];
        foreach ($data as $d) {
            $category[$d[$fieldPri]] = $d;
        }

        return $category;
    }

    //只供channelList方法使用
    private function _channelList(
        $data,
        $pid = 0,
        $html = "&nbsp;",
        $fieldPri = 'cid',
        $fieldPid = 'pid',
        $level = 1
    ) {
        if (empty($data)) {
            return [];
        }
        $arr = [];
        foreach ($data as $v) {
            $id = $v[$fieldPri];
            if ($v[$fieldPid] == $pid) {
                $v['_level'] = $level;
                $v['_html']  = str_repeat($html, $level - 1);
                array_push($arr, $v);
                $tmp = $this->_channelList(
                    $data,
                    $id,
                    $html,
                    $fieldPri,
                    $fieldPid,
                    $level + 1
                );
                $arr = array_merge($arr, $tmp);
            }
        }

        return $arr;
    }

    /**
     * 获得树状数据
     *
     * @param        $data     数据
     * @param        $title    字段名
     * @param string $fieldPri 主键id
     * @param string $fieldPid 父id
     *
     * @return array
     */
    public function tree($data, $title, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        if ( ! is_array($data) || empty($data)) {
            return [];
        }
        $arr = $this->channelList($data, 0, '', $fieldPri, $fieldPid);
        foreach ($arr as $k => $v) {
            $str = "";
            if ($v['_level'] > 2) {
                for ($i = 1; $i < $v['_level'] - 1; $i++) {
                    $str .= "│&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            if ($v['_level'] != 1) {
                $t = $title ? $v[$title] : '';
                if (isset($arr[$k + 1])
                    && $arr[$k + 1]['_level'] >= $arr[$k]['_level']
                ) {
                    $arr[$k]['_'.$title] = $str."├─ ".$v['_html'].$t;
                } else {
                    $arr[$k]['_'.$title] = $str."└─ ".$v['_html'].$t;
                }
            } else {
                $arr[$k]['_'.$title] = $v[$title];
            }
        }
        //设置主键为$fieldPri
        $data = [];
        foreach ($arr as $d) {
            //            $data[$d[$fieldPri]] = $d;
            $data[] = $d;
        }

        return $data;
    }

    /**
     * 获得所有父级栏目
     *
     * @param        $data     栏目数据
     * @param        $sid      子栏目
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     *
     * @return array
     */
    public function parentChannel(
        $data,
        $sid,
        $fieldPri = 'cid',
        $fieldPid = 'pid'
    ) {
        if (empty($data)) {
            return $data;
        } else {
            $arr = [];
            foreach ($data as $v) {
                if ($v[$fieldPri] == $sid) {
                    $arr[] = $v;
                    $_n    = $this->parentChannel(
                        $data,
                        $v[$fieldPid],
                        $fieldPri,
                        $fieldPid
                    );
                    if ( ! empty($_n)) {
                        $arr = array_merge($arr, $_n);
                    }
                }
            }

            return $arr;
        }
    }

    /**
     * 判断$s_cid是否是$d_cid的子栏目
     *
     * @param        $data     栏目数据
     * @param        $sid      子栏目id
     * @param        $pid      父栏目id
     * @param string $fieldPri 主键
     * @param string $fieldPid 父id字段
     *
     * @return bool
     */
    public function isChild(
        $data,
        $sid,
        $pid,
        $fieldPri = 'cid',
        $fieldPid = 'pid'
    ) {
        $_data = $this->channelList($data, $pid, '', $fieldPri, $fieldPid);
        foreach ($_data as $c) {
            //目标栏目为源栏目的子栏目
            if ($c[$fieldPri] == $sid) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检测是不否有子栏目
     *
     * @param        $data     栏目数据
     * @param        $cid      要判断的栏目cid
     * @param string $fieldPid 父id表字段名
     *
     * @return bool
     */
    public function hasChild($data, $cid, $fieldPid = 'pid')
    {
        foreach ($data as $d) {
            if ($d[$fieldPid] == $cid) {
                return true;
            }
        }

        return false;
    }

    /**
     * 递归实现迪卡尔乘积
     *
     * @param       $arr 操作的数组
     * @param array $tmp
     *
     * @return array
     */
    public function descarte($arr, $tmp = [])
    {
        $n_arr = [];
        foreach (array_shift($arr) as $v) {
            $tmp[] = $v;
            if ($arr) {
                $this->descarte($arr, $tmp);
            } else {
                $n_arr[] = $tmp;
            }
            array_pop($tmp);
        }

        return $n_arr;
    }

    /**
     * 从数组中移除给定的值
     *
     * @param array $data   原数组数据
     * @param array $values 要移除的值
     *
     * @return array
     */
    public function del(array $data, array $values)
    {
        $news = [];
        foreach ($data as $key => $d) {
            if ( ! in_array($d, $values)) {
                $news[$key] = $d;
            }
        }

        return $news;
    }

    /**
     * 根据键名获取数据
     * 如果键名不存在时返回默认值
     *
     * @param array  $data
     * @param string $key   名称
     * @param mixed  $value 默认值
     *
     * @return array|mixed|null
     */
    public function get(array $data, $key, $value = null)
    {
        $exp = explode('.', $key);
        foreach ((array)$exp as $d) {
            if (isset($data[$d])) {
                $data = $data[$d];
            } else {
                return $value;
            }
        }

        return $data;
    }

    /**
     * 排队字段获取数据
     *
     * @param array $data    数据
     * @param array $extName 排除的字段
     *
     * @return array
     */
    public static function getExtName(array $data, array $extName)
    {
        $extData = [];
        foreach ((array)$data as $k => $v) {
            if ( ! in_array($k, $extName)) {
                $extData[$k] = $v;
            }
        }

        return $extData;
    }

    /**
     * 设置数组元素值支持点语法
     *
     * @param array $data
     * @param       $key
     * @param       $value
     *
     * @return array
     */
    public function set(array $data, $key, $value)
    {
        $tmp =& $data;
        foreach (explode('.', $key) as $d) {
            if ( ! isset($tmp[$d])) {
                $tmp[$d] = [];
            }
            $tmp = &$tmp[$d];
        }
        $tmp = $value;

        return $data;
    }

    /**
     * 将数组键名变成大写或小写
     *
     * @param array $arr  数组
     * @param int   $type 转换方式 1大写   0小写
     *
     * @return array
     */
    public function keyCase($arr, $type = 0)
    {
        $func = $type ? 'strtoupper' : 'strtolower';
        $data = []; //格式化后的数组
        foreach ($arr as $k => $v) {
            $k        = $func($k);
            $data[$k] = is_array($v) ? $this->keyCase($v, $type) : $v;
        }

        return $data;
    }

    /**
     * 不区分大小写检测数据键名是否存在
     *
     * @param $key
     * @param $arr
     *
     * @return bool
     */
    public function keyExists($key, $arr)
    {
        return array_key_exists(strtolower($key), $this->keyExists($arr));
    }

    /**
     * 将数组中的值全部转为大写或小写
     *
     * @param array $arr
     * @param int   $type 类型 1值大写 0值小写
     *
     * @return array
     */
    public function valueCase($arr, $type = 0)
    {
        $func = $type ? 'strtoupper' : 'strtolower';
        $data = []; //格式化后的数组
        foreach ($arr as $k => $v) {
            $data[$k] = is_array($v) ? $this->valueCase($v, $type) : $func($v);
        }

        return $data;
    }

    /**
     * 数组进行整数映射转换
     *
     * @param       $arr
     * @param array $map
     *
     * @return mixed
     */
    public function intToString(
        $arr,
        array $map = ['status' => ['0' => '禁止', '1' => '启用']]
    ) {
        foreach ($map as $name => $m) {
            if (isset($arr[$name]) && array_key_exists($arr[$name], $m)) {
                $arr['_'.$name] = $m[$arr[$name]];
            }
        }

        return $arr;
    }

    /**
     * 数组中的字符串数字转为INT类型
     *
     * @param $data
     *
     * @return mixed
     */
    public function stringToInt($data)
    {
        $tmp = $data;
        foreach ((array)$tmp as $k => $v) {
            $tmp[$k] = is_array($v) ? $this->stringToInt($v)
                : (is_numeric($v) ? intval($v) : $v);
        }

        return $tmp;
    }

    /**
     * 根据下标过滤数据元素
     *
     * @param array $data 原数组数据
     * @param       $keys 参数的下标
     * @param int   $type 1 存在在$keys时过滤  0 不在时过滤
     *
     * @return array
     */
    public function filterKeys(array $data, $keys, $type = 1)
    {
        $tmp = $data;
        foreach ($data as $k => $v) {
            if ($type == 1) {
                //存在时过滤
                if (in_array($k, $keys)) {
                    unset($tmp[$k]);
                }
            } else {
                //不在时过滤
                if ( ! in_array($k, $keys)) {
                    unset($tmp[$k]);
                }
            }
        }

        return $tmp;
    }
}