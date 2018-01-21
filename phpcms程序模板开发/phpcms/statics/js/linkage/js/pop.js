function open_linkage(id,name,container,linkageid) {
	returnid= id;
	returnkeyid = linkageid;
	var content = '<div class="linkage-menu" style="width:600px"><h6><a href="javascript:;"  onclick="get_parent(this,0)" class="rt"><<返回主菜单</a><span>'+name+'</span> <a href="javascript:;" onclick="get_parent(this)" id="parent_'+id+'" parentid="0"><img src="statics/images/icon/old-edit-redo.png" width="16" height="16" alt="返回上一级" /></a></h6><div class="ib-a menu" id="ul_'+id+'">';
	for (i=0; i < container.length; i++)
	{
		content += '<a href="javascript:;" onclick="get_child(\''+container[i][0]+'\',\''+container[i][1]+'\',\''+container[i][2]+'\')">'+container[i][1]+'</a>';
	}
	content += '</div></div>';
	art.dialog({title:name,id:'edit_'+id,content:content,width:'422',height:'200',style:'none_icon ui_content_m'});
}
var level = 0;
function get_child(nodeid,nodename,parentid) {
	var content = container = '';
	var url = "api.php?op=get_linkage&act=ajax_getlist&parentid="+nodeid+"&keyid="+returnkeyid;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			level = 1;
			$.each(data, function(i,data){ 
				container = data.split(',');
				content += '<a href="javascript:;" onclick="get_child(\''+container[0]+'\',\''+container[1]+'\',\''+container[2]+'\')">'+container[1]+'</a>';	
			})
			$("#ul_"+returnid).html(content);
			get_path(container[2],returnid);
			$("#parent_"+returnid).attr('parentid',container[2]);
		} else {
			set_val(nodename,nodeid);
			$("input[name='info["+returnid+"]']").val(nodeid);
			//$("#"+returnid).after('<input type="hidden" name="info['+returnid+']" value="'+nodeid+'">');
			art.dialog({id:'edit_'+returnid}).close();
		}
	})
}

function get_parent(obj,parentid) {
	var linkageid = parentid ? parentid : $(obj).attr('parentid');
	var content = container = '';
	var url = "api.php?op=get_linkage&act=ajax_getlist&linkageid="+linkageid+"&keyid="+returnkeyid;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			$.each(data, function(i,data){ 
				container = data.split(',');
				content += '<a href="javascript:;" onclick="get_child(\''+container[0]+'\',\''+container[1]+'\',\''+container[2]+'\')">'+container[1]+'</a>';
			})
			get_path(container[2],returnid);
			$("#parent_"+returnid).attr('parentid',container[2]);
			$("#ul_"+returnid).html(content);

		} else {
			$("#"+returnid).val(nodename);
			art.dialog({id:'edit_'+returnid}).close();
		}
	})
}

function get_path(nodeid,returnid) {
	var show_path = '';
	var url = "api.php?op=get_linkage&act=ajax_getpath&parentid="+nodeid+"&keyid="+returnkeyid;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			$.each(data, function(i,data){ 
				show_path = data + " > " + show_path;
			})
			$("#parent_"+returnid).siblings('span').html(show_path);
		}
	})
}

function set_val(nodename,nodeid) {
	var path = $("#parent_"+returnid).siblings('span').html();
	if(level==0) $("#"+returnid).html(nodename);
	else $("#"+returnid).html(path+nodename);	
	var url = "api.php?op=get_linkage&act=ajax_gettopparent&linkageid="+nodeid+"&keyid="+returnkeyid;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			$("#city").val(data);
		}
	})	
	level = 0;
}	