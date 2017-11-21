<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="video" name="m">
<input type="hidden" value="video" name="c">
<input type="hidden" value="import_ku6video" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<?php echo L('import_ku6video');?>：
<?php echo L('ku6video_fenlei');?>：
<select name="fenlei">
<option value=""><?php echo L('all');?></option>
<?php foreach($fenlei_array as $key=>$values) { ?>
<option value="<?php echo $key;?>" <?php if($key==$fenlei){echo 'selected';}?>><?php echo $values;?></option>
<?php } ?> 
</select>

<?php echo L('ku6video_srctype');?>：
<select name="srctype">
<option value=""><?php echo L('all');?></option>
<?php foreach($srctype_array as $key=>$values) { ?>
<option value="<?php echo $key;?>" <?php if($key==$srctype){echo 'selected';}?>><?php echo $values;?></option>
<?php } ?>  
</select>
<?php echo L('ku6video_time');?>：
<select name="videotime">
<option value=""><?php echo L('all');?></option>
<?php foreach($videotime_array as $key=>$values) { ?>
<option value="<?php echo $key;?>" <?php if($key==$videotime){echo 'selected';}?>><?php echo $values;?></option>
<?php } ?> 
</select>
<?php echo L('keyword_name','','admin');?>：<input type="text" value="<?php echo $_GET['keyword']?>" class="input-text" name="keyword"> 
 
<input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
</div>
</form>
 
 <form name="myform" id="myform" action="index.php?m=video&c=import&a=doimport&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
 			<th width="100"><?php echo L('thumb','','content');?></th>
			<th><?php echo L('title');?></th>
			<th width="300"><?php echo L('intro');?></th>
            <th width="130"><?php echo L('ku6video_ku6vid');?> / <?php echo L('addtime','','content');?></th>
            <th width="90"><?php echo L('moduleauthor','','admin');?></th>
            
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($list)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		$i=1;
		foreach ($list as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
	?>
        <tr>
		<td align="center">
		<input type="hidden" name="importdata[<?php echo $i; ?>][vid]" value="<?php echo $r['vid'];?>">
 		<input type="hidden" name="importdata[<?php echo $i; ?>][desc]" value="<?php echo $r['desc'];?>">
		<input type="hidden" name="importdata[<?php echo $i; ?>][size]" value="<?php echo $r['size'];?>">
		<input type="hidden" name="importdata[<?php echo $i; ?>][timelen]" value="<?php echo $r['videotime'];?>"> 
		<input type="hidden" name="importdata[<?php echo $i; ?>][picpath]" value="<?php  if(!preg_match("/^http/",$r['picpath'])){
            echo 'http://'.$r['picpath'];
          }else{
          echo $r['picpath'];
          }?>">
		<input type="hidden" name="importdata[<?php echo $i; ?>][tag]" value="<?php echo $r['tag'];?>">
		<input type="hidden" name="importdata[<?php echo $i; ?>][status]" value="<?php echo $r['status'];?>">
		<input type="hidden" id="space_<?php echo $r['vid'];?>" value="<?php echo $r['size'];?>">
		<input type="hidden" id="time_<?php echo $r['vid'];?>" value="<?php  echo $r['videoTime'];?>">
		<input class="inputcheckbox " name="ids[]" value="<?php echo $r['vid'];?>" type="checkbox">
		</td>
 		<td><a href="javascript:void(0)" onclick="preview('<?php echo $r[vid];?>','<?php echo $r['title'];?>')" title="<?php echo L('ku6video_priview');?>"><img src="<?php  if(!preg_match("/^http/",$r['picpath'])){
            echo 'http://'.$r['picpath'];
          }else{
          echo $r['picpath'];
          }?>" style="margin-right: 6px;" width="132" height="99"></a></td>
		<td>
		<ul class="title_ul">
		<li><input type="text" size="30" title="<?php  echo L('ku6video_edittitle');?>" value="<?php echo $r[title];?>" class="input-text" name="importdata[<?php echo $i; ?>][title]">  
		</li>
		<li><font color="red"><?php echo $r['ku6video_time']?>：<?php echo $r['videotime']?>秒 大小： 
		<?php 
		if(number_format($r['size']/1024/1024, 2, '.', '') == '0.00') { 
			echo number_format($r['size']/1024, 2, '.', '').' KB';
		}else{ 
			echo number_format($r['size']/1024/1024, 2, '.', '').' MB';
		}  
		?> 
	</font></li>
		</ul>
		 
		</td>
		<td align='left'><?php echo $r['desc'];?><?php //echo format::date($r['uploadtime'],1);?></td>
		<td align='center'><?php echo $r['vid'];?><br><?php $time = substr($r['uploadtime'],0,10); echo date("Y-m-d H:i",$time);?></td>
		<td align='center'><?php echo $r['nick']?></td>
		</tr>
     <?php $i++;} }
 	 ?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
		<input type="hidden" value="<?php echo $_GET['fenlei'];?>" name="fenlei">
		<input type="hidden" value="<?php echo $_GET['srctype'];?>" name="srctype">
		<input type="hidden" value="<?php echo $_GET['videotime'];?>" name="videotime">
		<input type="hidden" value="<?php echo $_GET['keyword'];?>" name="keyword">
		<input type="hidden" value="<?php echo $_GET['menuid'];?>" name="menuid">
		<input type="hidden" value="<?php echo $_GET['page'];?>" name="page">
		
		<input type="radio" name="is_category" value="0" checked="1" id="no_category" onclick="$('#show_category').css('display','none');">只入库
 		<input type="radio" name="is_category" value="1" id="yes_category" onclick="$('#show_category').css('display','');">
		导入栏目&nbsp; &nbsp;
		<span id="show_category" style="display:none;"> 
		 &nbsp; 
		<span id="category">
		<?php echo $categoryrr;?>
		</span>
		&nbsp; 指定推荐位：
		<span id="posid"></span>
		</span>
		<input name="dosubmit" type="button" value="<?php echo L('import_select_ku6video');?>" class="button" onclick="check_sbumit();">  
		
	</div>
   <div id="pages"><?php echo pages($totals,$page,$pagesize);?></div>
</div>
</form>

 
 </div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
//检查选中
function check_sbumit() {
	var str = 0;
	var id = tag = '';
	var is_category = 0;
	is_category = $("input[name='is_category']:checked").val();
 	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1; 
		}
	});
	if(str==0) {
		alert('您没有勾选信息');
		return false;
	}
 	if(is_category==1){//选择栏目
		if($("#siteid").val()==0 || $("#select_category").val()==0){
			alert('请选择要导入的栏目！');
			return false;
		} 
	} 
 	document.myform.submit(); 
}

//指定导入推荐位
function select_pos(obj) {
	var catid = obj.value;
	if (catid == 0) {
		return false;
	}
	var hash = '<?php echo $_GET['pc_hash']?>';
	$('#posid').html('<img src="<?php echo IMG_PATH.'msg_img/loading.gif';?>">');
	$.get("index.php", {m:'video', c:'video', a:'public_get_pos', catid:catid, tm:Math.random(), pc_hash:hash}, function (data) {
		if (data) {
			$('#posid').html(data);
		} else {
			alert('<?php echo L('check_choose_cat')?>');
		}
	} );
}

//预览视频
function preview(vid, name) {
	window.top.art.dialog({id:'preview'}).close();
	window.top.art.dialog({title:'预览 '+name+' ',id:'preview',iframe:'?m=video&c=video&a=preview_ku6video&ku6vid='+vid,width:'530',height:'400'}, '', function(){window.top.art.dialog({id:'preview'}).close()});
}

function discount(id, name) {
	window.top.art.dialog({title:'<?php echo L('discount')?>--'+name, id:'discount', iframe:'?m=pay&c=payment&a=discount&id='+id ,width:'500px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'discount'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'discount'}).close()});
}
function detail(id, name) {
	window.top.art.dialog({title:'<?php echo L('discount')?>--'+name, id:'discount', iframe:'?m=pay&c=payment&a=public_pay_detail&id='+id ,width:'500px',height:'550px'});
}
 
//-->
</script>