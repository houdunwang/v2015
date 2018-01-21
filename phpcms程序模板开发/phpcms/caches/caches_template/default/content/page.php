<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header_page"); ?>
<div id="content">
	<div class="col-left left-nav">
    	<h1>关于我们</h1>
    	<ul class="content">
        	<?php $n=1;if(is_array($arrchild_arr)) foreach($arrchild_arr AS $cid) { ?>
                <li<?php if($catid==$cid) { ?> class="cur"<?php } ?>><a href="<?php echo $CATEGORYS[$cid]['url'];?>"><?php echo $CATEGORYS[$cid]['catname'];?></a></li>
			<?php $n++;}unset($n); ?>
        </ul>
        <div class="bottom"></div>
    </div>
  <div class="col-auto">
    	<img src="<?php echo IMG_PATH;?>v9/about_ad.png" width="659" height="171" />
    	<h1 class="title"><?php echo $title;?></h1>
        <div class="content">
        	    <?php echo $content;?>
        </div>
    </div>
 </div>
<?php include template("content","footer"); ?>