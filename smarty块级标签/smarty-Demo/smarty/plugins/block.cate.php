<?php
function smarty_block_cate($params, $content, &$smarty)
{
    // 获得传入配置参数
    $row=$params['row'];

    // var_dump($content);
    // 获取数据
    $sql="SELECT * FROM category LIMIT {$row}";
    $data=query($sql);

    $str='';
    foreach($data as $k=>$v){
        // <li><a href="">[$hd.cname]</a></li>
        // <li><a href="">军事</a></li>
        // var_dump($v);
        $c=$content;
        foreach($v as $key=>$value){
            $c=str_replace("[\$hd.$key]", $value, $c);
        }
        $str.=$c;
    }
    return $str;
}


?>
