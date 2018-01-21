 (function($){
	$.fn.mlnColsel=function(data,setting){
		var dataObj={"Items":[
			{"name":"mlnColsel","topid":"-1","colid":"-1","value":"-1","fun":function(){alert("undefined!");}}
		]};
		var settingObj={
			title:"请选择",
			value:"-1",
			width:100
		};
		
		settingObj=$.extend(settingObj,setting);
		dataObj=$.extend(dataObj,data);
		
		var $this=$(this);
		var $colselbox=$(document.createElement("a")).addClass("colselect").attr({"href":"javascript:;"});
		var $colseltext=$(document.createElement("span")).text(settingObj.title);
		var $coldrop=$(document.createElement("ul")).addClass("dropmenu");
		var selectInput = $.browser.msie?document.createElement("<input name="+$this.attr("id")+" />"):document.createElement("input");
 			selectInput.type="hidden";
 			selectInput.value=settingObj.value;
 			selectInput.setAttribute("name",'info['+$this.attr("id")+']');
		var ids=$this.attr("id");
		$this.onselectstart=function(){return false;};
		$this.onselect=function(){document.selection.empty()};
		$colselbox.append($colseltext);
		$this.addClass("colsel").append($colselbox).append($coldrop).append(selectInput);
		
		$(dataObj.Items).each(function(i,n){
			var $item=$(document.createElement("li"));
			if(n.topid==0){
				$coldrop.append($item);
				$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
			}else{
				if($("#col_"+ids+"_"+n.topid).find("ul").length<=0){
					$("#col_"+ids+"_"+n.topid).append("<ul class=\"dropmenu rootmenu\"></ul>");
					$("#col_"+ids+"_"+n.topid).find("ul:first").append($item);
					$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
				}else{
					$("#col_"+ids+"_"+n.topid).find("ul:first").append($item);
					$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
				}
			}			
		});
		
		$this.find("li").each(function(){
			$(this).click(function(event){
				$colselbox.children("span").text($(this).find("span:first").text());
				$(selectInput).val($(this).attr("values"));
				hideMenu();
				event.stopPropagation();
			});
			if($(this).find("ul").length>0){
				$(this).addClass("menuout");
				$(this).hover(function(){
						$(this).removeClass("menuout");
						$(this).addClass("menuhover");
						$(this).find("ul:first").fadeIn("fast")
					},function(){
						$(this).removeClass("menuhover");
						$(this).addClass("menuout");
						$(this).find("ul").each(function(){
							$(this).fadeOut("fast");
					});
				});
			}else{
				$(this).addClass("norout");
				$(this).hover(function(){
					$(this).removeClass("norout");
					$(this).addClass("norhover");
					},function(){
					$(this).removeClass("norhover");
					$(this).addClass("norout");
				});
			}
		});
		
		function hideMenu(){
			$this.bOpen=0;
			$(".rootmenu").hide();
			$coldrop.slideUp("fast");
			$(document).unbind("click",hideMenu);
		}
		function openMenu(){
			$coldrop.slideDown("fast");
			$this.bOpen=1;
		}
		$colselbox.click(function(event){
      $(this).blur();
			if($this.bOpen){
				hideMenu();
			}else{
				openMenu();
				$(document).bind("click",hideMenu);
			}
			event.stopPropagation();
		});
		$(".rootmenu").each(function(){
			
			$(this).css({"left":135+"px"});
		});	
	}
 })(jQuery);