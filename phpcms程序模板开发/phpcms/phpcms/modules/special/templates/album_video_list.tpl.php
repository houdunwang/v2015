<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?m=special&c=album&a=import" method="post">
    <table width="100%" cellspacing="0" class="table-list nHover">
        <thead>
            <tr>
			<th width="33%">&nbsp;</th><th width="33%">&nbsp;</th><th width="33%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
 <?php 
if(is_array($infos)){
	$n = 0;
	foreach($infos as $info){
		$n++;
?>   
	<?php if($n%3==1){?><tr><?php }?>
	<td><div class="col-left mr10" style="width:146px; height:112px"><img src="<?php echo format_url($info['video']['picPath'])?>" width="146" height="112" style="border:1px solid #eee" align="left" title="<?php echo $info['video']['title'];?>"></div>
	<div class="col-auto">  
		<h2 class="title-1 f14 lh28 mb6 blue" title="<?php echo $info['video']['title'];?>"><?php echo str_cut($info['video']['title'], 26)?></h2>
		<div class="lh22"><?php echo $info['video']['desc']?></div>
	<p class="gray4">上传时间：<?php echo format::date(substr(trim($info['video']['uploadTime']), 0, 10), 1)?></p>
	<p class="gray4">播放次数：<?php echo $info['video']['videoTime']?></p>
	</div>
	</td>
	<?php if($n%3==0){?></tr><?php }?>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"></div>
 <div id="pages"><?php echo $pages;?></div><script>window.top.$("#display_center_id").css("display","none");</script>
</form>
</div>
</body>
</html>