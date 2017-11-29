<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<!--main-->
<div class="main">
	<div class="col-left channel-hot">
    	<div class="news-hot">
        <div class="icon"></div>
        	<div class="content">
        	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=9cc8143373160736448f93ef35975255&action=position&posid=10&catid=%24catid&thumb=1&order=listorder+DESC&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'10','catid'=>$catid,'thumb'=>'1','order'=>'listorder DESC','limit'=>'2',));}?>
				<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
				  <h4 class="blue"><a href="<?php echo $v['url'];?>" target="_blank"<?php echo title_style($v[style]);?>><?php echo $v['title'];?></a></h4>
                <p><img src="<?php echo thumb($v[thumb],90,60);?>" width="90" height="60" /><?php echo str_cut(strip_tags($v[description]), 150);?></p>
                <div class="bk20 hr"><hr /></div>
				<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=cf4d69a003c7d8604b7b05334febf5ad&action=lists&catid=%24catid&order=id+DESC&num=3\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'order'=>'id DESC','limit'=>'3',));}?>
                <ul class="list">
                <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
                	<li>·<a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" target="_blank"<?php echo title_style($v[style]);?>><?php echo str_cut($v[title], 60);?></a></li>
                <?php $n++;}unset($n); ?>
                </ul>
             <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>
        </div>
    </div>
    
    
    <div class="col-auto channel-slide">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=dee3debc27b25c1ee15983a3df2004b3&action=lists&catid=%24catid&order=listorder+ASC&thumb=1&num=5\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'order'=>'listorder ASC','thumb'=>'1','limit'=>'5',));}?>
  		<ul class="thumb">
  		<?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
        	<li <?php if($n==1) { ?>class="on" style="margin:0"<?php } ?>><a href="<?php echo $v['url'];?>"><img src="<?php echo thumb($v[thumb], 82, 50);?>"  alt="<?php echo $v['title'];?>" width="82" height="50" /><div class="icon"></div></a></li>
        <?php $n++;}unset($n); ?>
        </ul>
        <div class="col-auto">
            <ul class="photo">
            <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
                <li><a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>"><img src="<?php echo thumb($v[thumb], 398, 234);?>" width="398" height="234" alt="<?php echo $v['title'];?>" /></a></li>
            <?php $n++;}unset($n); ?>
            </ul>
            <div class="title">
            <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
              <p  <?php if($n==1) { ?>style="display:block"<?php } ?>><strong><a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" class="blue"<?php echo title_style($v[style]);?>><?php echo str_cut($v[title], 36);?></a></strong><br /><?php echo str_cut(strip_tags($v[description]), 62);?></p>
            <?php $n++;}unset($n); ?>
          </div>
        </div>
         <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>
 <!--下面这部分代码是广告代码，可通过删除注释的方法显示出来-->
 <!-- 
    <div class="ads">
    	<div class="col-left"><script language="javascript" src="<?php echo APP_PATH;?>caches/poster_js/4.js"></script></div>
        <div class="col-auto">
        	<div class="left">推广链接</div>
            <div class="right">这里放广告</div>
        </div>
  </div>
  -->
  <div class="bk10"></div>
	<div class="col-left">
	<?php $j=1;?>
	<?php $n=1;if(is_array(subcat($catid))) foreach(subcat($catid) AS $v) { ?>
	<?php if($v['type']!=0) continue;?>
        <div class="box cat-area" <?php if($j%2==1) { ?>style="margin-right:10px"<?php } ?>>
        		<h5 class="title-1"><?php echo $v['catname'];?><a href="<?php echo $v['url'];?>" class="more">更多>></a></h5>
             <div class="content">
             	
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b4f9f2b3c9f4f021c945647df37556d4&action=lists&catid=%24v%5Bcatid%5D&thumb=1&num=1&order=id+DESC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$v[catid],'thumb'=>'1','order'=>'id DESC','limit'=>'1',));}?>
				<p>
					<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
						<a href="<?php echo $v['url'];?>" target="_blank"><img src="<?php echo thumb($v[thumb],70,60);?>" width="70" height="60"/></a>
						<strong><a href="<?php echo $v['url'];?>" target="_blank" title="<?php echo $v['title'];?>"<?php echo title_style($v[style]);?>><?php echo str_cut($v[title], 30);?></a></strong><br /><?php echo str_cut($v[description],116,'..');?>
					<?php $n++;}unset($n); ?>
					</p>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                
                <div class="bk15 hr"></div>
                <ul class="list  lh24 f14">
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=5d107604b68e61f01796643989da0a78&action=lists&catid=%24v%5Bcatid%5D&num=5&order=id+DESC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$v[catid],'order'=>'id DESC','limit'=>'5',));}?>
					<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
						<li><a href="<?php echo $v['url'];?>" target="_blank"<?php echo title_style($v[style]);?>><?php echo $v['title'];?></a></li>
					<?php $n++;}unset($n); ?>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </ul>
            </div>
        </div>
        <?php if($j%2==0) { ?><div class="bk10"></div><?php } ?>
	<?php $j++; ?>
	<?php $n++;}unset($n); ?>
  </div>
    <div class="col-auto">
        <div class="box">
            <h5 class="title-2">频道总排行</h5>
            <ul class="content digg">
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=0ad40a45ad075d8f47798a231e25aec2&action=hits&catid=%24catid&num=10&order=views+DESC&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>$catid,'order'=>'views DESC',)).'0ad40a45ad075d8f47798a231e25aec2');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>$catid,'order'=>'views DESC','limit'=>'10',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
				<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
					<li><a href="<?php echo $v['url'];?>" target="_blank"<?php echo title_style($v[style]);?>><?php echo $v['title'];?></a></li>
				<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
        </div>
        <div class="bk10"></div>
        <div class="box">
            <h5 class="title-2">频道本月排行</h5>
            <ul class="content rank">
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=2caa10e576ba663010144233732308cd&action=hits&catid=%24catid&num=8&order=monthviews+DESC&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>$catid,'order'=>'monthviews DESC',)).'2caa10e576ba663010144233732308cd');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>$catid,'order'=>'monthviews DESC','limit'=>'8',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
				<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
				<li><span><?php echo number_format($v[monthviews]);?></span><a href="<?php echo $v['url'];?>"<?php echo title_style($v[style]);?> class="title" title="<?php echo $v['title'];?>"><?php echo str_cut($v[title],56,'...');?></a></li>
				<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
function ChannelSlide(Name,Class){
	$(Name+' ul.photo li').sGallery({
		titleObj:Name+' div.title p',
		thumbObj:Name+' .thumb li',
		thumbNowClass:Class
	});
}
new ChannelSlide(".channel-slide","on",311,260);
</script>
<?php include template("content","footer"); ?>