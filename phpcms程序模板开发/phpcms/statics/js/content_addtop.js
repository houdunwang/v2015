var userAgent = navigator.userAgent.toLowerCase();
jQuery.browser = {
	version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [0,'0'])[1],
	safari: /webkit/.test( userAgent ),
	opera: /opera/.test( userAgent ),
	msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
	mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
};

function thumb_images(uploadid,returnid) {
	var d = window.top.art.dialog({id:uploadid}).data.iframe;
	var in_content = d.$("#att-status").html().substring(1);
	if(in_content=='') return false;
	if(!IsImg(in_content)) {
		alert('选择的类型必须为图片类型');
		return false;
	}
	if($('#'+returnid+'_preview').attr('src')) {
		$('#'+returnid+'_preview').attr('src',in_content);
	}
	$('#'+returnid).val(in_content);
}

function change_images(uploadid,returnid){
	var d = window.top.art.dialog({id:uploadid}).data.iframe;
	var in_content = d.$("#att-status").html().substring(1);
	var in_filename = d.$("#att-name").html().substring(1);
	var str = $('#'+returnid).html();
	var contents = in_content.split('|');
	var filenames = in_filename.split('|');
	$('#'+returnid+'_tips').css('display','none');
	if(contents=='') return true;
	$.each( contents, function(i, n) {
		var ids = parseInt(Math.random() * 10000 + 10*i); 
		var filename = filenames[i].substr(0,filenames[i].indexOf('.'));
		str += "<li id='image"+ids+"'><input type='text' name='"+returnid+"_url[]' value='"+n+"' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'> <input type='text' name='"+returnid+"_alt[]' value='"+filename+"' style='width:160px;' class='input-text' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"> <a href=\"javascript:remove_div('image"+ids+"')\">移除</a> </li>";
		});
	
	$('#'+returnid).html(str);
}

function change_videoes(uploadid, returnid) {
	var d = window.top.art.dialog({id:uploadid}).data.iframe;
	var in_content = d.$("#video-paths").html().substring(1);
	var in_filename = d.$("#video-name").html().substring(1);
	var in_vid = d.$("#video-ids").html().substring(1);
	var video_num = parseInt($("#key").val());
	var str = $('#'+returnid).html();
	var contents = in_content.split('|');
	var fields = uploadid.split('_');
	var field = fields[0];
	var filenames = in_filename.split('|');
	var vids = in_vid.split('|');
	$('#'+returnid+'_tips').css('display','none');
	if(contents=='') return true;
	$.each( contents, function(i, n) {
		if ($("#thumb").val()==''){
			$('#thumb').val(contents[i]);
			$('#thumb_preview').attr('src', contents[i]);
		}
		var ids = parseInt(Math.random() * 10000 + 10*i); 
		video_num = video_num + 1;
		var filename = filenames[i];
		str += "<li id=\"video_"+field+"_"+video_num+"\"><div class=\"r1\"><img src=\""+contents[i]+"\" width=\"132\" height=\"75\"><input type=\"text\" name=\""+field+"_video["+video_num+"][title]\" value=\""+filename+"\" class=\"input-text\"><input type='hidden' name='"+field+"_video["+video_num+"][videoid]' value='"+vids[i]+"'><div class=\"r2\"><span class=\"l\"><label>排序</label><input type='text' name='"+field+"_video["+video_num+"][listorder]' value='"+video_num+"' class=\"input-text\"></span><span class=\"r\"> <a href=\"javascript:remove_div('video_"+field+"_"+video_num+"')\">移除</a></span></li>";
		});
	$('#key').val(video_num);
	$('#'+returnid).html(str);
}

function change_multifile(uploadid,returnid){
	var d = window.top.art.dialog({id:uploadid}).data.iframe;
	var in_content = d.$("#att-status").html().substring(1);
	var in_filename = d.$("#att-name").html().substring(1);
	var str = '';
	var contents = in_content.split('|');
	var filenames = in_filename.split('|');
	$('#'+returnid+'_tips').css('display','none');
	if(contents=='') return true;
	$.each( contents, function(i, n) {
		var ids = parseInt(Math.random() * 10000 + 10*i); 
		var filename = filenames[i].substr(0,filenames[i].indexOf('.'));
		str += "<li id='multifile"+ids+"'><input type='text' name='"+returnid+"_fileurl[]' value='"+n+"' style='width:310px;' class='input-text'> <input type='text' name='"+returnid+"_filename[]' value='"+filename+"' style='width:160px;' class='input-text' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"> <a href=\"javascript:remove_div('multifile"+ids+"')\">移除</a> </li>";
		});
	$('#'+returnid).append(str);
}

function add_multifile(returnid) {
	var ids = parseInt(Math.random() * 10000); 
	var str = "<li id='multifile"+ids+"'><input type='text' name='"+returnid+"_fileurl[]' value='' style='width:310px;' class='input-text'> <input type='text' name='"+returnid+"_filename[]' value='附件说明' style='width:160px;' class='input-text'> <a href=\"javascript:remove_div('multifile"+ids+"')\">移除</a> </li>";	
	$('#'+returnid).append(str);
}

function set_title_color(color) {
	$('#title').css('color',color);
	$('#style_color').val(color);
}
//-----------------------
function check_content(obj) {
	if($.browser.msie) {
		CKEDITOR.instances[obj].insertHtml('');
		CKEDITOR.instances[obj].focusManager.hasFocus;
	}
	top.art.dialog({id:'check_content_id'}).close();
	return true;
}

function image_priview(img) {
	window.top.art.dialog({title:'图片查看',fixed:true, content:'<img src="'+img+'" />',id:'image_priview',time:5});
}
function remove_div(id) {
	$('#'+id).remove();
}

function input_font_bold() {
	if($('#title').css('font-weight') == '700' || $('#title').css('font-weight')=='bold') {
		$('#title').css('font-weight','normal');
		$('#style_font_weight').val('');
	} else {
		$('#title').css('font-weight','bold');
		$('#style_font_weight').val('bold');
	}
}
function ruselinkurl() {
        if($('#islink').attr('checked')=='checked') {
                $('#linkurl').attr('disabled',false); 
                var oEditor = CKEDITOR.instances.content;
                oEditor.insertHtml('　');
                return false;
        } else {
                $('#linkurl').attr('disabled','true');
        }
}
function close_window() {
	if($('#title').val() !='') {
	art.dialog({content:'内容已经录入，确定离开将不保存数据！', fixed:true,yesText:'我要关闭',noText:'返回保存数据',style:'confirm', id:'bnt4_test'}, function(){
				window.close();
			}, function(){
				
				});
	} else {
		window.close();
	}
	return false;
}


function ChangeInput (objSelect,objInput) {
	if (!objInput) return;
	var str = objInput.value;
	var arr = str.split(",");
	for (var i=0; i<arr.length; i++){
	  if(objSelect.value==arr[i])return;
	}
	if(objInput.value=='' || objInput.value==0 || objSelect.value==0){
	   objInput.value=objSelect.value
	}else{
	   objInput.value+=','+objSelect.value
	}
}

//移除相关文章
function remove_relation(sid,id) {
	var relation_ids = $('#relation').val();
	if(relation_ids !='' ) {
		$('#'+sid).remove();
		var r_arr = relation_ids.split('|');
		var newrelation_ids = '';
		$.each(r_arr, function(i, n){
			if(n!=id) {
				if(i==0) {
					newrelation_ids = n;
				} else {
				 newrelation_ids = newrelation_ids+'|'+n;
				}
			}
		});
		$('#relation').val(newrelation_ids);
	}
}
//显示相关文章
function show_relation(modelid,id) {
$.getJSON("?m=content&c=content&a=public_getjson_ids&modelid="+modelid+"&id="+id, function(json){
	var newrelation_ids = '';
	if(json==null) {
		alert('没有添加相关文章');
		return false;
	}
	$.each(json, function(i, n){
		newrelation_ids += "<li id='"+n.sid+"'>·<span>"+n.title+"</span><a href='javascript:;' class='close' onclick=\"remove_relation('"+n.sid+"',"+n.id+")\"></a></li>";
	});

	$('#relation_text').html(newrelation_ids);
}); 
}
//移除ID
function remove_id(id) {
	$('#'+id).remove();
}

function strlen_verify(obj, checklen, maxlen) {
	var v = obj.value, charlen = 0, maxlen = !maxlen ? 200 : maxlen, curlen = maxlen, len = strlen(v);
	for(var i = 0; i < v.length; i++) {
		if(v.charCodeAt(i) < 0 || v.charCodeAt(i) > 255) {
			curlen -= charset == 'utf-8' ? 2 : 1;
		}
	}
	if(curlen >= len) {
		$('#'+checklen).html(curlen - len);
	} else {
		obj.value = mb_cutstr(v, maxlen, true);
	}
}
function mb_cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = !dot ? '...' : '';
	maxlen = maxlen - dot.length;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
		if(len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}
function strlen(str) {
	return ($.browser.msie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}