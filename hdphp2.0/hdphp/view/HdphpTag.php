<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\view;

class HdphpTag extends TagBase {
    //blade模板(父级)
    private $blade = [ ];
    //blockshow模板(父级)
    private static $widget = [ ];

    /**
     * block 块标签
     * level 嵌套层次
     */
    public $tags
        = [
            'foreach'   => [ 'block' => TRUE, 'level' => 5 ],
            'list'      => [ 'block' => TRUE, 'level' => 5 ],
            'if'        => [ 'block' => TRUE, 'level' => 5 ],
            'elseif'    => [ 'block' => FALSE ],
            'else'      => [ 'block' => FALSE ],
            'jquery'    => [ 'block' => FALSE ],
            'angular'   => [ 'block' => FALSE ],
            'bootstrap' => [ 'block' => FALSE ],
            'js'        => [ 'block' => FALSE ],
            'css'       => [ 'block' => FALSE ],
            'include'   => [ 'block' => FALSE ],
            'extend'    => [ 'block' => FALSE ],
            'blade'     => [ 'block' => FALSE ],
            'parent'    => [ 'block' => FALSE ],
            'block'     => [ 'block' => TRUE, 'level' => 5 ],
            'widget'    => [ 'block' => TRUE, 'level' => 5 ],
            'php'       => [ 'block' => TRUE, 'level' => 5 ],
            'hdjs'      => [ 'block' => FALSE ],
        ];

    public function _hdjs( $attr, $content, &$view ) {
        return '<link href="resource/hdjs/css/bootstrap.min.css" rel="stylesheet">
                <link href="resource/hdjs/css/font-awesome.min.css" rel="stylesheet">
                <script src="resource/hdjs/js/jquery.min.js"></script>
                <script src="resource/hdjs/js/bootstrap.min.js"></script>
                <script src="resource/hdjs/app/util.js"></script>
                <script src="resource/hdjs/require.js"></script>
                <script src="resource/hdjs/app/config.js"></script>';
    }

    //jquery前端库
    public function _jquery( $attr, $content, &$view ) {
        return '<script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>';
    }

    //angular.js前端库
    public function _angular( $attr, $content, &$view ) {
        return '<script src="http://cdn.bootcss.com/angular.js/1.4.0-rc.2/angular.min.js"></script>';
    }

    //bootstrap前端库
    public function _bootstrap( $attr, $content, &$view ) {
        return '
            <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
            <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet">
            <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        ';
    }

    //引入CSS文件
    public function _css( $attr, $content, &$view ) {
        return "<link type=\"text/css\" rel=\"stylesheet\" href=\"{$attr['file']}\"/>";
    }

    //引入JavaScript文件
    public function _js( $attr, $content, &$hd ) {
        return "<script type=\"text/javascript\" src=\"{$attr['file']}\"></script>";
    }

    //list标签
    public function _list( $attr, $content, &$view ) {
        $from  = $attr['from']; //变量
        $name  = $attr['name'];//name名去除$
        $empty = isset( $attr['empty'] ) ? $attr['empty'] : '';//默认值
        $row   = isset( $attr['row'] ) ? $attr['row'] : 100;//显示条数
        $step  = isset( $attr['step'] ) ? $attr['step'] : 1;//间隔
        $start = isset( $attr['start'] ) ? $attr['start'] : 0;//开始数
        $php
               = <<<php
        <?php
        if (empty($from)) 
        {
            echo '$empty';
        } 
        else 
        {
            //初始化
            \$first=\$last=\$total=\$index=\$id=0;
            \$hd['list']['$name']['first']=&\$first;
            \$hd['list']['$name']['last']=&\$last;
            \$hd['list']['$name']['total']=&\$total;
            \$hd['list']['$name']['index']=&\$index;
            foreach ($from as \$$name) 
            {
                //开始值
                if (\$id<$start)
                {
                    \$id++;
                    continue;
                }
                //步长
                if(\$id%$step!=0)
                {   
                    \$id++;
                    continue;
                }
                //显示条数
                if(\$index>=$row)
                {
                    break;
                }
                //第几个值
                \$index+=1;
                //第1个值
                \$first=(\$id == $start);
                //最后一个值
                \$last=(\$index == $row);
                //增加数
                \$id+=1;
            ?>
php;
        $php .= $content;
        $php
            .= "<?php }
            //总数
            \$total=\$index;
        }?>";

        return $php;
    }

    //标签处理
    public function _foreach( $attr, $content ) {
        if ( isset( $attr['key'] ) ) {
            $php = "<?php foreach ((array){$attr['from']} as {$attr['key']}=>{$attr['value']}){?>";
        } else {
            $php = "<?php foreach ((array){$attr['from']} as {$attr['value']}){?>";
        }
        $php .= $content;
        $php .= '<?php }?>';

        return $php;
    }

    //加载模板文件
    public function _include( $attr, $content, &$view ) {
        $obj = new View;

        return $obj->fetch( $this->replaceConst( $attr['file'] ), 0, FALSE );
    }

    //if标签
    public function _if( $attr, $content, &$hd ) {
        $php
            = "<?php if({$attr['value']}){?>
                $content
               <?php }?>";

        return $php;
    }

    //elseif标签
    public function _elseif( $attr, $content, &$view ) {
        return "<?php }else if({$attr['value']}){?>";
    }

    //else标签
    public function _else( $attr, $content, &$view ) {
        return "<?php }else{?>";
    }

    //php标签
    public function _php( $attr, $content, &$view ) {
        return "<?php $content;?>";
    }

    //块布局时引入布局页的bladeshow块
    public function _extend( $attr, $content, &$view ) {
        //开启blade模板功能
        if ( c( 'view.blade' ) ) {
            $obj = new View;

            return $obj->fetch($this->replaceConst($attr['file'] )) ;
        }
    }

    //布局模板定义的块(父级)
    public function _blade( $attr, $content, &$view ) {
        return "<!--blade_{$attr['name']}-->";
    }

    //视图模板定义的内容(子级)
    public function _block( $attr, $content, &$view ) {
        if ( c( 'view.blade' ) ) {
            $this->content = str_replace( "<!--blade_{$attr['name']}-->", $content, $this->content );
        } else {
            return $content;
        }

    }

    //布局模板定义用于显示在视图模板的内容(父级)
    public function _widget( $attr, $content, &$view ) {
        if ( c( 'view.blade' ) ) {
            self::$widget[ $attr['name'] ] = $content;
        }
    }

    //视图模板引用布局模板(子级)
    public function _parent( $attr, $content, &$view ) {
        if ( c( 'view.blade' ) ) {
            $content = self::$widget[ $attr['name'] ];
            foreach ( $attr as $k => $v ) {
                $content = str_replace( '{{' . $k . '}}', $v, $content );
            }

            return $content;
        }
    }

}