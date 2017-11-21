$(document).ready(function() {
	var q = $("#q").val();
	var typeid = $("#typeid").val();
	search_history = getcookie('search_history');
	
	if(search_history!=null && search_history!='') {
		search_s = search_history.split(",");
		var exists = in_array(q+'|'+typeid, search_s);
		//不存在
		if(exists==-1) {
			if(search_s.length > 5) {
				search_history = search_history.replace(search_s[0]+',', "");
			}
			search_history += ','+q+'|'+typeid;
		}
		
		//搜索历史
		var history_html = '';
		for(i=0;i<search_s.length;i++) {
			var j = search_s.length - i - 1;
			search_s_arr = search_s[j].split("|");
			var keyword = search_s_arr[0];
			var keywordtypeid = search_s_arr[1];
			history_html += '<li><a href="?m=search&c=index&a=init&typeid='+keywordtypeid+'&q='+keyword+'">'+keyword+'</a></li>';
		}
		$('#history_ul').html(history_html);
	} else {
		search_history = q+'|'+typeid;
	}

	setcookie('search_history', search_history, '1000');

	function in_array(v, a) {
		var i;
		for(i = 0; i < a.length; i++) {
			if(v === a[i]) {
				return i;
			}
		}
		return -1;
	}
});