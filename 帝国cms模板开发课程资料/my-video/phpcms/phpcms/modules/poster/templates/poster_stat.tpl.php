<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('ads_module')?></h2>  
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="?m=poster&c=poster&a=init&spaceid=<?php echo $info['spaceid'];?>"><em><?php echo L('ad_list')?></em></a>　<a class="on" href="?m=poster&c=space"><em><?php echo L('space_list')?></em></a></div>
</div>
<div class="pad-lr-10">
<div class="col-tab">
        <ul class="tabBut cu-li">
        	
            <li<?php if($_GET['click']) {?> class="on"<?php }?>><a href="?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=1"><?php echo L('hits_stat')?></a></li>
            <li<?php if($_GET['click']==0){?> class="on"<?php }?>><a href="?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=0"><?php echo L('show_stat')?></a></li><li style="background:none; border:none;"><?php if(is_numeric($_GET['click'])) {?><strong><a href="?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&group=area"><?php echo L('listorder_f_area')?></a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><a href="?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&group=ip"><?php echo L('listorder_f_ip')?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php }?>
<input name='range' type='radio' value='' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>')" <?php if(!$_GET['range']) {?>checked<?php }?>> <?php echo L('all')?>
<input name='range' type='radio' value='1' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&range='+this.value)" <?php if($_GET['range']==1) {?>checked<?php }?>> <?php echo L('today')?>
<input name='range' type='radio' value='2' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&range='+this.value)" <?php if($_GET['range']==2) {?>checked<?php }?>> <?php echo L('yesterday')?>
<input name='range' type='radio' value='7' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&range='+this.value)" <?php if($_GET['range']==7) {?>checked<?php }?>> <?php echo L('one_week')?>
<input name='range' type='radio' value='14' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&range='+this.value)" <?php if($_GET['range']==14) {?>checked<?php }?>> <?php echo L('two_week')?>
<input name='range' type='radio' value='30' onclick="redirect('?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&range='+this.value)" <?php if($_GET['range']==30) {?>checked<?php }?>> <?php echo L('one_month')?> <font color="red"><?php echo L('history_select')?>：</font><select name="year" onchange="if(this.value!=''){location='?m=poster&c=poster&a=stat&id=<?php echo $_GET['id']?>&click=<?php echo $_GET['click']?>&pc_hash=<?php echo $_GET['pc_hash']?>&group=<?php echo $_GET['group']?>&year='+this.value;}">
<?php echo $selectstr;?></select></li>
        </ul>
            <div class="content pad-10">
                <?php if(is_numeric($_GET['click']) && $_GET['group']) {?>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <?php if($_GET['group']=='ip') {?>
            <th width="30%" align="center"><?php echo L('browse_ip')?></th><?php }?>
			<th width="30%" align="center"><?php echo L('for_area')?></th>
			<th width="30%" align="center"><?php echo L('show_times')?></th>
            </tr>
        </thead>
    </table>
    <table width="100%" class="contentWrap">
 <?php 
if(is_array($data)){
	foreach($data as $info){
?>   
	<tr>
	<?php if($_GET['group']=='ip') {?>
	<td align="center" width="30%"><?php echo $info['ip']?></td><?php }?>
	<td align="center" width="30%">
	<?php echo $info['area']?>
	</td>
	<td align="center" width="30%"><?php echo $info['num']?></td>
	</tr>
<?php 
	}
}
?>
    </table>  </div>
 <div id="pages"><?php echo $pages?></div>
<?php } else {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
      <tr>
       <td style="padding-top:2px;padding-left:6px;padding-right:6px;padding-bottom:8px;">
        <table width="100%" border="1" class="contentWrap" bordercolor="#dddddd" cellpadding="0" cellspacing="0">
          <?php if(is_array($data)) { foreach($data as $k => $v) {?>
          <tr>
           <td width="24" align="center"><?php echo intval($k+1);?></td>
           <td style="padding:5px;"><div><span>
           <b>IP：<?php echo $v['ip']?></b> ( <b><?php echo $v['area']?></b> )</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo L('come_from')?>： <a href="<?php echo $v['referer']?>" target="_blank">
          <?php echo $v['referer']?></a></div>
         <div><span class="item"><?php echo L('visit_time')?>：<em><?php echo format::date($v['clicktime'], 1);?></em></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo L('operate')?>：<?php if($v['type']) { echo L('click'); } else { echo L('show'); }?></div></td>
         </tr>
        <?php } }?>
       </table>
      </td>
    </tr>
    <tr>
     <td><div id="pages"><?php echo $pages;?></div></td>
    </tr>
</table>
<?php } ?>
            </div>
</div>
</div>
</body>
</html>