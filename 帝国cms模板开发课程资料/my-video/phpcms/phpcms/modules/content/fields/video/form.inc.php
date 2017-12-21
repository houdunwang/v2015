
	function video($field, $value, $fieldinfo) {
		$value_data = '';
		//获取flash上传属性
		pc_base::load_app_class('ku6api', 'video', 0);
		$setting = getcache('video', 'video');
		if(empty($setting)) return L('please_input_video_setting');
		$ku6api = new ku6api($setting['sn'], $setting['skey']);
		$flash_info = $ku6api->flashuploadparam();
		
		//获取上传的视频
		$key = 0;
		$list_str = "<div style='padding:1px'><ul class=\"tbsa\" id=\"video_{$field}_list\">";
		if($value) {
			$video_content_db = pc_base::load_model('video_content_model');
			$video_store_db = pc_base::load_model('video_store_model');
			$videos = $video_content_db->select(array('contentid'=>$this->id), 'videoid, listorder', '', '`listorder` ASC', '', 'videoid');
			if (!empty($videos)) {
				$videoids = '';
				foreach ($videos as $v) {
					$videoids .= $v['videoid'].',';
				}
				$videoids = substr($videoids, 0, -1);
				$result = $video_store_db->select("`videoid` IN($videoids)", '`videoid`, `title`, `picpath`', '', '', '', 'videoid');
				if (is_array($result)) {
					//首先对$result按照$videos的videoid排序
					foreach ($videos as $_vid => $v) {
						$new_result[] = $result[$_vid];
					}
					unset($result, $_vid, $v);
					foreach ($new_result as $_k => $r) {
						$key = $_k+1;
						$picpath = $r['picpath'] ? $r['picpath'] : IMG_PATH.'nopic.gif';
						$list_str .= "<li class=\"ac\" id=\"video_{$field}_{$key}\"><div class=\"r1\"><img src=\"{$r['picpath']}\" onerror=\"".IMG_PATH."nopic.jpg\" width=\"132\" height=\"75\"><input type='text' name='{$field}_video[{$key}][title]' value='".$r['title']."' class=\"input-text ipt_box\"><input type='hidden' name='{$field}_video[{$key}][videoid]' value='{$r[videoid]}'><div class=\"r2\"><span class=\"l\"><label>".L('listorder')."</label><input type='text' name='{$field}_video[$key][listorder]' value='".$videos[$r['videoid']]['listorder']."' class=\"input-text\"></span><span class=\"r\"> <a href=\"javascript:remove_div('video_{$field}_{$key}')\">".L('delete')."</a></span></li>";
					}
				}
			}
		}
		$list_str .= "</ul></div>";
		$data = '';
		if (!defined('SWFOBJECT_INIT')) {
			$data .= '<script type="text/javascript" src="'.JS_PATH.'video/swfobject2.js"></script>';
			$data .= '<script type="text/javascript" src="'.JS_PATH.'video/vod2ckedit.js"></script>';
			define('SWFOBJECT_INIT', 1);
			$data .= '<SCRIPT LANGUAGE="JavaScript">

<!--

var js4swf = {

    onInit: function(list)

    {

        // 初始化时调用, 若 list.length > 0 代表有可续传文件

        // [{file}, {file}]

if(list.length > 0) {

    var length = list.length-1;

$("#list_name").html("'.L('file', '', 'video').'"+list[length].name+"'.L('failed_uplaod_choose_again', '', 'video').'");

}

        this.showMessage("init", list);

    },

    onSelect: function(files)

    {

        // 选中文件后调用, 返回文件列表

        // [{file}, {file}]

        this.showMessage("select", files);

    },

    onSid: function(evt)

    {

        // 获得 sid 后返回, 更新 sid 用 (key, sid, name, type, size)

$("#video_title").val(evt.name);
		var ku6vid = evt.vid;
		$.get(\'index.php\', {m:\'video\', c:\'vid\', a:\'check\', vid:ku6vid});
        this.showMessage("sid", evt);

    },

    onStart: function()

    {

        // 开始上传 (选择文件后自动开始)

        this.showMessage("start");

    },

    onCancel: function()

    {

        // 上传取消事件



        this.showMessage("cancel");

    },

    onProgress: function(evt)

    {

        // 上传进度事件 (bytesLoaded, bytesTotal, speed) m=1 时没有这事件

        this.showMessage("progress", evt);

    },

    onComplete: function(evt)

    {

        // 上传完成事件 (包含文件信息和完成后返回数据(data))
$("#vid").val(evt.vid);
var video_num = parseInt($("#key").val()) + 1;
var title = $("#video_title").val();
var vid = $("#vid").val();
var html = "<li id=\"video_'.$field.'_"+video_num+"\"><div class=\"r1\"><img src=\"'.IMG_PATH.'nopic.jpg\" width=\"132\" height=\"75\"><input type=\"text\" name=\"'.$field.'_video["+video_num+"][title]\" value=\""+title+"\" class=\"input-text\"><input type=\"hidden\" name=\"'.$field.'_video["+video_num+"][vid]\" value=\""+vid+"\"><div class=\"r2\"><span class=\"l\"><label>'.L('listorder').'</label><input type=\"text\" class=\"input-text\" name=\"'.$field.'_video["+video_num+"][listorder]\" value=\""+video_num+"\" ></span><span class=\"r\"> <a href=\"javascript:remove_div(\'video_'.$field.'_"+video_num+"\')\">'.L('delete').'</a></span></li>";

$("#video_'.$field.'_list").append(html);
$("#key").val(video_num);
$("#video_title").val("");

swfobject.embedSWF("'.$flash_info['flashurl'].'", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);


//document.getElementById("frm").submit();

        this.showMessage("complete", evt);

        

    },

    onWarn: function(evt)

    {

        // 报错事件 (key, message)

        //this.showMessage("warn", evt);

alert(evt.msg);

    },

    showMessage: function()

    {

        console.log(arguments);

    }

};

//-->

</SCRIPT>
<script type="text/javascript">
var flashvars = { m: "1", u: "'.$flash_info['userid'].'", ctime: "'.$flash_info['passport_ctime'].'", sig:"'.$flash_info['passport_sig'].'", c: "vms", t: "1", n: "js4swf", k: "190000" ,ms:"39",s: "8000000"};
var params = { allowScriptAccess: "always" , wmode: "transparent"};
var attributes = { };
//swfobject.embedSWF("http://player.ku6cdn.com/default/podcast/upload/201104261840/ku6uploader.swf", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
swfobject.embedSWF("'.$flash_info['flashurl'].'", "ku6uploader", "450", "45", "10.0.0", null, flashvars, params, attributes);
</script>';
		}
		$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
		$video_store_sel = defined('IN_ADMIN') ? '<div class="picBut cu video_btn" style="float:right; margin-top:10px;"><a herf="javascript:void(0);" onclick="javascript:video_store_select(\''.$field.'_videoes\', \''.L('choose_videoes').'\',\'video_'.$field.'_list\',change_videoes, \''.$_GET['pc_hash'].'\')"> '.L('videoes_store').' </a></div>' : '';
		$vms_str = $flash_info['allow_upload_to_vms'] ? '<label class="ib cu" style="width:125px"><input type="radio" name="channelid" value="2">'. L('upload_to_ku6vms', '', 'video').' </label>' : '';
		return $data.'<input name="info['.$field.']" type="hidden" value="1"><input type="hidden" id="key" value="'.$key.'"><fieldset class="blue pad-10">
        <legend>'.L('videoes_lists').'</legend><center><div class="onShow" id="nameTip">'.L('videoes_num').'</center><div id="videoes" class="picList">'.$list_str.'</div>
		</fieldset>
		
		<table width="100%" border="0" cellspacing="1" class="tbb">
    <tbody><tr>
      <td width="15%" height="40">'.L('select_upload_channel', '', 'video').'</td>
      <td height="40"><label class="ib cu" style="width:125px"><input type="radio" name="channelid" value="1" checked> '.L('upload_to_ku6').' </label>'.$vms_str.'
	  </td>
    </tr>
	<tr>
      <td width="15%" height="40"><div align="right" ><input class="input_style" type="text" value="'.L('video_title', '', 'video').'" name="video_title" id="video_title" size="10"></div></td>
      <td height="40">
	  '.$video_store_sel.'
	  <div id="ku6uploader"></div><BR><span id="list_name" style="color:red"></span></td><input type="hidden" id="vid" name="vid" value="">
    </tr>
  </tbody></table>';
	}