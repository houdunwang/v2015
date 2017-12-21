<?php
defined('IN_ADMIN') or exit('No permission resources.');
?>
<form style="border: medium none;" id="voteform<?php echo $subjectid;?>" method="post" action="{APP_PATH}index.php?m=vote&c=index&a=post&subjectid=<?php echo $subjectid;?>">
 <dl>
      <dt><?php echo $subject;?></dt>
      </dl>
<dl>
<?php 
if(is_array($options))
{
$i=0;
foreach($options as $optionid=>$option){
$i++;
?>
<dd>
&nbsp;&nbsp;<input type="radio" value="<?php echo $option['optionid']?>" name="radio[]" id="radio">
<?php echo $option['option'];?> 
</dd>
<?php }}?>
<input type="hidden" name="voteid" value="<?php echo $subjectid;?>">
</dl> 
<p> &nbsp;&nbsp; <input type="submit" value="<?php echo L('submit')?>" name="dosubmit" />    &nbsp;&nbsp; <a href="<?php echo SITE_PROTOCOL.SITE_URL?>/index.php?m=vote&c=index&a=result&id=<?php echo $subjectid;?>"><?php echo L('vote_showresult')?></a> </p>
</form>