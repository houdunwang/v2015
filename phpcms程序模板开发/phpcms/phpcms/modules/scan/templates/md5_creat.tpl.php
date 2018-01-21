<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?><style type="text/css">
<!--
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
.showMsg h5{background-image:color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:10px 12px 10px 12px; font-size:14px; height:100px; line-height:96px}
-->
</style>
<link href="<?php echo CSS_PATH?>progress_bar.css" rel="stylesheet" type="text/css" />
<div class="showMsg" style="text-align:center">
	<h5><?php echo L('generate_progress')?></h5>
    <div class="content">
    	<?php echo $msg?>
    </div>
</div>
</body>
</html>