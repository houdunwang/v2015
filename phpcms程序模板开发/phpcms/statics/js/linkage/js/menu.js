function open_menu(id,name,container,file,path,title,key, func) {
	returnid= id;
	returnfile = file;
	returnname = name;
	returnfunc = func;
	var content = '<div class="linkage-menu"><h6><a href="javascript:;"  onclick="get_menu_parent(this,0,\''+path+'\', \''+title+'\', \''+key+'\')" class="rt"><<返回主菜单</a><span>'+name+'</span> <a href="javascript:;" onclick="get_menu_parent(this,\'\',\''+path+'\', \''+title+'\', \''+key+'\')" id="parent_'+id+'" parentid="0"><img src="statics/images/icon/old-edit-redo.png" width="16" height="16" alt="返回上一级" /></a></h6><div class="ib-a menu" id="ul_'+id+'">';
	for (i=0; i < container.length; i++)
	{
		content += '<a href="javascript:;" onclick="get_menu_child(\''+container[i][0]+'\',\''+container[i][1]+'\',\''+container[i][2]+'\',\''+path+'\',\''+title+'\',\''+key+'\')">'+container[i][1]+'</a>';
	}
	content += '</div></div>';
	art.dialog({title:name,id:'edit_'+id,content:content,width:'422',height:'200',style:'none_icon ui_content_m'});
}
var level = 0;
function get_menu_child(nodeid,nodename,parentid,path,title,key) {
	var content = container = '';
	var url = "api.php?op=get_menu&act=ajax_getlist&parentid="+nodeid+"&cachefile="+returnfile+"&path="+path+'&title='+title+'&key='+key;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			level = 1;
			$.each(data, function(i,data){ 
				container = data.split(',');
				content += '<a href="javascript:;" onclick="get_menu_child(\''+container[0]+'\',\''+container[1]+'\',\''+container[2]+'\',\''+path+'\',\''+title+'\',\''+key+'\')">'+container[1]+'</a>';	
			})
			$("#ul_"+returnid).html(content);
			get_menu_path(container[2],returnid,path);
			$("#parent_"+returnid).attr('parentid',parentid);
		} else {
			get_menu_val(nodename,nodeid,path);
			$("input[name='info["+returnid+"]']").val(nodeid);
			//$("#"+returnid).after('<input type="hidden" name="info['+returnid+']" value="'+nodeid+'">');
			art.dialog({id:'edit_'+returnid}).close();
		}
	})
}

function get_menu_parent(obj,parentid,path,title,key) {
	var linkageid = parentid ? parentid : $(obj).attr('parentid');
	var content = container = '';
	var url = "api.php?op=get_menu&act=ajax_getlist&parentid="+linkageid+"&cachefile="+returnfile+"&path="+path+'&title='+title+'&key='+key;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			$.each(data, function(i,data){ 
				container = data.split(',');
				content += '<a href="javascript:;" onclick="get_menu_child(\''+container[0]+'\',\''+container[1]+'\',\''+container[2]+'\',\''+path+'\',\''+title+'\',\''+key+'\')">'+container[1]+'</a>';
			})
			get_menu_path(container[2],returnid,path);
			$("#parent_"+returnid).attr('parentid',container[4]);
			$("#ul_"+returnid).html(content);

		} else {
			$("#"+returnid).val(nodename);
			art.dialog({id:'edit_'+returnid}).close();
		}
	})
}

function get_menu_path(nodeid,returnid,path) {
	var show_path = '';
	var url = "api.php?op=get_menu&act=ajax_getpath&parentid="+nodeid+"&keyid="+returnfile+'&path='+path;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
			$.each(data, function(i,data){ 
				if (data) {
					show_path += data+" > ";
				} else {
					show_path += returnname;
				}
			})
			$("#parent_"+returnid).siblings('span').html(show_path);
		}
	})
}

function get_menu_val(nodename,nodeid,cachepath) {
	var path = $("#parent_"+returnid).siblings('span').html();
	if(level==0) $("#"+returnid).html(nodename);
	else $("#"+returnid).html(path+nodename);	
	var url = "api.php?op=get_menu&act=ajax_gettopparent&id="+nodeid+"&keyid="+returnfile+'&path='+cachepath;
	$.getJSON(url+'&callback=?',function(data){
		if(data) {
		}
		if (returnfunc) {
			obj=new Object();
			obj.value = data;
			get_additional(obj);
		}
	})	
	level = 0;
}