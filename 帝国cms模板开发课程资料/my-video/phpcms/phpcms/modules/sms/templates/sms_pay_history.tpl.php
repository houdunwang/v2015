<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<form name="myform" action="?m=admin&c=position&a=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
             <th width="5%" align="center"><?php echo L('id')?></th>
			 <th width="10%"><?php echo L('mobile')?></th>
			 <th width="5%"><?php echo L('id_code')?></th>
			 <th ><?php echo L('msg')?></th>
			 <th ><?php echo L('send_userid')?></th>
			 <th ><?php echo L('return_id')?></th>
			 <th ><?php echo L('status')?></th>		 
			 <th><?php echo L('ip')?></th>
             <th><?php echo L('posttime')?></th>
            </tr>
        </thead>
    <tbody>
<?php 
if(is_array($paylist_arr)) foreach($paylist_arr as $info){
?>
	<tr>
	<td width="5%" align="center"><?php echo $info['id']?></td>
	<td width="10%" align="center"><?php echo $info['mobile']?></td>
	<td width="5%" align="center"><?php echo $info['id_code']?></td>
	<td align="left"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['msg']);}else{ echo $info['msg'];}?></td>
	<td  align="center"><?php echo $info['sms_uid']?></td>	
	<td  align="center"><?php echo CHARSET=="gbk" ? iconv('utf-8','gbk',$info['return_id']) : $info['return_id'];?></td>
	<td align="center"><?php echo sms_status($info['status']);?></td>
	<td align="center"><?php echo $info['ip']?></td>
	<td align="center"><?php echo format::date($info['posttime'],1)?></td>
	</tr>
<?php 

}
?>
    </tbody>
    </table>
  
    <div class="btn"></div>  </div>

 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>