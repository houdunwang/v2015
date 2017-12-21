    $(document).ready(function() {
        $("#q").suggest("?m=search&c=index&a=public_get_suggest_keyword&url="+encodeURIComponent('http://www.google.cn/complete/search?hl=zh-CN&q='+$("#q").val()), {
            onSelect: function() {
				alert(this.value);
			}
        });

	});

	var google={
		ac:{
			h:function(results){
				if(results[1].length > 0) {
					var data = '<ul>';
					for (var i=0;i<results[1].length;i++) {
						if(results[1][i]==null || typeof(results[1][i])=='undefined') {

						} else {
							data += '<li><a href="javascript:;" onmousedown="s(\''+results[1][i][0]+'\')">'+results[1][i][0]+'</a></li>';
						}
					}
					data += '</ul>';
					$("#sr_infos").html(data);
				} else {
					$("#sr_infos").hide();
				}
			}
		}
	};
	
	function s(name) {
		$("#q").val(name);
		window.location.href='?m=search&c=index&a=init&q='+name;
	}