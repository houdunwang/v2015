<?php namespace module\article\system;

/**
 * 模块模板视图自定义标签处理
 *
 * @author 向军
 * @url http://www.hdcms.com
 */
class Tag
{
    //幻灯图数据列表
    public function slide_lists($attr, $content)
    {
        $php
             = <<<str
<?php \$slideData = \Db::table('web_slide')->where('siteid',SITEID)
        ->orderBy('displayorder','DESC')->orderBy('id','desc')->get()?:[];
foreach(\$slideData as \$field){?>
str;
        $php .= $content;
        $php .= '<?php }?>';

        return $php;

    }

    //幻灯图
    public function slide($attr)
    {
        $width    = isset($attr['width']) ? $attr['width'] : 'window.innerWidth';
        $height   = isset($attr['height']) ? $attr['height'] : 300;
        $autoplay = isset($attr['autoplay']) ? $attr['autoplay'] : 3000;
        $php
                  = <<<str
        <?php \$slideData = \Db::table('web_slide')->where('siteid',SITEID)->orderBy('displayorder','DESC')->get()?:[];?>
        <?php if(!empty(\$slideData)){?>
<div class="swiper-container">
    <div class="swiper-wrapper">
    <?php foreach(\$slideData as \$_s){?>
        <div class="swiper-slide">
            <a href="<?php echo \$_s['url'];?>"><img src="<?php echo \$_s['thumb'];?>"></a>
        </div>
    <?php }?>
    </div>
    <!-- 如果需要分页器 -->
    <div class="swiper-pagination"></div>
    <!-- 如果需要导航按钮 -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<style>
    .swiper-container {
        width: {$width}px;
        height: {$height}px;
    }
    .swiper-container .swiper-slide img {
        width : 100%;
        height: {$height}px;
    }
</style>
<script>
    require(['hdjs'], function (hdjs) {
        hdjs.swiper('.swiper-container', {
            loop: true,
            //自动轮换
            autoplay: {
                delay: {$autoplay},
            },
            //如果需要分页器
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            //如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })
    })
</script>
    <?php }?>
str;

        return $php;
    }

    //栏目列表
    public function category($attr, $content)
    {
        $cid = isset($attr['cid']) ? $attr['cid'] : '';
        $pid = isset($attr['pid']) ? $attr['pid'] : -1;
        $php
             = <<<str
<?php
\$cid = array_filter(explode(',','$cid'));
\$db  =  \Db::table('web_category')->where('siteid',SITEID)->orderBy('orderby','DESC');
if($pid!=-1){
	\$db->where('pid',$pid);
}

if(\$cid){
	\$db->whereIn('cid',\$cid);
}
\$_category =\$db->get()?:[];
foreach(\$_category as \$field){
    //栏目链接
    if(empty(\$field['linkurl'])){
        \$field['url']=\module\article\model\WebCategory::url(\$field,1);
    }else{
        \$field['url']=\$field['linkurl'];
    }
    \$field['current_category']=\Request::get('cid')==\$field['cid']?'current_category':'';
?>
$content
<?php }?>
str;

        return $php;
    }

    //获取一级栏目列表即PID为0的
    public function category_top($attr, $content)
    {
        $php
            = <<<str
<?php
\$_category = \Db::table('web_category')->where('siteid',SITEID)->where('pid',0)->get();
foreach(\$_category as \$field){
    //栏目链接
    if(empty(\$field['linkurl'])){
        \$field['url']=\module\article\model\WebCategory::url(\$field,1);
    }else{
        \$field['url'] = \$field['linkurl'];
    }
    \$field['current_category']=\Request::get('cid')==\$field['cid']?'current_category':'';
?>
$content
<?php }?>
str;

        return $php;
    }

    //栏目嵌套读取
    public function category_level($attr, $content)
    {
        $php
            = <<<str
<?php
\$_son_category = \Db::table('web_category')->where('siteid',SITEID)->where('pid',\$field['cid'])->get();
foreach(\$_son_category as \$field){
    //栏目链接
    if(empty(\$field['linkurl'])){
        \$field['url']=\module\article\model\WebCategory::url(\$field,1);
    }else{
        \$field['url'] = \$field['linkurl'];
    }
?>
$content
<?php }?>
str;

        return $php;
    }

    //文章列表
    public function lists($attr, $content)
    {
        $start        = isset($attr['start']) ? intval($attr['start']) : 0;
        $row          = isset($attr['row']) ? intval($attr['row']) : 20;
        $mid          = isset($attr['mid']) ? intval($attr['mid']) : 0;
        $cid          = isset($attr['cid']) ? ($attr['cid'][0] == '$' ? $attr['cid']
            : "{$attr['cid']}") : "''";
        $sub_category = isset($attr['sub_category']) ? 1 : 0;
        $iscommend    = isset($attr['iscommend']) ? $attr['iscommend'] : 0;
        $isthumb      = isset($attr['isthumb']) ? $attr['isthumb'] : 0;
        $ishot        = isset($attr['ishot']) ? $attr['ishot'] : 0;
        $titlelen     = isset($attr['titlelen']) ? intval($attr['titlelen']) : 20;
        $order        = isset($attr['order']) ? $attr['order'] : 'DESC';
        $rand         = isset($attr['rand']) ? 1 : 0;
        $php
                      = <<<str
		<?php
		//栏目检索
		\$cid = array_filter(explode(',',$cid));
		\$mid = $mid;
		if(!\$mid && !empty(\$cid)){
			\$mid = \Db::table('web_category')->where('cid',\$cid[0])->pluck('mid');
		}
		\$model = new module\article\model\WebContent(\$mid);
		\$db = \$model->where('siteid',SITEID)->limit($start,$row);
		//包含子栏目
		if(!empty(\$cid) && $sub_category){
			\$_sub_category = array_keys(Arr::channelList(\Db::table('web_category')->get(),\$cid));
			\$cid = array_merge(\$cid,\$_sub_category);
		}
		if(!empty(\$cid)){
			\$db->whereIn('cid',\$cid);
		}
		//推荐文章
		if($iscommend){
			\$db->where('iscommend',1);
		}
		//头条文章
		if($ishot){
			\$db->where('ishot',1);
		}
		//缩略图
		if($isthumb){
			\$db->where('thumb','<>','');
		}
		//随机获取
		if($rand){
			\$db->orderBy('rand()');
		}
		//排序
		\$_result = \$db->orderBy('orderby','desc')->orderBy('aid','$order')->get();
		\$_category = new \module\article\model\WebCategory();
		foreach(\$_result as \$m){
		    \$field = \$m->toArray();
			\$field['category']= \$_category->getByCid(\$m['cid']);
			\$field['url']     = \$m->url();
			\$field['title']   = mb_substr(\$m['title'],0,$titlelen,'utf8'); 
			\$field['thumb']   = pic(\$m['thumb']);
			\$field['current_article'] = \Request::get('aid')==\$m['aid']?'current_article':'';
		?>
			$content
		<?php }?>
str;

        return $php;
    }

    //相关文章
    public function relation($attr, $content)
    {
        $row      = isset($attr['row']) ? intval($attr['row']) : 10;
        $titlelen = isset($attr['titlelen']) ? intval($attr['titlelen']) : 20;
        $php
                  = <<<str
		<?php 
		\$model = new module\article\model\WebContent();
		\$db = \$model->where('siteid',SITEID)->limit($row);
		//栏目检索
		\$db->where('cid',Request::get('cid'));
		//排序
		\$db->orderBy('rand()');
		\$_result = \$db->get();
		\$_WebCategory = new \module\article\model\WebCategory();
		\$category = \$_WebCategory->getByCid(Request::get('cid'));
		foreach(\$_result as \$m){
		    \$field = \$m->toArray();
			\$field['category'] = \$category;
			\$field['url'] = \$m->url();
			\$field['title'] = mb_substr(\$m['title'],0,$titlelen,'utf8');
		?>
			$content
		<?php }?>
str;

        return $php;
    }

    //栏目列表数据
    public function pagelist($attr, $content)
    {
        $row          = isset($attr['row']) ? $attr['row'] : 10;
        $ishot        = isset($attr['ishot']) ? $attr['ishot'] : 0;
        $iscommend    = isset($attr['iscommend']) ? $attr['iscommend'] : 0;
        $sub_category = isset($attr['sub_category']) ? 1 : 0;
        $php
                      = <<<str
        <?php
        \$cid = [Request::get('cid')];
        \$db = new module\article\model\WebContent();
        \$db->where('siteid',SITEID);
        //头条
        if($ishot){
            \$db->where('ishot',1);
        }
        if($iscommend){
            \$db->where('iscommend',1);
        }
        //当前栏目数据
        \$_category = \Db::table('web_category')->where('cid',Request::get('cid'))->where('siteid',SITEID)->first();
        //包含子栏目
		if($sub_category){
			\$_sub_category = array_keys(Arr::channelList(\Db::table('web_category')->where('siteid',SITEID)->get(),\$cid));
			\$cid = array_merge(\$cid,\$_sub_category);
		}
		\$db->whereIN('cid',\$cid)->where('mid',\$_category['mid']);
        //栏目链接用于分页
        \$_category['url']=\module\article\model\WebCategory::url(\$_category);
        //分页地址设置
        \$url = str_replace(['{siteid}','{cid}'],[siteid(),\$_category['cid']],web_url().'/article{siteid}-{cid}-{page}.html');
        houdunwang\page\Page::url(\$url);
        \$_data = \$db->paginate($row);
        foreach(\$_data as \$m){
            \$field             = \$m->toArray();
            \$field['category'] = \$_category;
            \$field['thumb']    = pic(\$field['thumb']);
            \$field['url']      = \$m->url();
        ?>
        $content
        <?php }?>
str;

        return $php;

    }

    //页码
    public function pagination()
    {
        $php
            = <<<str
        <?php echo \$db->links();?>
str;

        return $php;
    }

    //文章内容页面包屑导航
    public function breadcrumb($attr, $content)
    {
        $separator = isset($attr['separator']) ? $attr['separator'] : '';

        return <<<str
<ol class="breadcrumb">
  <li><a href="{{__ROOT__}}">首页</a>{$separator}</li>
  <?php \$_categorys = \Db::table('web_category')->where('siteid',SITEID)->get();
  \$_cid  = isset(\$hdcms['category']['cid'])?\$hdcms['category']['cid']:\$hdcms['cid']; 
  \$_categorys = array_reverse(Arr::parentChannel(\$_categorys,\$_cid)?:[]);
  foreach(\$_categorys as \$_cat){?>
	  <li>
	    <a href="{{\module\article\model\WebCategory::url(\$_cat)}}">{{\$_cat['catname']}}</a>
	    <?php if(isset(\$hdcms['category'])){echo '{$separator}';}?>
	  </li>
  <?php }?>
  <?php if(isset(\$hdcms['category'])){?>
		<li class="active">{{\$hdcms['title']}}</li>
	<?php }?>
</ol>
str;
    }

    //微站首页导航菜单
    public function navigate($attr, $content)
    {
        $position = isset($attr['position']) ? $attr['position'] : -1;
        $php
                  = <<<str
        <?php
            \$db = \Db::table('navigate')->where('siteid',SITEID)->where('status',1);
            if($position!=-1){
                \$db->where('position',$position);
            }
	        \$nav = \$db->get();
	        foreach((array)\$nav as \$field){
	            \$css = json_decode(\$field['css'],true);
	            \$field['url']=!preg_match('/^http(s)?:\//i',\$field['url'])?__ROOT__.'/'.\$field['url']:\$field['url'];
	            if(\$field['icontype']==1){
	                //字体图标
	                \$field['icon']='<i class="'.\$css['icon'].'" style="color:'.\$css['color'].';font-size:'.\$css['size'].'px;"></i>';
	            }else{
	                //图片图标
	                \$field['icon']='<img class="icon" src="'.\$css['image'].'"/>';
	            }
	        ?>
	        $content
        <?php }?>
str;

        return $php;
    }

    //底部快捷导航
    public function quickmenu($attr)
    {
        $php
            = <<<str
	<link rel="stylesheet" href="/resource/css/quickmenu.css">
	<script src="/resource/js/quickmenu.js"></script>
    <style>
        .quickmenu {
            position: fixed;
        }
        .quickmenu .normal dl dd {
            display: none;
        }
    </style>
        <?php
            \$res = \Db::table('page')->where('siteid',SITEID)->where('type','quickmenu')->first();
            if(\$res){
                \$params = json_decode(\$res['params'],true);
                if(empty(\$params['modules'])){
					echo '<div style="height:60px;"></div>'.\$res['html'];
                }else{
	                foreach(\$params['modules'] as \$v){
	                    if(\$v['mid']==v('module.mid')){
	                        echo '<div style="height:60px;"></div>'.\$res['html'];
	                        break;
	                    }
	                }
                }
            }
        ?>
str;

        return $php;
    }
}