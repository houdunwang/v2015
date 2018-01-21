<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?> 
<div class="pad_10">
<embed id="video_player" name="video_player" src="<?php echo $data['playerurl'];?>" height="360" width="490" quality="high" align="middle" allowscriptaccess="always" allowfullscreen="true" flashvars="auto=1&amp;api=1&amp;adss=0" type="application/x-shockwave-flash">
</div>
 
</body>
</html> 