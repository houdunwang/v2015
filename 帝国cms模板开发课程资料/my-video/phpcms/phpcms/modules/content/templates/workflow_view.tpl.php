<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="workflow blue">
	<div class="col <?php if($steps==1) echo 'off';?>">
    	<div class="content fillet">
            <div class="title">
                <div class="fillet"><?php echo L('steps_1');?><span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span><span class="line"></span></div>
            </div>
            <div class="name"><?php echo $checkadmin1;?></div>
            <span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
        </div>
    </div>
    <div class="col <?php if($steps==2) echo 'off';?>" style="display:<?php if($steps<2) echo 'none';?>">
    	<div class="content fillet">
            <div class="title">
                <div class="fillet"><?php echo L('steps_2');?><span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span><span class="line"></span></div>
            </div>
            <div class="name"><?php echo $checkadmin2;?></div>
            <span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
        </div>
    </div>
	<div class="col <?php if($steps==3) echo 'off';?>" style="display:<?php if($steps<3) echo 'none';?>">
    	<div class="content fillet">
            <div class="title">
                <div class="fillet"><?php echo L('steps_3');?><span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span><span class="line"></span></div>
            </div>
            <div class="name"><?php echo $checkadmin3;?></div>
            <span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
        </div>
    </div>
    <div class="col <?php if($steps==4) echo 'off';?>" style="display:<?php if($steps<4) echo 'none';?>">
    	<div class="content fillet">
            <div class="title">
                <div class="fillet"><?php echo L('steps_4');?><span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span><span class="line"></span></div>
            </div>
            <div class="name"><?php echo $checkadmin4;?></div>
            <span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
        </div>
    </div>

</div>
</body>
</html>