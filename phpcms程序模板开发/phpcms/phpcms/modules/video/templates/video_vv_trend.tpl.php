<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jqplot/jquery.jqplot.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jqplot/examples.css" />  
<!-- BEGIN: load jqplot -->
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>jqplot/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>jqplot/jqplot.barRenderer.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>jqplot/jqplot.categoryAxisRenderer.js"></script>
<!-- END: load jqplot -->
<script class="code" type="text/javascript">
    $(document).ready(function(){
        //var s1 = [2, 6, 7, 10];
     //   var ticks = ['a', 'b', 'c', 'd'];
        var  ticks = [<?php echo $x;?>];
        var s1 = [<?php echo $y;?>];
        
        plot1 = $.jqplot('chart1', [s1], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
    });
</script>  
<div class="pad_10">
<div id="chart1" style="margin-top:5px; margin-left:5px; width:820px; height:400px;"></div>

</div>
 
</body>
</html> 