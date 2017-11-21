<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div id="searchid" >
<form name="searchform" action="" method="get" >
<input type="hidden" value="special" name="m">
<input type="hidden" value="album" name="c">
<input type="hidden" value="import" name="a">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<input type="hidden" value="<?php echo $_GET['pc_hash'];?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 
				添加时间：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<?php echo form::select($ku6channels, $_GET['categoryid'], 'name="categoryid" id="categoryid"', '请选择频道')?>			
				标题：
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword'];?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<div class="pad-lr-10">
<form name="myform" action="?m=special&c=album&a=import&page=<?php echo $_GET['page'];?>" method="post">
    <table width="100%" cellspacing="0" class="table-list nHover">
        <thead>
            <tr>
            <th width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="40" align="center">ID</th>
			<th >专辑信息</th>
			<th width="160"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
        <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td align="center" width="40"><input class="inputcheckbox" <?php if (!empty($imported) && in_array($info['id'], $imported)){?>disabled<?php }?> name="id[]" value="<?php echo $info['id'];?>" type="checkbox"></td>
	<td width="40" align="center"><?php echo $info['id']?></td>
	<td><div class="col-left mr10" style="width:146px; height:112px"><img src="<?php echo format_url($info['coverurl'])?>" width="146" height="112" style="border:1px solid #eee" align="left"></div>
	<div class="col-auto">  
		<h2 class="title-1 f14 lh28 mb6 blue"><?php echo $info['title']?></h2>
		<div class="lh22"><?php echo $info['desc']?></div>
	<p class="gray4"><?php echo L('create_time')?>：<?php echo format::date(substr(trim($info['createtime']), 0, 10), 1)?></p>
	<p class="gray4">播放次数：<?php echo $info['videocount']?></p>
	</div>
	</td>
	<td align="center"><span style="height:22"><?php if (!empty($imported) && in_array($info['id'], $imported)){?><font color="red">专辑已载入<?php } else {?><a href='?m=special&c=album&a=import&id=<?php echo $info['id']?>&page=<?php echo $_GET['page'];?>&pc_hash=<?php echo $_GET['pc_hash'];?>'>载入此专辑</a><?php }?></span><br /><span style="height:22"><a href="?m=special&c=album&a=content_list&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>&pc_hash=<?php echo $_GET['pc_hash'];?>">查看专辑下的视频</a></span></td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
        <input name='dosubmit' type='submit' class="button" value='载入'>&nbsp;
       </div>
 <div id="pages"><?php echo $pages;?></div><script>window.top.$("#display_center_id").css("display","none");</script>
</form>
</div>
</body>
</html>
<script type="text/javascript">

</script>