<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="video" name="m">
<input type="hidden" value="stat" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">

<a href="?m=video&c=stat&a=init&type=today&start_time=<?php echo date("Y-m-d");?>&end_time=<?php echo date("Y-m-d",strtotime("+1 day"));?>"><?php echo L('today_vv');?></a>  &nbsp;&nbsp;&nbsp; <a href="?m=video&c=stat&a=init&type=yestoday&start_time=<?php echo date("Y-m-d",strtotime("-1 day"));?>&end_time=<?php echo date("Y-m-d");?>"><?php echo L('yestoday_vv');?></a> &nbsp;&nbsp;&nbsp; <a href="?m=video&c=stat&a=init&type=week&start_time=<?php echo date("Y-m-d",strtotime("-1 week"));?>&end_time=<?php echo date("Y-m-d"); ?>"><?php echo L('this_week_vv');?></a> &nbsp;&nbsp;&nbsp; <a href="?m=video&c=stat&a=init&type=month&start_time=<?php echo date("Y-m-d",strtotime("last month"));?>&end_time=<?php echo date("Y-m-d");?>"><?php echo L('this_month_vv');?></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?m=video&c=stat&a=vv_trend&start_time=<?php echo date("Y-m-d",strtotime("last month"));?>&end_time=<?php echo date("Y-m-d");?>"></a>

<a href="javascript:void(0);" onclick="video_vv_trend()"><?php echo L('vv_trend');?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
<?php echo L('时间段查看统计');?>  <?php echo form::date('start_time',$start_time)?>  至 <?php echo form::date('end_time',$end_time)?> <input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit"> 

&nbsp;&nbsp;&nbsp;
<?php echo L('search_video');?> ： 
<select name="search_type" id="search_type">
<option value="2" <?php if ($_GET['type']==2) {?>selected<?php }?>><?php echo L('video_title')?></option>
<option value="1" <?php if ($_GET['type']==1) {?>selected<?php }?>><?php echo L('video_id');?></option>
</select> 
<input type="text" value="<?php echo $_GET['keyword']?>" class="input-text" name="keyword" id="keyword"> 
 &nbsp;&nbsp;
<input type="button" value="<?php echo L('search')?>" onclick="search_video_stat()" class="button" name="search">
</div>
</form>
 
    <table width="100%" cellspacing="0">
        <thead>
            <tr> 
            <th width="5%">VID</th>
            <th><?php echo L('video_title')?></th>
            <th width="10%"><?php echo L('vv_total')?></th>
            <th width="8%"><?php echo L('today')?></th>
            <th width="8%"><?php echo L('yestoday');?></th>
            <th width="8%"><?php echo L('this_week')?></th>
            <th width="8%"><?php echo L('this_month')?></th>
            <th width="10%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
		$status_arr = pc_base::load_config('ku6status_config');
?>   
	<tr> 
	<td align="center"><?php echo $info['vid']?></td>
	<td><a href="javascript:void(0);" onclick="view_video_stat('<?php echo $info['vid']?>','<?php echo $info['title'];?>')"><?php echo $info['title']?></a>  </td>
	<td align="center"><?php echo $info['allvv'];?></td>
	<td align="center"><?php echo $info['vv'];?></td>
	<td align="center"><?php echo $info['yestoday_vv'];?></td>
	<td align="center"><?php echo $info['week_vv'];?></td>
	<td align="center"><?php echo $info['month_vv'];?></td>
	<td align="center"><a href="javascript:void(0);" onclick="view_video_stat('<?php echo $info['vid']?>','<?php echo $info['title'];?>')"><?php echo L('查看详情')?></a>  </td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
<div class="btn text-l"><input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
	 
</div>
 <div id="pages"> <?php echo $pages?></div>
</div>
</div> 
</body>
</html>
<script type="text/javascript">
<!--
function view_video_stat(vid,title) {
	window.top.art.dialog({title:title+' 视频近30日播放量走势图', id:'view', iframe:'?m=video&c=stat&a=show_video_stat&vid='+vid ,width:'780px',height:'450px'});
}
//总体趋势图
function video_vv_trend() {
	window.top.art.dialog({title:'近20日视频总体播放量走势图', id:'view', iframe:'?m=video&c=stat&a=vv_trend' ,width:'890px',height:'450px'});
}
//提交指定URL
function search_video_stat(){
	document.searchform.action = "<?php ECHO APP_PATH;?>index.php?m=video&c=stat&a=search_video_stat";
	document.searchform.method = "post";
	document.searchform.submit();
}
//-->
</script>