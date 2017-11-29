<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!-- 固定定位，返回顶部按钮 -->
<div id='rtt'><p></p>返回顶部</div>
<!-- 固定定位，返回顶部按钮 -->

<!-- 头部开始 -->
<div class="headtop">
    <div class="header">
        <div class="left">
            <a href="<?php echo WEB_PATH;?>"></a>
        </div>
        <div class="right">
            <ul class="menu">
                <li><a href="<?php echo WEB_PATH;?>" class="current" class="topa">首页</a></li>
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=45c5e65c9b20d90731b3602dea5e4788&action=category&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('limit'=>'2',));}?>
                <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
                <li>
                    <a href="<?php echo $v['url'];?>" class="topa"><?php echo $v['catname'];?></a>
                    <ul>
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b6ff8b8d056396725454a0ce8778c01b&action=category&catid=%24v%5B%27catid%27%5D\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>$v['catid'],'limit'=>'20',));}?>
                        <?php $n=1;if(is_array($data)) foreach($data AS $vv) { ?>
                        <li><a href="<?php echo $vv['url'];?>"><?php echo $vv['catname'];?></a></li>
                        <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ul>
                </li>
                <?php $n++;}unset($n); ?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                <!--<li>-->
                <!--<a href=""   class="topa">校园活动</a>-->
                <!--</li>-->
                <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=c61751fe4fffc033daaaa6a0cdbb215f&action=category&catid=16\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">修改</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'16','limit'=>'20',));}?>
                <?php $n=1; if(is_array($data)) foreach($data AS $k => $v) { ?>
                <li><a href="<?php echo $v['url'];?>" class="topa"><?php echo $v['catname'];?></a></li>
                <?php $n++;}unset($n); ?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                <li><a href="http://www.houdunwang.com" target="_blank" class="topa">实战培训</a></li>
                <li><a href="http://www.houdunren.com" target="_blank" class="topa">在线视频</a></li>
                <li><a href="http://bbs.houdunwang.com/portal.php" target="_blank" class="topa">论坛讨论</a></li>
            </ul>
        </div>
    </div>
</div>