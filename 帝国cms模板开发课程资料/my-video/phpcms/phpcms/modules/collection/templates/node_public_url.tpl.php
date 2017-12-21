<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li class="on" id="tab_1"><?php echo L('url_list')?></li>
</ul>
<div class="content pad-10" id="show_div_1" style="height:auto">
<?php while ($pagesize_start <= $pagesize_end):?>
<?php echo str_replace('(*)', $pagesize_start, $urlpage);$pagesize_start=$pagesize_start+$par_num;?>
<hr size="1" />
<?php endwhile;?>
</div>
</div>
</div>
</body>
</html>