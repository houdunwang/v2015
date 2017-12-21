<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<div class="pad_10">
<div class="table-list">
<form method="post" name="myform" id="myform" action="?m=admin&c=googlesitemap&a=set">
<input type="hidden" name="tabletype" value="phpcmstables" id="phpcmstables">
<table width="100%" cellspacing="0">
<thead>
  	<tr>
    	<th class="tablerowhighlight" colspan=2><?php echo L('google_info')?></th>
  	</tr>
</thead> 
	<tr> 
      <td align="right" width="100"><?php echo L('explain')?>: </td> 
      <td> 
<?php echo L('google_infos')?>
 </td> 
    </tr>
</table>     

<table width="100%" cellspacing="0">    
<thead>
  	<tr>
    	<th class="tablerowhighlight" colspan=2><?php echo L('google_sitemaps')?></th>
  	</tr>
</thead> 
  	<tr>
	    <td align="right" width="100"> <?php echo L('google_rate')?> : </td>
	    <td colspan=1>
		    <select name="content_priority">
		    <option value="1">1</option><option value="0.9">0.9</option>
		    <option value="0.8">0.8</option><option selected="" value="0.7">0.7</option>
		    <option value="0.6">0.6</option><option value="0.5">0.5</option>
		    <option value="0.4">0.4</option><option value="0.3">0.3</option>
		    <option value="0.2">0.2</option><option value="0.1">0.1</option>
		    </select>
		    <select name="content_changefreq">
		    <option value="always"><?php echo L('google_update')?></option><option value="hourly"><?php echo L('google_hour')?></option>
		    <option value="daily"><?php echo L('google_day')?></option><option selected="" value="weekly"><?php echo L('google_week')?></option>
		    <option value="monthly"><?php echo L('google_month')?></option><option value="yearly"><?php echo L('google_year')?></option>
		    <option value="never"><?php echo L('google_noupdate')?></option>
		    </select>
	    </td>
  	</tr>
   	<tr>
    <td  align="right"><?php echo L('google_nums')?> : </td>
    <td colspan=3>  
    <input type=text name="num" value="20" size=5>
    </td>
  	</tr> 
</table>

<table width="100%" cellspacing="0">    
<thead>
  	<tr>
    	<th class="tablerowhighlight" colspan=2><?php echo L('google_baidunews')?></th>
  	</tr>
</thead> 
<tr>
	    <td  align="right"><?php echo L('google_ismake')?> : </td>
	    <td colspan=1><input type="radio" name="mark" value="1" checked> <?php echo L('setting_yes')?> &nbsp; <input type="radio" name="mark" value="0"> <?php echo L('setting_no')?> &nbsp;</td>
  	</tr>
  	
  	<tr>
	    <td align="right" width="100"> <?php echo L('google_select_db')?> : </td>
<td colspan=1>
<select name='catids[]' id='catids'  multiple="multiple"  style="height:200px;" title="<?php echo L('push_ctrl_to_select','','content');?>">
<?php echo $string;?>
</select>

</td>
  	</tr> 
  	
  	<tr>
	    <td align="right" width="100"> <?php echo L('google_period')?> : </td>
	    <td colspan=1><input type=text name="time" value="40" size=20> </td>
  	</tr>
  	<tr>
	    <td align="right" width="100"> Email : </td>
	    <td colspan=3><input type=text name="email" value="phpcms@phpcms.cn" size=20></td>
  	</tr>
  	<tr>
	    <td align="right" width="100"> <?php echo L('google_nums')?> : </td>
	    <td colspan=3><input type=text name="baidunum" value="20" size=5> </td>
  	</tr>
   	 
  	<tr>
    	<th class="tablerowhighlight" colspan=2>
    	<br>
    	<input type="submit" name="dosubmit" value=" <?php echo  L('google_startmake')?> " class="button">
    	<br>
    	</th>
  	</tr>
</table>  
</form>
</div>
</div> 
</body> 
</html>
