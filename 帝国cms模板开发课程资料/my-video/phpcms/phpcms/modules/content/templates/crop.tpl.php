<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>		    
<script type="text/javascript" src="<?php echo JS_PATH?>crop/swfobject.js"></script>
<script>
			// 获取页面上的flash实例。
			// @param flashID 这个参数是：flash 的 ID 。本例子的flash ID是 "myFlashID" ，在本页面搜索一下 "myFlashID" 可看到。
			function getFlash(flashID) 
			{
				// 判断浏览器类型
				if (navigator.appName.indexOf("Microsoft") != -1) 
				{
					return window[flashID];
				} 
				else 
				{
					return document[flashID];
				}
			}
			
			// flash 上传图片完成时回调的函数。
			function uploadComplete(pic)
			{
				
				if(parent.document.getElementById('<?php echo $_GET['input']?>')) {
					var input = parent.document.getElementById('<?php echo $_GET['input']?>');
				} else {
					var input = parent.right.document.getElementById('<?php echo $_GET['input']?>');
				}
				<?php if (!empty($_GET['preview'])):?>
				if(parent.document.getElementById('<?php echo $_GET['preview']?>')) {
					var preview = parent.document.getElementById('<?php echo $_GET['preview']?>');
				} else {
					var preview = parent.right.document.getElementById('<?php echo $_GET['preview']?>');
				}
				<?php else:?>
				var preview = '';
				<?php endif;?>
				if(pic) {
					input.value = pic;
					if (preview) preview.src = pic;
				}
				window.top.art.dialog({id:'crop'}).close();
			}

			function uploadfile() {
				getFlash('myFlashID').upload();
			}
            var swfVersionStr = "10.0.0";
            var xiSwfUrlStr = "<?php echo JS_PATH?>crop/images/playerProductInstall.swf";
			
            var flashvars = {};
			// 图片地址
			flashvars.picurl = "<?php echo $picurl?>";
			// 上传地址，使用了 base64 加密
			flashvars.uploadurl = "<?php echo base64_encode("index.php?m=attachment&c=attachments&a=crop_upload&module=$module&catid=$catid&file=".urlencode($picurl));?>";
			
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "always";
            params.allowfullscreen = "true";
            var attributes = {};
            attributes.id = "myFlashID";
            attributes.name = "myFlashID";
            attributes.align = "middle";
            swfobject.embedSWF(
                "<?php echo JS_PATH?>crop/images/Main.swf", "flashContent", 
                "680", "480", 
                swfVersionStr, xiSwfUrlStr, 
                flashvars, params, attributes);
			<!-- JavaScript enabled so display the flashContent div in case it is not replaced with a swf object. -->
			swfobject.createCSS("#flashContent", "display:block;text-align:left;");
        </script>
    </head>
    <body>
        <div id="flashContent">
        	<p>
	        	To view this page ensure that Adobe Flash Player version 
				10.0.0 or greater is installed. 
			</p>
			<script type="text/javascript"> 
				var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
				document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
								+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
			</script> 
        </div>
	   	
       	<noscript>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="680" height="480" id="myFlashID">
                <param name="movie" value="<?php echo JS_PATH?>crop/images/Main.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#ffffff" />
                <param name="allowScriptAccess" value="always" />
                <param name="allowFullScreen" value="true" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?php echo JS_PATH?>crop/images/Main.swf" width="680" height="480">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#ffffff" />
                    <param name="allowScriptAccess" value="always" />
                    <param name="allowFullScreen" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                	<p> 
                		Either scripts and active content are not permitted to run or Adobe Flash Player version
                		10.0.0 or greater is not installed.
                	</p>
                <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
	    </noscript>
       </body>
       </html>
