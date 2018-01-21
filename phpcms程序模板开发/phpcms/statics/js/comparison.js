Array.prototype.in_array = function(e){
	for(i=0;i<this.length && this[i]!=e;i++);
	return !(i==this.length);
}
function remove_all(){
	$("#checkbox :checkbox").attr("checked",false);
	$("#relation_text").html("");
	$.get(ajax_url, {m:'yp', c:'index', a:'pk', action:'remove', catid:catid, random:Math.random()});
	$("#relation").val("");
	c_sum();
};
$("#checkbox :checkbox").click(function (){
	var q = $(this),
		num = 4,
		id = q.val(),
		title = q.attr('title'),
		img = q.attr('img'),
		sid = 'v1'+id,
		relation_ids = $('#relation').val(),
		relation_ids = relation_ids.replace(/(^_*)|(_*$)/g, ""),
		r_arr = relation_ids.split('-');
	if($("#comparison").css("display")=="none"){
		$("#comparison").fadeIn("slow");
	}
	if(q.attr("checked")==false){
		$('#'+sid).remove();
		$.get(ajax_url, {m:'yp', c:'index', a:'pk', action:'reduce', id:id, catid:catid, random:Math.random()});
		if(relation_ids !='' ) {
			var newrelation_ids = '';
			$.each(r_arr, function(i, n){
				if(n!=id) {
					if(i==0) {
						newrelation_ids = n;
					} else {
						newrelation_ids = newrelation_ids+'-'+n;
					}
				}
			});
			$('#relation').val(newrelation_ids);
		}
		c_sum();
	}else{
		if(r_arr.in_array(id)){
			q.checked=false;
			alert("抱歉，已经选择了该信息");
			return false;
		}
		if(r_arr.length>=num){
			q.checked=false;
			alert("抱歉，您只能选择"+r_arr.length+"款商品对比");
			return false;
		}else{
			$.get(ajax_url, {m:'yp', c:'index', a:'pk', action:'add', id:id, title:title, thumb:img, catid:catid, random:Math.random()});
			var str = "<li style='display:none' id='"+sid+"'><img src="+img+" height='45'/><p>"+title+"</p><a href='javascript:;' class='close' onclick=\"remove_relation('"+sid+"',"+id+")\">X</a></li>";
			$('#relation_text').append(str);
			$("#"+sid).fadeIn("slow");
			if(relation_ids =='' ){
				$('#relation').val(id);
			}else{
				relation_ids = relation_ids+'-'+id;
				$('#relation').val(relation_ids);
			}
			c_sum();
			$('#'+sid+' img').LoadImage(true, 120, 60,'statics/images/s_nopic.gif');
		}
	}
});
function remove_relation(sid,id){
	$('#'+sid).remove();
	$.get(ajax_url, {m:'yp', c:'index', a:'pk', action:'reduce', id:id, catid:catid, random:Math.random()});
	$("#c_"+id).attr("checked",false);
	$("#c_h_"+id).attr("checked",false);
	var relation_ids = $('#relation').val(),
	r_arr = relation_ids.split('-'),
	newrelation_ids = '';
	if(relation_ids!=''){
		$.each(r_arr, function(i, n){
			if(n!=id) {
				if(i==0) {
					newrelation_ids = n;
				} else {
					newrelation_ids = newrelation_ids+'-'+n;
				}
			}
		});
		$('#relation').val(newrelation_ids);
	}
	c_sum();
	return false;
}
function comp_btn() {
	var relation_ids = $('#relation').val(),
		_rel = relation_ids.replace(/(^_*)|(_*$)/g, "");
	if($("#comp_num").text()>1){
		//alert(_rel);
		 window.open(ajax_url+"?m=yp&c=index&a=pk&catid="+catid+"&modelid="+modelid+"&pk="+_rel);
	}else{
		alert("请选择2~4个需要对比的商品！");
	}
};
function c_sum(){
	var relation_ids = $('#relation').val(),
		relation_ids = relation_ids.replace(/(^_*)|(_*$)/g, ""),
		r_arr = relation_ids.split('-');
		if(relation_ids){
			$("#comp_num").text(r_arr.length);
		}else{
			$("#comp_num").text('0');
		}
}
//浮动
(function($) {
  $.fn.extend({
  	"followDiv": function(str) {
		var _self = this,
			_h = _self.height() ;
		var pos;
		switch (str) {
			case "right":
			pos = { "right": "0px", "top": "27px" };
			break;
		}
		topIE6 = parseInt(pos.top) + $(window).scrollTop();
		_self.animate({'top':topIE6},500);
	  	/*FF和IE7可以通过position:fixed来定位，*/
	  	//_self.css({ "position": "fixed", "z-index": "9999" }).css(pos);
	  	/*ie6需要动态设置距顶端高度top.*/
		// if ($.browser.msie && $.browser.version == 6) {
		//_self.css('position', 'absolute');
		$(window).scroll(function() {
			topIE6 = parseInt(pos.top) + $(window).scrollTop();
			//_self.css('top', topIE6);
			$(_self).stop().animate({top:topIE6},300)
		});
		// }
		return _self; //返回this，使方法可链。
		}
	});
})(jQuery);

$("body").append('<div id="comparison"><div class="title"><span id="comp_num">1</span>/4对比栏<a href="javascript:;" onclick="$(this).parent().parent().hide()" class="colse">X</a></div><input type="hidden" id="relation" value="" /><ul id="relation_text"></ul><center><a href="javascript:void(0);" onclick="comp_btn()" id="comp_btn">开始对比</a><br><a href="javascript:;" class="remove_all" onclick="remove_all();">清空对比栏</a></center></div>');
$("#comparison").followDiv("right");