<?php
define('InEmpireCMSIconv',TRUE);

class Chinese
{
	//存放简体中文与拼音对照表
    var $pinyin_table = array();

	//存放 GB <-> UNICODE 对照表的内容
    var $unicode_table = array();

	//访问中文繁简互换表的文件指针
    var $ctf;

    var $SourceText = "";

	//配置
    var $config  =  array(
        'codetable_dir'         => '',                      //  存放各种语言互换表的目录
        'source_lang'           => '',                      //  字符的原编码
        'target_lang'           => '',                      //  转换后的编码
        'GBtoBIG5_table'        => 'gb-big5.table',         //  简体中文转换为繁体中文的对照表
        'BIG5toGB_table'        => 'big5-gb.table',         //  繁体中文转换为简体中文的对照表
        'GBtoPinYin_table'      => 'gb-pinyin.table',       //  简体中文转换为拼音的对照表
        'GBtoUnicode_table'     => 'gb-unicode.table',      //  简体中文转换为UNICODE的对照表
        'BIG5toUnicode_table'   => 'big5-unicode.table'     //  繁体中文转换为UNICODE的对照表
    );

    function Chinese($dir='./')
    {
        $this->config['codetable_dir'] = $dir."../data/codetable/";
    }

    function Convert( $source_lang , $target_lang , $source_string='' )
    {
        /* 如果编码相同，直接返回 */
        if ($source_lang == $target_lang || $source_string == '')
        {
            return $source_string;
        }
        
        if ($source_lang != '') {
            $this->config['source_lang'] = $source_lang;
        }

        if ($target_lang != '') {
            $this->config['target_lang'] = $target_lang;
        }

		
        $this->SourceText = $source_string;
        
        $this->OpenTable();
        // 判断是否为中文繁、简转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && ($this->config['target_lang']=="GB2312" || $this->config['target_lang']=="BIG5") ) {
            return $this->GB2312toBIG5();
        }

        // 判断是否为简体中文与拼音转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && $this->config['target_lang']=="PinYin" ) {
            return $this->CHStoPinYin();
        }

        // 判断是否为简体、繁体中文与UTF8转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5" || $this->config['source_lang']=="UTF8") && ($this->config['target_lang']=="UTF8" || $this->config['target_lang']=="GB2312" || $this->config['target_lang']=="BIG5") ) {
            return $this->CHStoUTF8();
        }

        // 判断是否为简体、繁体中文与UNICODE转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && $this->config['target_lang']=="UNICODE" ) {
            return $this->CHStoUNICODE();
        }
    }

	//将 16 进制转换为 2 进制字符
    function _hex2bin( $hexdata )
    {
        $bindata = '';
        for ($i = 0; $i < strlen($hexdata); $i += 2 )
        {
        	$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

    function OpenTable()
    {

        // 假如原编码为简体中文的话
        if ($this->config['source_lang']=="GB2312") {

            // 假如转换目标编码为繁体中文的话
            if ($this->config['target_lang'] == "BIG5") {
                $this->ctf = fopen($this->config['codetable_dir'].$this->config['GBtoBIG5_table'], "rb");
                if (is_null($this->ctf)) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
            }

            // 假如转换目标编码为拼音的话
            if ($this->config['target_lang'] == "PinYin") {
                $tmp = @file($this->config['codetable_dir'].$this->config['GBtoPinYin_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                //
                $i = 0;
                for ($i=0; $i<count($tmp); $i++) {
                    $tmp1 = explode("	", $tmp[$i]);
                    $this->pinyin_table[$i]=array($tmp1[0],$tmp1[1]);
                }
            }

            // 假如转换目标编码为 UTF8 的话
            if ($this->config['target_lang'] == "UTF8") {
                $tmp = @file($this->config['codetable_dir'].$this->config['GBtoUnicode_table']);
                if (!$tmp) {
                    echo "编码转换失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                $this->unicode_table[hexdec(substr($value,0,6))]=substr($value,7,6);
            }

            // 假如转换目标编码为 UNICODE 的话
            if ($this->config['target_lang'] == "UNICODE") {
                $tmp = @file($this->config['codetable_dir'].$this->config['GBtoUnicode_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                $this->unicode_table[hexdec(substr($value,0,6))]=substr($value,9,4);
            }
        }

        // 假如原编码为繁体中文的话
        if ($this->config['source_lang']=="BIG5") {
            // 假如转换目标编码为简体中文的话
            if ($this->config['target_lang'] == "GB2312") {
                $this->ctf = fopen($this->config['codetable_dir'].$this->config['BIG5toGB_table'], "r");
                if (is_null($this->ctf)) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
            }
            // 假如转换目标编码为 UTF8 的话
            if ($this->config['target_lang'] == "UTF8") {
                $tmp = @file($this->config['codetable_dir'].$this->config['BIG5toUnicode_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                $this->unicode_table[hexdec(substr($value,0,6))]=substr($value,7,6);
            }

            // 假如转换目标编码为 UNICODE 的话
            if ($this->config['target_lang'] == "UNICODE") {
                $tmp = @file($this->config['codetable_dir'].$this->config['BIG5toUnicode_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                $this->unicode_table[hexdec(substr($value,0,6))]=substr($value,9,4);
            }

            // 假如转换目标编码为拼音的话
            if ($this->config['target_lang'] == "PinYin") {
                $tmp = @file($this->config['codetable_dir'].$this->config['GBtoPinYin_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                //
                $i = 0;
                for ($i=0; $i<count($tmp); $i++) {
                    $tmp1 = explode("	", $tmp[$i]);
                    $this->pinyin_table[$i]=array($tmp1[0],$tmp1[1]);
                }
            }
        }

        // 假如原编码为 UTF8 的话
        if ($this->config['source_lang']=="UTF8") {

            // 假如转换目标编码为 GB2312 的话
            if ($this->config['target_lang'] == "GB2312") {
                $tmp = @file($this->config['codetable_dir'].$this->config['GBtoUnicode_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                {
                	$this->unicode_table[hexdec(substr($value,7,6))]=substr($value,0,6);
                }
            }

            // 假如转换目标编码为 BIG5 的话
            if ($this->config['target_lang'] == "BIG5") {
                $tmp = @file($this->config['codetable_dir'].$this->config['BIG5toUnicode_table']);
                if (!$tmp) {
                    echo "打开打开转换表文件失败！";
                    exit;
                }
                $this->unicode_table = array();
                while(list($key,$value)=each($tmp))
                {
                	$this->unicode_table[hexdec(substr($value,7,6))]=substr($value,0,6);
                }
            }
        }

    }

    function OpenFile( $position , $isHTML=false )
    {
        $tempcontent = @file($position);

        if (!$tempcontent) {
            echo "打开文件失败！";
            exit;
        }

        $this->SourceText = implode("",$tempcontent);

        if ($isHTML) {
            $this->SourceText = preg_replace( "/charset=".$this->config['source_lang']."/i" , "charset=".$this->config['target_lang'] , $this->SourceText);

            $this->SourceText = str_replace("\n", "", $this->SourceText);

            $this->SourceText = str_replace("\r", "", $this->SourceText);
        }
    }

    function SiteOpen( $position )
    {
        $tempcontent = @file($position);

        if (!$tempcontent) {
            echo "打开文件失败！";
            exit;
        }

        // 将数组的所有内容转换为字符串
        $this->SourceText = implode("",$tempcontent);

        $this->SourceText = preg_replace( "/charset=".$this->config['source_lang']."/i" , "charset=".$this->config['target_lang'] , $this->SourceText);

    }

    function setvar( $parameter , $value )
    {
        if(!trim($parameter))
        return $parameter;

        $this->config[$parameter] = $value;

    }

    function CHSUtoUTF8($c)
    {
        $str="";

        if ($c < 0x80) {
            $str.=$c;
        }

        elseif ($c < 0x800) {
            $str.=(0xC0 | $c>>6);
            $str.=(0x80 | $c & 0x3F);
        }

        elseif ($c < 0x10000) {
            $str.=(0xE0 | $c>>12);
            $str.=(0x80 | $c>>6 & 0x3F);
            $str.=(0x80 | $c & 0x3F);
        }

        elseif ($c < 0x200000) {
            $str.=(0xF0 | $c>>18);
            $str.=(0x80 | $c>>12 & 0x3F);
            $str.=(0x80 | $c>>6 & 0x3F);
            $str.=(0x80 | $c & 0x3F);
        }

        return $str;
    }

    function CHStoUTF8(){

        if ($this->config["source_lang"]=="BIG5" || $this->config["source_lang"]=="GB2312") {
            $ret="";

            while($this->SourceText){

                if(ord(substr($this->SourceText,0,1))>127){

                    if ($this->config["source_lang"]=="BIG5") {
                        $utf8=$this->CHSUtoUTF8(hexdec($this->unicode_table[hexdec(bin2hex(substr($this->SourceText,0,2)))]));
                    }
                    if ($this->config["source_lang"]=="GB2312") {
                        $utf8=$this->CHSUtoUTF8(hexdec($this->unicode_table[hexdec(bin2hex(substr($this->SourceText,0,2)))-0x8080]));
                    }
                    for($i=0;$i<strlen($utf8);$i+=3)
                    $ret.=chr(substr($utf8,$i,3));

                    $this->SourceText=substr($this->SourceText,2,strlen($this->SourceText));
                }

                else{
                    $ret.=substr($this->SourceText,0,1);
                    $this->SourceText=substr($this->SourceText,1,strlen($this->SourceText));
                }
            }
            $this->unicode_table = array();
            $this->SourceText = "";
            return $ret;
        }

        if ($this->config["source_lang"]=="UTF8") {
            $out = '';
            $len = strlen($this->SourceText);
            $i = 0;
            while($i < $len) {
                $c = ord( substr( $this->SourceText, $i++, 1 ) );
                switch($c >> 4)
                {
                    case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
                        // 0xxxxxxx
                        $out .= substr( $this->SourceText, $i - 1, 1 );
                        break;
                    case 12: case 13:
                        // 110x xxxx   10xx xxxx
                        $char2 = ord( substr( $this->SourceText, $i++, 1 ) );
                        $char3 = $this->unicode_table[(($c & 0x1F) << 6) | ($char2 & 0x3F)];

                        if ($this->config["target_lang"]=="GB2312")
                        {
                        	$out .= $this->_hex2bin( dechex(  $char3 + 0x8080 ) );
                        } elseif ($this->config["target_lang"]=="BIG5")
                        {
                        	$out .= $this->_hex2bin( dechex ( $char3 + 0x0000 ) );
                        }
                        break;
                    case 14:
                        // 1110 xxxx  10xx xxxx  10xx xxxx
                        $char2 = ord( substr( $this->SourceText, $i++, 1 ) );
                        $char3 = ord( substr( $this->SourceText, $i++, 1 ) );
                        $char4 = $this->unicode_table[(($c & 0x0F) << 12) | (($char2 & 0x3F) << 6) | (($char3 & 0x3F) << 0)];

                        if ($this->config["target_lang"]=="GB2312")
                        {
                        	$out .= $this->_hex2bin( dechex ( $char4 + 0x8080 ) );
                        } elseif ($this->config["target_lang"]=="BIG5")
                        {
                        	$out .= $this->_hex2bin( dechex ( $char4 + 0x0000 ) );
                        }
                        break;
                }
            }

            // 返回结果
            return $out;
        }
    }

    function CHStoUNICODE()
    {

        $utf="";

        while($this->SourceText)
        {
            if (ord(substr($this->SourceText,0,1))>127)
            {

                if ($this->config["source_lang"]=="GB2312")
                $utf.="&#x".$this->unicode_table[hexdec(bin2hex(substr($this->SourceText,0,2)))-0x8080].";";

                if ($this->config["source_lang"]=="BIG5")
                $utf.="&#x".$this->unicode_table[hexdec(bin2hex(substr($this->SourceText,0,2)))].";";

                $this->SourceText=substr($this->SourceText,2,strlen($this->SourceText));
            }
            else
            {
                $utf.=substr($this->SourceText,0,1);
                $this->SourceText=substr($this->SourceText,1,strlen($this->SourceText));
            }
        }
        return $utf;
    }

    function GB2312toBIG5()
    {
        // 获取等待转换的字符串的总长度
        $max=strlen($this->SourceText)-1;

        for($i=0;$i<$max;$i++){

            $h=ord($this->SourceText[$i]);

            if($h>=160){

                $l=ord($this->SourceText[$i+1]);

                if($h==161 && $l==64){
                    $gb="  ";
                }
                else{
                    fseek($this->ctf,($h-160)*510+($l-1)*2);
                    $gb=fread($this->ctf,2);
                }

                $this->SourceText[$i]=$gb[0];
                $this->SourceText[$i+1]=$gb[1];
                $i++;
            }
        }
        fclose($this->ctf);

        // 将转换后的结果赋予 $result;
        $result = $this->SourceText;

        // 清空 $thisSourceText
        $this->SourceText = "";

        // 返回转换结果
        return $result;
    }

    function PinYinSearch($num){

        if($num>0&&$num<160){
            return chr($num);
        }

        elseif($num<-20319||$num>-10247){
            return "";
        }

        else{

            for($i=count($this->pinyin_table)-1;$i>=0;$i--){
                if($this->pinyin_table[$i][1]<=$num)
                break;
            }

            return $this->pinyin_table[$i][0];
        }
    }

    function CHStoPinYin(){
        if ( $this->config['source_lang']=="BIG5" ) {
            $this->ctf = fopen($this->config['codetable_dir'].$this->config['BIG5toGB_table'], "r");
            if (is_null($this->ctf)) {
                echo "打开打开转换表文件失败！";
                exit;
            }

            $this->SourceText = $this->GB2312toBIG5();
            $this->config['target_lang'] = "PinYin";
        }

        $ret = array();
        $ri = 0;
        for($i=0;$i<strlen($this->SourceText);$i++){

            $p=ord(substr($this->SourceText,$i,1));

            if($p>160){
                $q=ord(substr($this->SourceText,++$i,1));
                $p=$p*256+$q-65536;
            }

            $ret[$ri]=$this->PinYinSearch($p);
            $ri = $ri + 1;
        }

        // 清空 $this->SourceText
        $this->SourceText = "";

        $this->pinyin_table = array();

        // 返回转换后的结果
        return implode(" ", $ret);
    }

    function ConvertIT()
    {
        // 判断是否为中文繁、简转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && ($this->config['target_lang']=="GB2312" || $this->config['target_lang']=="BIG5") ) {
            return $this->GB2312toBIG5();
        }

        // 判断是否为简体中文与拼音转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && $this->config['target_lang']=="PinYin" ) {
            return $this->CHStoPinYin();
        }

        // 判断是否为简体、繁体中文与UTF8转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5" || $this->config['source_lang']=="UTF8") && ($this->config['target_lang']=="UTF8" || $this->config['target_lang']=="GB2312" || $this->config['target_lang']=="BIG5") ) {
            return $this->CHStoUTF8();
        }

        // 判断是否为简体、繁体中文与UNICODE转换
        if ( ($this->config['source_lang']=="GB2312" || $this->config['source_lang']=="BIG5") && $this->config['target_lang']=="UNICODE" ) {
            return $this->CHStoUNICODE();
        }

    }

}
?>